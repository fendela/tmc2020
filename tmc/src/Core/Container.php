<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Tmc\TmcRepository;
use App\Tmc\TournamentRepository;
use App\Tmc\GroupRepository;
use App\Tmc\TableRepository;
use App\Tmc\ScheduleRepository;
use App\Tmc\HistoryRepository;
use App\Tmc\TeamRepository;
use App\Tmc\TmcController;
use App\Tmc\PlayerRepository;
use App\Tmc\PlayerHistoryRepository;
use App\User\UsersRepository;
use App\User\LoginController;
use App\User\LoginService;

class Container {

    private $receipts = [];
    private $instances = [];

    public function __construct() {
        $this->receipts = [
            'tmcController' => function() {
                return new TmcController(
                        $this->make('tmcRepository'), 
                        $this->make('tournamentRepository'), 
                        $this->make('groupRepository'), 
                        $this->make('tableRepository'), 
                        $this->make('scheduleRepository'), 
                        $this->make('historyRepository'), 
                        $this->make('teamRepository'), 
                        $this->make('playerRepository'), 
                        $this->make('playerHistoryRepository'),
                        $this->make('loginService')
                );
            },
            'loginController' => function() {
                return new LoginController(
                        $this->make('loginService')
                );
            },
            'loginService' => function() {
                return new LoginService(
                        $this->make('usersRepository')
                );
            },
            'tmcRepository' => function() {
                return new TmcRepository(
                        $this->make("pdo")
                );
            },
            'tournamentRepository' => function() {
                return new TournamentRepository(
                        $this->make("pdo")
                );
            },
            'groupRepository' => function() {
                return new GroupRepository(
                        $this->make("pdo")
                );
            },
            'tableRepository' => function() {
                return new TableRepository(
                        $this->make("pdo")
                );
            },
            'scheduleRepository' => function() {
                return new ScheduleRepository(
                        $this->make("pdo")
                );
            },
            'historyRepository' => function() {
                return new HistoryRepository(
                        $this->make("pdo")
                );
            },
            'playerHistoryRepository' => function() {
                return new PlayerHistoryRepository(
                        $this->make("pdo")
                );
            },
            'teamRepository' => function() {
                return new TeamRepository(
                        $this->make("pdo")
                );
            },
            'playerRepository' => function() {
                return new PlayerRepository(
                        $this->make("pdo")
                );
            },
            'usersRepository' => function() {
                return new UsersRepository(
                        $this->make("pdo")
                );
            },
            'pdo' => function() {
                try {
                    // Conntect to Test TMC
                    //$pdo = new PDO(
                    //        'mysql:host=127.0.0.1;dbname=d0247cc6;charset=utf8', 'DIVIS', '237168'
                    //);

                    // Connect to Online TMC
                    $pdo = new PDO(
                            'mysql:host=rdbms.strato.de;dbname=DB3601722;charset=utf8', 'U3601722', '#Get1nTmc2019'
                    );
                } catch (PDOException $e) {
                    echo "Verbindung zur Datenbank fehlgeschlagen!";
                    die();
                }
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                return $pdo;
            }
        ];
    }

    public function make($name) {
        if (!empty($this->instances[$name])) {
            return $this->instances[$name];
        }

        if (isset($this->receipts[$name])) {
            $this->instances[$name] = $this->receipts[$name]();
        }

        return $this->instances[$name];
    }

}

?>

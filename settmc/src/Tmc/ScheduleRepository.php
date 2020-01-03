<?php

namespace App\Tmc;

use App\Core\AbstractRepository;
use PDO;
use PDOException;

class ScheduleRepository extends AbstractRepository {

    public function getTableName() {
        return "tm_schedule";
    }

    public function getModelName() {
        return "App\\Tmc\\ScheduleModel";
    }

    function getFinalfourById($id) {
        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "SELECT  
                    tm_schedule.id_number,
                    teamHome.name AS homeTeam,
                    teamGuest.name AS guestTeam,
                    tm_schedule.home,
                    tm_schedule.guest,
                    tm_result.goals_home,
                    tm_result.goals_guest
                FROM tm_schedule 
                JOIN tm_group_arrangement home ON tm_schedule.home = home.number AND home.id_group = :id1
                JOIN tm_team teamHome ON teamHome.id = home.id_team
                JOIN tm_group_arrangement guest ON tm_schedule.guest = guest.number AND guest.id_group = :id2
                JOIN tm_team teamGuest ON teamGuest.id = guest.id_team
                LEFT OUTER JOIN tm_result ON tm_result.id_group = :id3 and tm_schedule.id_number = tm_result.id_number
                where tm_schedule.id = (SELECT tm_group.id_fixture FROM tm_group WHERE tm_group.id = :id4)
                ORDER BY tm_schedule.id_number ASC;");

        $stmt->execute([
            'id1' => $id,
            'id2' => $id,
            'id3' => $id,
            'id4' => $id
        ]);
        $schedule = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        if (count($schedule) == 0) {
            echo "Not defined";
            //die();
        }

        $team = [
            1 => 'Sieger 1.Halbfinale',
            2 => 'Sieger 2.Halbfinale',
            3 => 'Verlieger 1.Halbfinale',
            4 => 'Verlieger 2.Halbfinale'
        ];

        foreach ($schedule AS $game):
            switch ($game["id_number"]) {
                case 1:
                    if ($game["goals_home"] > $game["goals_guest"]) {
                        $team[1] = $game["homeTeam"];
                        $team[3] = $game["guestTeam"];
                    } else {
                        $team[1] = $game["guestTeam"];
                        $team[3] = $game["homeTeam"];
                    }
                    // Is played
                    if ($game['goals_home']<1 && $game['goals_guest']<1) {
                        $team[1] = 'Sieger 1.HF';
                        $team[3] = 'Verlierer 1.HF';
                    }
                    break;
                case 2:
                    if ($game["goals_home"] > $game["goals_guest"]) {
                        $team[2] = $game["homeTeam"];
                        $team[4] = $game["guestTeam"];
                    } else {
                        $team[2] = $game["guestTeam"];
                        $team[4] = $game["homeTeam"];
                    }
                    // Is played
                    if ($game['goals_home']<1 && $game['goals_guest']<1) {
                        $team[2] = 'Sieger 2.HF';
                        $team[4] = 'Verlierer 2.HF';
                    }
                    break;
                case 3:
                    $schedule[$game["id_number"] - 1]->offsetSet("homeTeam", $team[3]);
                    $schedule[$game["id_number"] - 1]->offsetSet("guestTeam", $team[4]);
                    break;
                case 4:
                    $schedule[$game["id_number"] - 1]->offsetSet("homeTeam", $team[1]);
                    $schedule[$game["id_number"] - 1]->offsetSet("guestTeam", $team[2]);
                    break;
                default :
                    unset($schedule[$game["id_number"] - 1]);
            }
        endforeach;

        return $schedule;
    }

    function getScheduleById($id) {
        $model = $this->getModelName();

        /* $stmt = $this->pdo->prepare(
          "SELECT
          tm_schedule.id_number,
          teamHome.name AS homeTeam,
          teamGuest.name AS guestTeam,
          tm_schedule.home,
          tm_schedule.guest,
          tm_result.goals_home,
          tm_result.goals_guest,
          tm_group.id_fixture
          FROM
          tm_schedule
          LEFT OUTER JOIN
          tm_result ON tm_result.id_group = :id and tm_schedule.id_number = tm_result.id_number
          LEFT JOIN
          tm_group_arrangement home ON tm_schedule.home = home.number
          AND home.id_group = tm_result.id_group
          LEFT JOIN
          tm_team teamHome ON teamHome.id = home.id_team
          LEFT JOIN
          tm_group_arrangement guest ON tm_schedule.guest = guest.number
          AND guest.id_group = tm_result.id_group
          LEFT JOIN
          tm_team teamGuest ON teamGuest.id = guest.id_team
          LEFT JOIN
          tm_group on tm_group.id=tm_result.id_group
          WHERE
          tm_schedule.id = tm_group.id_fixture
          ORDER BY tm_schedule.id ASC;"
          ); */

        $stmt = $this->pdo->prepare(
                "SELECT  
                    tm_schedule.id_number,
                    teamHome.name AS homeTeam,
                    teamGuest.name AS guestTeam,
                    tm_schedule.home,
                    tm_schedule.guest,
                    tm_result.goals_home,
                    tm_result.goals_guest
                FROM tm_schedule 
                JOIN tm_group_arrangement home ON tm_schedule.home = home.number AND home.id_group = :id1
                JOIN tm_team teamHome ON teamHome.id = home.id_team
                JOIN tm_group_arrangement guest ON tm_schedule.guest = guest.number AND guest.id_group = :id2
                JOIN tm_team teamGuest ON teamGuest.id = guest.id_team
                LEFT OUTER JOIN tm_result ON tm_result.id_group = :id3 and tm_schedule.id_number = tm_result.id_number
                where tm_schedule.id = (SELECT tm_group.id_fixture FROM tm_group WHERE tm_group.id = :id4)
                ORDER BY tm_schedule.id_number ASC;");

        $stmt->execute([
            'id1' => $id,
            'id2' => $id,
            'id3' => $id,
            'id4' => $id
        ]);
        $schedule = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $schedule;
    }

    function getGameByGroupAndIdNumber($id, $id_number) {
        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "SELECT  
                    tm_schedule.id_number,
                    teamHome.name AS homeTeam,
                    teamGuest.name AS guestTeam,
                    home.id_team as home,
                    guest.id_team as guest,
                    tm_result.goals_home,
                    tm_result.goals_guest
                FROM tm_schedule 
                JOIN tm_group_arrangement home ON tm_schedule.home = home.number AND home.id_group = :id1
                JOIN tm_team teamHome ON teamHome.id = home.id_team
                JOIN tm_group_arrangement guest ON tm_schedule.guest = guest.number AND guest.id_group = :id2
                JOIN tm_team teamGuest ON teamGuest.id = guest.id_team
                LEFT OUTER JOIN tm_result ON tm_result.id_group = :id3 and tm_schedule.id_number = tm_result.id_number
                where tm_schedule.id = (SELECT tm_group.id_fixture FROM tm_group WHERE tm_group.id = :id4) AND tm_schedule.id_number=:idNumber
                ORDER BY tm_schedule.id_number ASC;");

        $stmt->execute([
            'id1' => $id,
            'id2' => $id,
            'id3' => $id,
            'id4' => $id,
            'idNumber' => $id_number
        ]);
        //$game = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $game = $stmt->fetch(PDO::FETCH_CLASS);

        return $game;
    }

    public function saveGame($id_group, $id_number, $id_team_home, $id_team_guest, $goals_home, $goals_guest, $points_home, $points_guest) {
        /*
         * Stor Game in tm_result & tm_cross_tab
         * tm_group requires: id_group, id_number, goals_home, goals_guest
         * tm_cross_tab requires: id_group, id_team_home, id_team_guest, goals_home, goals_guest, points_home
         * $_GET:
         * id_group, id_number, goals_home, goals_guest
         * ToBeLoaded
         * id_team_home, id_team_guest
         */
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Update tm_result
        try {
            $stmt = $this->pdo->prepare(
                    "INSERT INTO tm_result (`id_group`, `id_number`, `goals_home`, `goals_guest`) VALUES (:idGroup, :idNumber, :home, :guest)"
            );
            $stmt->execute([
                'idGroup' => $id_group,
                'idNumber' => $id_number,
                'home' => $goals_home,
                'guest' => $goals_guest
            ]);
        } catch (PDOException $e) {
            try {
                $stmt = $this->pdo->prepare(
                        "UPDATE tm_result SET `goals_home`=:home, `goals_guest`=:guest WHERE `id_group`=:idGroup AND `id_number`=:idNumber;"
                );
                $stmt->execute([
                    'idGroup' => $id_group,
                    'idNumber' => $id_number,
                    'home' => $goals_home,
                    'guest' => $goals_guest
                ]);
            } catch (PDOException $Exception2) {
                // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
                // String.
                die();
            }
        }

        // Update tm_cross_tab for Home
        try {
            $stmt = $this->pdo->prepare(
                    "INSERT INTO tm_cross_tab
                        (`id_group`, `id_team_home`, `id_team_guest`, `goals_home`, `goals_guest`, `points_home`) 
                        VALUES (:idGroup, :idHome, :idGuest, :home, :guest, :points)"
            );
            $stmt->execute([
                'idGroup' => $id_group,
                'idHome' => $id_team_home,
                'idGuest' => $id_team_guest,
                'home' => $goals_home,
                'guest' => $goals_guest,
                'points' => $points_home
            ]);
        } catch (PDOException $Exceptionh1) {
            try {
                $stmt = $this->pdo->prepare(
                        "UPDATE tm_cross_tab 
                            SET `goals_home`=:home, `goals_guest`=:guest, `points_home`=:points  
                            WHERE `id_group`=:idGroup AND `id_team_home`=:idHome AND `id_team_guest`=:idGuest;"
                );
                $stmt->execute([
                    'idGroup' => $id_group,
                    'idHome' => $id_team_home,
                    'idGuest' => $id_team_guest,
                    'home' => $goals_home,
                    'guest' => $goals_guest,
                    'points' => $points_home
                ]);
            } catch (PDOException $Exceptionh2) {
                // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
                // String.
                die();
            }
        }
        // Update tm_cross_tab for Guest
        try {
            $stmt = $this->pdo->prepare(
                    "INSERT INTO tm_cross_tab
                        (`id_group`, `id_team_home`, `id_team_guest`, `goals_home`, `goals_guest`, `points_home`) 
                        VALUES (:idGroup, :idHome, :idGuest, :home, :guest, :points)"
            );
            $stmt->execute([
                'idGroup' => $id_group,
                'idHome' => $id_team_guest,
                'idGuest' => $id_team_home,
                'home' => $goals_guest,
                'guest' => $goals_home,
                'points' => $points_guest
            ]);
        } catch (PDOException $Exceptiong1) {
            try {
                $stmt = $this->pdo->prepare(
                        "UPDATE tm_cross_tab 
                            SET `goals_home`=:home, `goals_guest`=:guest, `points_home`=:points
                            WHERE `id_group`=:idGroup AND `id_team_home`=:idHome AND `id_team_guest`=:idGuest;"
                );
                $stmt->execute([
                    'idGroup' => $id_group,
                    'idHome' => $id_team_guest,
                    'idGuest' => $id_team_home,
                    'home' => $goals_guest,
                    'guest' => $goals_home,
                    'points' => $points_guest
                ]);
            } catch (PDOException $Exceptiong2) {
                // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
                // String.
                die();
            }
        }
    }

}
?>




<?php

namespace App\Tmc;

use App\Core\AbstractRepository;
use PDO;

class PlayerRepository extends AbstractRepository {

    public function getTableName() {
        return "tm_player";
    }

    public function getModelName() {
        return "App\\Tmc\\PlayerModel";
    }

    function getPlayerByTeam($teamId) {
        /* SELECT tm_player.id, tm_player.id_team, tm_player.surname, tm_player.name, tm_player.number, tm_player.pass_id, tm_team.gName, tm_team.gToken, tm_team.gLogo
         * FROM tm_player, tm_team
         * WHERE tm_player.id_team=tm_team.id;
         */

        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "SELECT tm_player.id, tm_player.id_team, tm_player.surname, tm_player.name, tm_player.number, tm_player.pass_id, 
                        tm_team.name as gName, tm_team.token as gToken, tm_team.logo as gLogo
                    FROM tm_player, tm_team
                    WHERE tm_player.id_team=tm_team.id AND tm_team.id=:teamId"
        );
        $stmt->execute(['teamId' => $teamId]);
        $player = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $player;
    }

    public function insertPlayerForTeam($teamId, $name, $surname, $number, $passId) {
        $stmt = $this->pdo->prepare(
                "INSERT INTO tm_player (`id_team`, `surname`, `name`, `number`, `pass_id`) VALUES (:team, :surname, :name, :number, :passId);"
        );
        $stmt->execute([
            'team' => $teamId,
            'name' => $name,
            'surname' => $surname,
            'number' => $number,
            'passId' => $passId
        ]);
    }

    function fetchGroupById($id) {
        $model = $this->getModelName();

        $stmt = $this->pdo->prepare("SELECT 
                    g.id, g.name as groupName, g.date, t.id as tId, t.name as tournamentName, t.token as tToken, t.year as tYear, g.type as type, g.id_fixture as idFixture
                FROM
                    tm_group g,
                    tm_tournament t
                WHERE
                    g.id_tournament = t.id AND g.id = :id
                ORDER BY date ASC");


        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $group = $stmt->fetch(PDO::FETCH_CLASS);

        return $group;
    }

}

?>

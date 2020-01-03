<?php

namespace App\Tmc;

use App\Core\AbstractRepository;
use PDO;

class GroupRepository extends AbstractRepository {

    public function getTableName() {
        return "tm_group";
    }

    public function getModelName() {
        return "App\\Tmc\\GroupModel";
    }

    function fetchGroups() {
        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "SELECT 
                    g.id, g.name as groupName, g.date, t.id as tId, t.name as tournamentName, t.token as tToken, t.year as tYear, g.type as type, g.id_fixture as idFixture
                FROM
                    tm_group g,
                    tm_tournament t
                WHERE
                    g.id_tournament = t.id
                ORDER BY date DESC;"
        );
        $stmt->execute();
        $groups = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $groups;
    }

    function fetchGroupsByTournament($id) {
        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "SELECT 
                    g.id, g.name as groupName, g.date, t.id as tId, t.name as tournamentName, t.token as tToken, t.year as tYear, g.type as type, g.id_fixture as idFixture
                FROM
                    tm_group g,
                    tm_tournament t
                WHERE
                    g.id_tournament = t.id AND g.id_tournament = :id
                ORDER BY date ASC;"
        );
        $stmt->execute(['id' => $id]);
        $groups = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $groups;
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
                ORDER BY date ASC;");


        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $group = $stmt->fetch(PDO::FETCH_CLASS);

        return $group;
    }

    function fetchGroupByTeam($id) {
        $model = $this->getModelName();

        $stmt = $this->pdo->prepare("SELECT 
                    g.id, g.name as groupName, g.date, t.id as tId, t.name as tournamentName, t.token as tToken, t.year as tYear, g.type as type, g.id_fixture as idFixture
                FROM
                    tm_group g,
                    tm_tournament t,
                    tm_group_arrangement ga
                WHERE
                    g.id_tournament = t.id AND g.id = ga.id_group AND ga.id_team = :id
                ORDER BY date ASC;");


        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $group = $stmt->fetch(PDO::FETCH_CLASS);

        return $group;
    }

    public function promotion($groupID, $teamID, $placeID) {
        $stmt = $this->pdo->prepare(
                "UPDATE tm_group_arrangement g SET g.id_team = :teamID WHERE :placeID = g.number AND :groupID = g.id_group;"
        );
        $stmt->execute([
            'teamID' => $teamID,
            'groupID' => $groupID,
            'placeID' => $placeID
        ]);
    }

    public function resetGroupArrangement($team, $group, $number) {
        //var_dump($team);
        //var_dump($group);
        //var_dump($number);

        $stmt = $this->pdo->prepare(
                "UPDATE tm_group_arrangement g SET g.id_team = :teamID WHERE :placeID = g.number AND :groupID = g.id_group;"
        );
        $stmt->execute([
            'teamID' => $team,
            'groupID' => $group,
            'placeID' => $number
        ]);
    }

}

?>

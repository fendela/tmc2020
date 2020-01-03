<?php

namespace App\Tmc;

use App\Core\AbstractRepository;
use PDO;

class PlayerHistoryRepository extends AbstractRepository {

    public function getTableName() {
        return "tm_player";
    }

    public function getModelName() {
        return "App\\Tmc\\PlayerHistoryModel";
    }

    function getHomePlayerByGame($groupId, $id_number, $id_fixture) {

        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "SELECT 
                    tm_group.id,
                    tm_group.name,    
                    homeTeamData.name,
                    homeTeamData.logo,
                    tm_schedule.id_number,
                    tm_schedule.home as id_team_home,
                    tm_schedule.guest as id_guest_team,
                    homePlayer.id as playerID,
                    homePlayer.surname as playerSurname,
                    homePlayer.name as playerName,
                    homePlayer.number as playerNumber
                FROM 
                        tm_schedule
                INNER JOIN
                        tm_group_arrangement homeTeam ON homeTeam.number=tm_schedule.home AND homeTeam.id_group=:groupId
                INNER JOIN
                        tm_group_arrangement guestTeam ON guestTeam.number=tm_schedule.guest AND homeTeam.id_group=guestTeam.id_group
                INNER JOIN
                        tm_group ON tm_group.id=homeTeam.id_group AND tm_group.id=guestTeam.id_group 
                INNER JOIN
                        tm_team homeTeamData ON homeTeamData.id=homeTeam.id_team
                INNER JOIN
                        tm_team guestTeamData ON guestTeamData.id=guestTeam.id_team
                INNER JOIN
                        tm_player homePlayer ON homePlayer.id_team=homeTeamData.id
                WHERE 
                    tm_schedule.id_number=:idNumber AND
                    tm_schedule.id=:idFixture"
                        );
        $stmt->execute([
            'groupId' => $groupId, 
            'idNumber' => $id_number,
            'idFixture' => $id_fixture]);
        $player = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $player;
    }

    function getGuestPlayerByGame($groupId, $id_number, $id_fixture) {

        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "SELECT 
                    tm_group.id as gId,
                    tm_group.name as gName,    
                    guestTeamData.name as teamName,
                    guestTeamData.logo as teamLogo,
                    tm_schedule.id_number,
                    tm_schedule.home as id_team_home,
                    tm_schedule.guest as id_guest_team,
                    guestPlayer.id as playerID,
                    guestPlayer.surname as playerSurname,
                    guestPlayer.name as playerName,
                    guestPlayer.number as playerNumber
                FROM 
                        tm_schedule
                INNER JOIN
                        tm_group_arrangement homeTeam ON homeTeam.number=tm_schedule.home AND homeTeam.id_group=:groupId
                INNER JOIN
                        tm_group_arrangement guestTeam ON guestTeam.number=tm_schedule.guest AND homeTeam.id_group=guestTeam.id_group
                INNER JOIN
                        tm_group ON tm_group.id=homeTeam.id_group AND tm_group.id=guestTeam.id_group 
                INNER JOIN
                        tm_team homeTeamData ON homeTeamData.id=homeTeam.id_team
                INNER JOIN
                        tm_team guestTeamData ON guestTeamData.id=guestTeam.id_team
                INNER JOIN
                        tm_player guestPlayer ON guestPlayer.id_team=guestTeamData.id
                WHERE 
                    tm_schedule.id_number=:idNumber AND
                    tm_schedule.id=:idFixture"
                        );
        $stmt->execute([
            'groupId' => $groupId, 
            'idNumber' => $id_number,
            'idFixture' => $id_fixture]);
        $player = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $player;
    }

    public function insertPlayerForTeam($teamId, $name, $surname, $number, $passId) {
        $stmt = $this->pdo->prepare(
                "INSERT INTO tm_player (`id_team`, `surname`, `name`, `number`, `pass_id`) VALUES (:team, :name, :surname, :number, :passId);"
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

<?php

namespace App\Tmc;

use App\Core\AbstractRepository;
use PDO;

class TeamRepository extends AbstractRepository {

    public function getTableName() {
        return "tm_team";
    }

    public function getModelName() {
        return "App\\Tmc\\TeamModel";
    }

    function teamsByGroup($id) {
        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "SELECT 
                    tm_team.id,
                    tm_team.name AS team,
                    tm_team.token,
                    tm_team.logo,
                    tm_team.playerCount,
                    tm_group_arrangement.number
                FROM
                    tm_team,
                    tm_group_arrangement,
                    tm_group
                WHERE
                    tm_team.id = tm_group_arrangement.id_team
                        AND tm_group_arrangement.id_group = :id
                        AND tm_group_arrangement.id_group = tm_group.id
                        AND tm_group_arrangement.number <= tm_group.team_count
                ORDER BY tm_group_arrangement.number ASC;"
        );

        $stmt->execute([
            'id' => $id
        ]);
        $teams = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        

        return $teams;
    }

    function teamById($id) {
        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "SELECT 
                    tm_team.id,
                    tm_team.name AS team,
                    tm_team.token,
                    tm_team.logo,
                    tm_team.playerCount,
                    tm_group_arrangement.number
                FROM
                    tm_team,
                    tm_group_arrangement,
                    tm_group
                WHERE
                    tm_team.id = tm_group_arrangement.id_team
                        AND tm_group_arrangement.id_team = :id
                        AND tm_group_arrangement.id_group = tm_group.id
                        AND tm_group_arrangement.number <= tm_group.team_count
                ORDER BY tm_group_arrangement.number ASC;"
        );

        $stmt->execute([
            'id' => $id
        ]);

        //$teams = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $teams = $stmt->fetch(PDO::FETCH_CLASS);

        return $teams;
    }

    public function updateTeam($team, $token, $logo, $playerCount, $teamId, $teamPic) {
        $table = $this->getTableName();
        $stmt = $this->pdo->prepare(
                //"INSERT INTO `$table` (`content`, `post_id`) VALUES (:content, :postId)"
                "UPDATE tm_team SET `name`=:name, `token`=:token, `logo`=:logo, `playerCount`=:playerCount, `teamPic`=:teamPict  WHERE `id`=:teamId;"
        );

        $stmt->execute([
            'name' => $team,
            'token' => $token,
            'logo' => $logo,
            'playerCount' => $playerCount,
            'teamId' => $teamId,
            'teamPict' => $teamPic
        ]);
    }

}
?>




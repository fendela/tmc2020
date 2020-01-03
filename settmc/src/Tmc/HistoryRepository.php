<?php

namespace App\Tmc;

use App\Core\AbstractRepository;
use PDO;

class HistoryRepository extends AbstractRepository {

    protected function getIcon($iconId) {
        $icon = "";
        switch ($iconId) {
            case 1:
                $icon = "tor.png";
                break;
            case 2:
                $icon = "et.png";
                break;
            case 3:
                $icon = "2min.png";
                break;
            case 4:
                $icon = "grk.png";
                break;
            case 5:
                $icon = "rk.png";
                break;
            case 6:
                $icon = "gk.png";
                break;
            case 7:
                // Start game
                $icon = "pfiff.png";
                break;
            case 8:
                // Stopp game
                $icon = "pfiff.png";
                break;
            case 9:
                // pause game
                $icon = "break.png";
                break;
            case 10:
                // penalty goal
                $icon = "eg.png";
                break;
            case 11:
                // penalty dismiss
                $icon = "ex.png";
                break;
        }
        return $icon;
    }

    public function getTableName() {
        return "tm_schedule";
    }

    public function getModelName() {
        return "App\\Tmc\\HistoryModel";
    }

    function fetchGroupHistory() {
        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "select 
                    tm_team.name as team, 
                    tm_player.name, 
                    tm_player.surname, 
                    tm_player.number, 
                    tm_history.id, 
                    tm_history.event
                from tmc.tm_history
                inner join tm_player 
                    on tm_player.id=tm_history.id_player
                inner join tm_team 
                    on tm_team.id=tm_history.id_team
                where tm_history.id_group=41
                    and tm_history.id_number=1
                order by tm_history.id asc;"
        );

        $stmt->execute();
        $history = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $history;
    }

    function fetchGroupHistory2() {
        $model = $this->getModelName();

        $stmt = $this->pdo->query(
                "SELECT 
                    tm_team.name AS team,
                    tm_player.name,
                    tm_player.surname,
                    tm_player.number,
                    tm_history.id,
                    tm_history.event,
                    teamHome.name AS homeTeam,
                    teamGuest.name AS guestTeam
                FROM
                    tmc.tm_history
                        INNER JOIN
                    tm_player ON tm_player.id = tm_history.id_player
                        INNER JOIN
                    tm_team ON tm_team.id = tm_history.id_team
                                INNER JOIN
                        tm_group ON tm_group.id=tm_history.id_group
                                INNER JOIN
                        tm_schedule ON tm_schedule.id=tm_group.id_fixture AND tm_schedule.id_number=tm_history.id_number
                                INNER JOIN
                    tm_group_arrangement home ON tm_schedule.home = home.number
                        AND home.id_group = tm_group.id
                        INNER JOIN
                    tm_team teamHome ON teamHome.id = home.id_team
                        INNER JOIN
                    tm_group_arrangement guest ON tm_schedule.guest = guest.number
                        AND guest.id_group = tm_group.id
                        INNER JOIN
                        tm_team teamGuest ON teamGuest.id = guest.id_team
                WHERE
                    tm_history.id_group = 40
                        AND tm_history.id_number = 6
                ORDER BY tm_history.id ASC;"
        );

        $stmt->execute();
        $history = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        $pos = 0;
        $homeGoals = 0;
        $guestGoals = 0;
        foreach ($history AS $event) {

            if ($event['team'] == $event['homeTeam']) {
                //Home Team
                if ($history[$pos]->offsetGet("event") == 1) {
                    $homeGoals++;
                }
                if ($history[$pos]->offsetGet("event") == 2) {
                    $guestGoals++;
                }
                $history[$pos]->offsetSet("position", $pos);
                $history[$pos]->offsetSet("homePlayerName", $history[$pos]->offsetGet("name"));
                $history[$pos]->offsetSet("homePlayerSurname", $history[$pos]->offsetGet("surname"));
                $history[$pos]->offsetSet("homeIcon", $history[$pos]->offsetGet("event"));
                $history[$pos]->offsetSet("homeGoals", $homeGoals);
                $history[$pos]->offsetSet("guestGoals", $guestGoals);
//                $history[$pos]->offsetSet("guestIcon", $history[$pos]->offsetGet("event"));
//                $history[$pos]->offsetSet("guestPlayerName", $history[$pos]->offsetGet("name"));
//                $history[$pos]->offsetSet("guestPlayerSurname", $history[$pos]->offsetGet("surname"));
            } else {
                //Guest Test
                if ($history[$pos]->offsetGet("event") == 1) {
                    $history[$pos]->offsetSet("guestIcon", "<img src='../image/icon/tor.png'>");
                    $guestGoals++;
                }
                if ($history[$pos]->offsetGet("event") == 2) {
                    $homeGoals++;
                }
                $history[$pos]->offsetSet("position", $pos);
//                $history[$pos]->offsetSet("homePlayerName", $history[$pos]->offsetGet("name"));
//                $history[$pos]->offsetSet("homePlayerSurname", $history[$pos]->offsetGet("surname"));
//                $history[$pos]->offsetSet("homeIcon", $history[$pos]->offsetGet("event"));
                $history[$pos]->offsetSet("homeGoals", $homeGoals);
                $history[$pos]->offsetSet("guestGoals", $guestGoals);
//                $history[$pos]->offsetSet("guestIcon", $history[$pos]->offsetGet("event"));
                $history[$pos]->offsetSet("guestPlayerName", $history[$pos]->offsetGet("name"));
                $history[$pos]->offsetSet("guestPlayerSurname", $history[$pos]->offsetGet("surname"));
            }
            $pos++;
        }
        return $history;
    }

    public function changeEvent($playerID, $eventID) {
        $stmt = $this->pdo->prepare(
                "UPDATE `tm_history` SET `id_player`=:playerID WHERE `id`=:eventID;"
        );

        $stmt->execute([
            'playerID' => $playerID,
            'eventID' => $eventID
        ]);
    }

    public function getHistory($group, $game) {
        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "SELECT 
                    tm_team.name AS team,
                    tm_player.name,
                    tm_player.surname,
                    tm_player.number,
                    tm_history.id,
                    tm_history.event,
                    teamHome.name AS homeTeam,
                    teamGuest.name AS guestTeam
                FROM
                    tm_history
                        INNER JOIN
                    tm_player ON tm_player.id = tm_history.id_player
                        LEFT JOIN
                    tm_team ON tm_team.id = tm_history.id_team
                        INNER JOIN
                    tm_group ON tm_group.id=tm_history.id_group
                        INNER JOIN
                    tm_schedule ON tm_schedule.id=tm_group.id_fixture AND tm_schedule.id_number=tm_history.id_number
                        INNER JOIN
                    tm_group_arrangement home ON tm_schedule.home = home.number
                        AND home.id_group = tm_group.id
                        INNER JOIN
                    tm_team teamHome ON teamHome.id = home.id_team
                        INNER JOIN
                    tm_group_arrangement guest ON tm_schedule.guest = guest.number
                        AND guest.id_group = tm_group.id
                    INNER JOIN
                        tm_team teamGuest ON teamGuest.id = guest.id_team
                WHERE
                    tm_history.id_group = :group
                        AND tm_history.id_number = :game
                ORDER BY tm_history.id ASC;"
        );

        $stmt->execute([
            'group' => $group,
            'game' => $game
        ]);

        $history = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        $pos = 0;
        $homeGoals = 0;
        $guestGoals = 0;

        /*
         */

        foreach ($history AS $event) {

            if ($event['team'] == $event['homeTeam']) {
                //Home Team
                if ($history[$pos]->offsetGet("event") == 1) {
                    $homeGoals++;
                }
                if ($history[$pos]->offsetGet("event") == 10) {
                    $homeGoals++;
                }
                if ($history[$pos]->offsetGet("event") == 2) {
                    $guestGoals++;
                }
                $history[$pos]->offsetSet("position", $pos);
                $history[$pos]->offsetSet("homePlayerName", $history[$pos]->offsetGet("name"));
                $history[$pos]->offsetSet("homePlayerSurname", $history[$pos]->offsetGet("surname"));
                //$history[$pos]->offsetSet("homeIcon", $history[$pos]->offsetGet("event"));
                $history[$pos]->offsetSet("homeIcon", $this->getIcon($history[$pos]->offsetGet("event")));
                $history[$pos]->offsetSet("homeGoals", $homeGoals);
                $history[$pos]->offsetSet("guestGoals", $guestGoals);
//                $history[$pos]->offsetSet("guestIcon", $history[$pos]->offsetGet("event"));
//                $history[$pos]->offsetSet("guestPlayerName", $history[$pos]->offsetGet("name"));
//                $history[$pos]->offsetSet("guestPlayerSurname", $history[$pos]->offsetGet("surname"));
            } else {
                //Guest Test
                if ($history[$pos]->offsetGet("event") == 1) {
                    $guestGoals++;
                }
                if ($history[$pos]->offsetGet("event") == 10) {
                    $guestGoals++;
                }
                if ($history[$pos]->offsetGet("event") == 2) {
                    $homeGoals++;
                }
                $history[$pos]->offsetSet("position", $pos);
//                $history[$pos]->offsetSet("homePlayerName", $history[$pos]->offsetGet("name"));
//                $history[$pos]->offsetSet("homePlayerSurname", $history[$pos]->offsetGet("surname"));
//                $history[$pos]->offsetSet("homeIcon", $history[$pos]->offsetGet("event"));
                $history[$pos]->offsetSet("homeGoals", $homeGoals);
                $history[$pos]->offsetSet("guestGoals", $guestGoals);
                //$history[$pos]->offsetSet("guestIcon", $history[$pos]->offsetGet("event"));
                $history[$pos]->offsetSet("guestIcon", $this->getIcon($history[$pos]->offsetGet("event")));
                $history[$pos]->offsetSet("guestPlayerName", $history[$pos]->offsetGet("name"));
                $history[$pos]->offsetSet("guestPlayerSurname", $history[$pos]->offsetGet("surname"));
            }
            $pos++;
        }
        return $history;
    }

    function getHistoryFf($group, $game, $homeName, $guestName) {
        $model = $this->getModelName();

        $stmt = $this->pdo->prepare(
                "SELECT 
                    tm_team.name AS team,
                    tm_player.name,
                    tm_player.surname,
                    tm_player.number,
                    tm_history.id,
                    tm_history.event,
                    teamHome.name AS homeTeam,
                    teamGuest.name AS guestTeam
                FROM
                    tm_history
                        INNER JOIN
                    tm_player ON tm_player.id = tm_history.id_player
                        INNER JOIN
                    tm_team ON tm_team.id = tm_history.id_team
                                INNER JOIN
                        tm_group ON tm_group.id=tm_history.id_group
                                INNER JOIN
                        tm_schedule ON tm_schedule.id=tm_group.id_fixture AND tm_schedule.id_number=tm_history.id_number
                                INNER JOIN
                    tm_group_arrangement home ON tm_schedule.home = home.number
                        AND home.id_group = tm_group.id
                        INNER JOIN
                    tm_team teamHome ON teamHome.id = home.id_team
                        INNER JOIN
                    tm_group_arrangement guest ON tm_schedule.guest = guest.number
                        AND guest.id_group = tm_group.id
                        INNER JOIN
                        tm_team teamGuest ON teamGuest.id = guest.id_team
                WHERE
                    tm_history.id_group = :group
                        AND tm_history.id_number = :game
                ORDER BY tm_history.id ASC;"
        );

        $stmt->execute([
            'group' => $group,
            'game' => $game
        ]);

        $history = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        $pos = 0;
        $homeGoals = 0;
        $guestGoals = 0;

        foreach ($history AS $event) {
            if ($event['homeTeam'] != $homeName) {
                $history[$pos]->offsetSet("homeTeam", $homeName);
            }
            if ($event['guestTeam'] != $guestName) {
                $history[$pos]->offsetSet("guestTeam", $guestName);
            }

            if ($event['team'] == $event['homeTeam']) {
                //Home Team
                if ($history[$pos]->offsetGet("event") == 1) {
                    $homeGoals++;
                }
                if ($history[$pos]->offsetGet("event") == 10) {
                    $homeGoals++;
                }
                if ($history[$pos]->offsetGet("event") == 2) {
                    $guestGoals++;
                }
                $history[$pos]->offsetSet("position", $pos);
                $history[$pos]->offsetSet("homePlayerName", $history[$pos]->offsetGet("name"));
                $history[$pos]->offsetSet("homePlayerSurname", $history[$pos]->offsetGet("surname"));
                //$history[$pos]->offsetSet("homeIcon", $history[$pos]->offsetGet("event"));
                $history[$pos]->offsetSet("homeIcon", $this->getIcon($history[$pos]->offsetGet("event")));
                $history[$pos]->offsetSet("homeGoals", $homeGoals);
                $history[$pos]->offsetSet("guestGoals", $guestGoals);
//                $history[$pos]->offsetSet("guestIcon", $history[$pos]->offsetGet("event"));
//                $history[$pos]->offsetSet("guestPlayerName", $history[$pos]->offsetGet("name"));
//                $history[$pos]->offsetSet("guestPlayerSurname", $history[$pos]->offsetGet("surname"));
            } else {
                //Guest Test
                if ($history[$pos]->offsetGet("event") == 1) {
                    $guestGoals++;
                }
                if ($history[$pos]->offsetGet("event") == 10) {
                    $guestGoals++;
                }
                if ($history[$pos]->offsetGet("event") == 2) {
                    $homeGoals++;
                }
                $history[$pos]->offsetSet("position", $pos);
//                $history[$pos]->offsetSet("homePlayerName", $history[$pos]->offsetGet("name"));
//                $history[$pos]->offsetSet("homePlayerSurname", $history[$pos]->offsetGet("surname"));
//                $history[$pos]->offsetSet("homeIcon", $history[$pos]->offsetGet("event"));
                $history[$pos]->offsetSet("homeGoals", $homeGoals);
                $history[$pos]->offsetSet("guestGoals", $guestGoals);
                //$history[$pos]->offsetSet("guestIcon", $history[$pos]->offsetGet("event"));
                $history[$pos]->offsetSet("guestIcon", $this->getIcon($history[$pos]->offsetGet("event")));
                $history[$pos]->offsetSet("guestPlayerName", $history[$pos]->offsetGet("name"));
                $history[$pos]->offsetSet("guestPlayerSurname", $history[$pos]->offsetGet("surname"));
            }
            $pos++;
        }

        return $history;
    }

    public function insertEvent($idGroup, $idNumber, $idPlayer, $idTeam, $event) {
        $stmt = $this->pdo->prepare(
                "INSERT INTO `tm_history` (`id_group`, `id_number`, `id_player`, `id_team`, `event`) VALUES (:groupId, :numberId, :playerId, :teamId, :event);"
        );
        $stmt->execute([
            'groupId' => $idGroup,
            'numberId' => $idNumber,
            'playerId' => $idPlayer,
            'teamId' => $idTeam,
            'event' => $event
        ]);
    }

    public function kickoffEvent($idGroup, $idNumber, $event) {
        try {
            $stmt = $this->pdo->prepare(
                    "INSERT INTO `tm_history` (`id_group`, `id_number`, `id_player`, `event`) VALUES (:groupId, :numberId, :player, :event);"
            );
            $stmt->execute([
                'groupId' => $idGroup,
                'numberId' => $idNumber,
                'player' => $event,
                'event' => $event
            ]);
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    public function deleteEvent($idEvent) {
        $stmt = $this->pdo->prepare(
                "DELETE FROM `tm_history` WHERE `id`=:idEvent;"
        );
        $stmt->execute([
            'idEvent' => $idEvent
        ]);
    }

}
?>




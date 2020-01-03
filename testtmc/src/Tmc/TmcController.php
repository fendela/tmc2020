<?php

namespace App\Tmc;

use App\Core\AbstractController;
//use App\User\UsersRepository;
use App\User\LoginService;

class TmcController extends AbstractController {

    public function __construct(
    TmcRepository $tmcRepository, TournamentRepository $tournamentRepository, GroupRepository $groupRepository, TableRepository $tableRepository, ScheduleRepository $scheduleRepository, HistoryRepository $historyRepository, TeamRepository $teamRepository, PlayerRepository $playerRepository, PlayerHistoryRepository $playerHistoryRepository, LoginService $loginService
    ) {
        $this->tmcRepository = $tmcRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->groupRepository = $groupRepository;
        $this->tableRepository = $tableRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->historyRepository = $historyRepository;
        $this->teamRepository = $teamRepository;
        $this->playerRepository = $playerRepository;
        $this->playerHistoryRepository = $playerHistoryRepository;
        $this->loginService = $loginService;
    }

    public function index() {
        $tournaments = $this->tournamentRepository->tournamentByYear();

        if (isset($_GET['tournament'])) {
            $id = $_GET['tournament'];
        } else {
            $id = $tournaments[0]['id'];
        }

        $tournament = $this->tournamentRepository->find($id);
        $groups = $this->groupRepository->fetchGroupsByTournament($id);


        $this->render("tmc/index", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'groups' => $groups,
            'thisTournament' => $id
        ]);
    }

    public function tournament() {
        $tournaments = $this->tournamentRepository->tournamentByYear();

        if (isset($_GET['tournament'])) {
            $id = $_GET['tournament'];
        } else {
            $id = $tournaments[0]['id'];
        }

        $tournament = $this->tournamentRepository->find($id);
        $groups = $this->groupRepository->fetchGroupsByTournament($id);

        $stmt = $groups;
        $team = [];
        foreach ($stmt as $key) {
            $team[$key['id']] = $this->teamRepository->teamsByGroup($key['id']);
        };

        if ($id < 5) {
            $this->render("tmc/tournament", [
                'tournament' => $tournament,
                'tournaments' => $tournaments,
                'groups' => $groups,
                'team' => $team,
                'thisTournament' => $id
            ]);
        } else {
            $this->render("tmc/tournamentov", [
                'tournament' => $tournament,
                'tournaments' => $tournaments,
                'groups' => $groups,
                'team' => $team,
                'thisTournament' => $id
            ]);
        }
    }

    public function settournament() {
        $this->loginService->check();

        $tournaments = $this->tournamentRepository->tournamentByYear();

        if (isset($_GET['tournament'])) {
            $id = $_GET['tournament'];
        } else {
            $id = $tournaments[0]['id'];
        }

        $tournament = $this->tournamentRepository->find($id);
        $groups = $this->groupRepository->fetchGroupsByTournament($id);

        $stmt = $groups;
        $team = [];
        foreach ($stmt as $key) {
            $team[$key['id']] = $this->teamRepository->teamsByGroup($key['id']);
        };

        $this->render("tmc/settournament", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'groups' => $groups,
            'team' => $team,
            'thisTournament' => $id
        ]);
    }

    public function group() {
        $tournaments = $this->tournamentRepository->tournamentByYear();

        $id = $_GET['group'];
        $table = $this->tableRepository->getTableById($id);
        $schedule = $this->scheduleRepository->getScheduleById($id);
        $group = $this->groupRepository->fetchGroupById($id);

        $tId = $group['tId'];
        $groups = $this->groupRepository->fetchGroupsByTournament($tId);
        $tournament = $this->tournamentRepository->find($tId);

        $history = [];

        foreach ($schedule AS $game) {
            $history[$game['id_number']] = $this->historyRepository->getHistory($id, $game['id_number']);
        }
        
        
        
        

        $stmt = $groups;
        $team = [];
        foreach ($stmt as $key) {
            $team[$key['id']] = $this->teamRepository->teamsByGroup($key['id']);
        }


        if (count($history[1])>0) {
            $this->render("tmc/grouphistory", [
                'tournament' => $tournament,
                'tournaments' => $tournaments,
                'group' => $group,
                'table' => $table,
                'schedule' => $schedule,
                'groups' => $groups,
                'thisTournament' => $group['tId'],
                'teams' => $team,
                'history' => $history
            ]);
        } else {

            $this->render("tmc/group", [
                'tournament' => $tournament,
                'tournaments' => $tournaments,
                'group' => $group,
                'table' => $table,
                'schedule' => $schedule,
                'groups' => $groups,
                'teams' => $team,
                'thisTournament' => $group['tId']
            ]);
        }
    }

    public function finalfour() {
        $tournaments = $this->tournamentRepository->tournamentByYear();

        $id = $_GET['group'];
        $table = $this->tableRepository->getTableById($id);
        $schedule = $this->scheduleRepository->getFinalfourById($id);
        $group = $this->groupRepository->fetchGroupById($id);

        $tId = $group['tId'];
        $groups = $this->groupRepository->fetchGroupsByTournament($tId);
        $tournament = $this->tournamentRepository->find($tId);

        $history = [];

        foreach ($schedule AS $game) {

            $history[$game['id_number']] = $this->historyRepository->getHistoryFf($id, $game['id_number'], $game['homeTeam'], $game['guestTeam']);
        }
        
        $stmt = $groups;
        $team = [];
        foreach ($stmt as $key) {
            $team[$key['id']] = $this->teamRepository->teamsByGroup($key['id']);
        }

        
        $this->render("tmc/finalfour", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'group' => $group,
            'schedule' => $schedule,
            'groups' => $groups,
            'thisTournament' => $group['tId'],            
            'history' => $history,
            'teams' => $team
        ]);
    }

    public function setfinalfour() {
        $this->loginService->check();

        $tournaments = $this->tournamentRepository->tournamentByYear();

        $id = $_GET['group'];
        $table = $this->tableRepository->getTableById($id);
        $schedule = $this->scheduleRepository->getFinalfourById($id);
        $group = $this->groupRepository->fetchGroupById($id);

        $tId = $group['tId'];
        $groups = $this->groupRepository->fetchGroupsByTournament($tId);
        $tournament = $this->tournamentRepository->find($tId);

        $history = [];

        foreach ($schedule AS $game) {

            $history[$game['id_number']] = $this->historyRepository->getHistoryFf($id, $game['id_number'], $game['homeTeam'], $game['guestTeam']);
        }

        $this->render("tmc/setfinalfour", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'group' => $group,
            'table' => $table,
            'schedule' => $schedule,
            'groups' => $groups,
            'thisTournament' => $group['tId'],
            'history' => $history
        ]);
    }

    public function history() {
        $groupId = $_GET['group'];
        $game = $_GET['game'];

        $history = $this->historyRepository->getHistory($groupId, $game);
        $group = $this->groupRepository->fetchGroupById($groupId);
        $table = $this->tableRepository->getTableById($groupId);

        $tournaments = $this->tournamentRepository->tournamentByYear();

        $this->render("tmc/history", [
            'tournaments' => $tournaments,
            'group' => $group,
            'table' => $table,
            'history' => $history,
        ]);
    }

    public function setgroup() {
        $this->loginService->check();

        $tournaments = $this->tournamentRepository->tournamentByYear();

        $id = $_GET['group'];
        $group = $this->groupRepository->fetchGroupById($id);

        $tId = $group['tId'];
        $groups = $this->groupRepository->fetchGroupsByTournament($tId);
        $tournament = $this->tournamentRepository->find($tId);

        if (isset($_GET['reset'])) {
            if ($_GET['reset'] == 1 && $group['type'] != 2) {

                $count = 0;
                foreach ($groups as $groupDetail) {
                    if ($id == $groupDetail['id']) {
                        //$this->groupRepository->resetGroup($groupDetail['id'], $count);

                        switch ($count) {
                            case 4:
                                $team = [381, 382, 383, 384];
                                break;
                            case 5:
                                $team = [385, 386, 387, 388];
                                break;
                            case 6:
                                $team = [389, 390, 391, 392];
                                break;
                        }

                        if (isset($team)) {
                            for ($run = 0; $run < 4; $run++) {
                                //var_dump($groupID);
                                //var_dump($count);
                                //var_dump($run);
                                //var_dump($team);

                                $this->groupRepository->resetGroupArrangement($team[$run], $groupDetail['id'], $run + 1);
                            }
                        }
                    }
                    $count++;
                }
            }
        }

        $table = $this->tableRepository->getTableById($id);
        $schedule = $this->scheduleRepository->getScheduleById($id);

        if (isset($_GET['promotion']) && isset($_GET['place'])) {

            $groupUp = $this->groupRepository->fetchGroupById($id);

            $groupCount = 0;
            $newGroup = -1;
            $number = -1;

            foreach ($groups as $groupDetail) {

                if ($groupUp['id'] == $groupDetail['id']) {
                    if ($groupCount == 0 && $_GET['place'] == 1) {
                        $newGroup = 4;
                        $number = 1;
                    }
                    if ($groupCount == 0 && $_GET['place'] == 2) {
                        $newGroup = 5;
                        $number = 1;
                    }
                    if ($groupCount == 1 && $_GET['place'] == 2) {
                        $newGroup = 4;
                        $number = 2;
                    }
                    if ($groupCount == 1 && $_GET['place'] == 1) {
                        $newGroup = 5;
                        $number = 2;
                    }

                    if ($groupCount == 2 && $_GET['place'] == 1) {
                        $newGroup = 4;
                        $number = 3;
                    }
                    if ($groupCount == 2 && $_GET['place'] == 2) {
                        $newGroup = 5;
                        $number = 3;
                    }
                    if ($groupCount == 3 && $_GET['place'] == 2) {
                        $newGroup = 4;
                        $number = 4;
                    }
                    if ($groupCount == 3 && $_GET['place'] == 1) {
                        $newGroup = 5;
                        $number = 4;
                    }


                    if ($groupCount == 4 && $_GET['place'] == 1) {
                        $newGroup = 6;
                        $number = 1;
                    }
                    if ($groupCount == 5 && $_GET['place'] == 2) {
                        $newGroup = 6;
                        $number = 2;
                    }
                    if ($groupCount == 4 && $_GET['place'] == 2) {
                        $newGroup = 6;
                        $number = 4;
                    }
                    if ($groupCount == 5 && $_GET['place'] == 1) {
                        $newGroup = 6;
                        $number = 3;
                    }
                }
                $groupCount++;
            }

            if ($newGroup != -1) {
                $this->groupRepository->promotion($groups[$newGroup]['id'], intval($_GET['promotion']), $number);
            }
        }

        /*
         * Stor Game in tm_result & tm_cross_tab
         * tm_group requires: id_group, id_number, goals_home, goals_guest
         * tm_cross_tab requires: id_group, id_team_home, id_team_guest, goals_home, goals_guest, points_home
         * $_GET:
         * id_group, id_number, goals_home, goals_guest
         * ToBeLoaded
         * id_team_home, id_team_guest
         */

        if (isset($_GET['id_number']) && isset($_GET['goals_home']) && isset($_GET['goals_guest'])) {
            $idNumber = $_GET['id_number'];
            $goalsHome = $_GET['goals_home'];
            $goalsGuest = $_GET['goals_guest'];

            if (isset($_GET['kickoff'])) {
                $kickoff = $_GET['kickoff'];
                $this->historyRepository->kickoffEvent($id, $idNumber, $kickoff);
            }

            $id_team_home = $schedule[$idNumber - 1]['home'];
            $id_team_guest = $schedule[$idNumber - 1]['guest'];
            $pointsHome = "";
            $pointsGuest = "";

            if ($goalsHome > $goalsGuest) {
                $pointsHome = 3;
                $pointsGuest = 0;
            } elseif ($goalsHome < $goalsGuest) {
                $pointsHome = 0;
                $pointsGuest = 3;
            } else {
                $pointsHome = 1;
                $pointsGuest = 1;
            }

            $this->scheduleRepository->saveGame($id, $idNumber, $id_team_home, $id_team_guest, $goalsHome, $goalsGuest, $pointsHome, $pointsGuest);


            $table = $this->tableRepository->getTableById($id);
            $schedule = $this->scheduleRepository->getScheduleById($id);
        }

        $history = [];

        foreach ($schedule AS $game) {
            $history[$game['id_number']] = $this->historyRepository->getHistory($id, $game['id_number']);
        }

        $this->render("tmc/setgrouphistory", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'group' => $group,
            'table' => $table,
            'schedule' => $schedule,
            'groups' => $groups,
            'thisTournament' => $group['tId'],
            'history' => $history
        ]);
    }

    public function edithistory() {
        $this->loginService->check();

        // INSERT HISTORY => id_group, id_number, id_player, id_team, event
        // DELETE id + id_group & id_number
        // UPDATE to be done
        $id = $_GET['group'];
        $idFixture = $_GET['id_fixture'];
        $idNumber = $_GET['id_number'];

        if (isset($_GET['playerID']) && isset($_GET['eventID'])) {
            $playerID = $_GET['playerID'];
            $eventID = $_GET['eventID'];
            $this->historyRepository->changeEvent($playerID, $eventID);
        }

        $tournaments = $this->tournamentRepository->tournamentByYear();

        $group = $this->groupRepository->fetchGroupById($id);

        $tId = $group['tId'];
        $groups = $this->groupRepository->fetchGroupsByTournament($tId);
        $tournament = $this->tournamentRepository->find($tId);

        $homePlayer = $this->playerHistoryRepository->getHomePlayerByGame($id, $idNumber, $idFixture);
        $guestPlayer = $this->playerHistoryRepository->getGuestPlayerByGame($id, $idNumber, $idFixture);
        $game = $this->scheduleRepository->getGameByGroupAndIdNumber($id, $idNumber);

        if (isset($_GET['kickoff'])) {
            /*
             * Kickoff Events
             * 7 - Anstoss
             * 8 - Unterbrechung
             * 9 - Abpfiff
             */
            $kickoff = $_GET['kickoff'];

            $this->historyRepository->kickoffEvent($id, $idNumber, $kickoff);
        }

        if (isset($_POST['delete'])) {
            // DELETE 
            $eventId = $_POST['delete'];
            $this->historyRepository->deleteEvent($eventId);
        } elseif (sizeof($_POST) > 0) {
            $event = $_POST['event'];
            $idHome = $game['home'];
            $idGuest = $game['guest'];
            if (isset($_POST['homePlayer'])) {
                $playerHome = $_POST['homePlayer'];
                // INSERT EVENT
                $this->historyRepository->insertEvent($id, $idNumber, $playerHome, $idHome, $event);
            } elseif (isset($_POST['guestPlayer'])) {
                $playerGuest = $_POST['guestPlayer'];
                // INSERT EVENT
                $this->historyRepository->insertEvent($id, $idNumber, $playerGuest, $idGuest, $event);
            }
        }


        $history = $this->historyRepository->getHistory($id, $idNumber);



        $this->render("tmc/edithistory", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'group' => $group,
            'groups' => $groups,
            'thisTournament' => $group['tId'],
            'history' => $history,
            'guestPlayer' => $guestPlayer,
            'homePlayer' => $homePlayer,
            'game' => $game
        ]);
    }

    public function edithistoryfinal() {
        $this->loginService->check();

        // INSERT HISTORY => id_group, id_number, id_player, id_team, event
        // DELETE id + id_group & id_number
        // UPDATE to be done
        $id = $_GET['group'];
        $idFixture = $_GET['id_fixture'];
        $idNumber = $_GET['id_number'];

        if (isset($_GET['playerID']) && isset($_GET['eventID'])) {
            $playerID = $_GET['playerID'];
            $eventID = $_GET['eventID'];
            $this->historyRepository->changeEvent($playerID, $eventID);
        }

        $tournaments = $this->tournamentRepository->tournamentByYear();

        $group = $this->groupRepository->fetchGroupById($id);

        $tId = $group['tId'];
        $groups = $this->groupRepository->fetchGroupsByTournament($tId);
        $tournament = $this->tournamentRepository->find($tId);

        $homePlayer = $this->playerHistoryRepository->getHomePlayerByGame($id, $idNumber, $idFixture);
        $guestPlayer = $this->playerHistoryRepository->getGuestPlayerByGame($id, $idNumber, $idFixture);
        $game = $this->scheduleRepository->getGameByGroupAndIdNumber($id, $idNumber);

        if (isset($_POST['delete'])) {
            // DELETE 
            $eventId = $_POST['delete'];
            $this->historyRepository->deleteEvent($eventId);
        } elseif (sizeof($_POST) > 0) {
            $event = $_POST['event'];
            $idHome = $game['home'];
            $idGuest = $game['guest'];
            if (isset($_POST['homePlayer'])) {
                $playerHome = $_POST['homePlayer'];
                // INSERT EVENT
                $this->historyRepository->insertEvent($id, $idNumber, $playerHome, $idHome, $event);
            } elseif (isset($_POST['guestPlayer'])) {
                $playerGuest = $_POST['guestPlayer'];
                // INSERT EVENT
                $this->historyRepository->insertEvent($id, $idNumber, $playerGuest, $idGuest, $event);
            }
        }


        $history = $this->historyRepository->getHistory($id, $idNumber);



        $this->render("tmc/edithistory", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'group' => $group,
            'groups' => $groups,
            'thisTournament' => $group['tId'],
            'history' => $history,
            'guestPlayer' => $guestPlayer,
            'homePlayer' => $homePlayer,
            'game' => $game
        ]);
    }

    public function editteam() {
        $tournaments = $this->tournamentRepository->tournamentByYear();

        $id = $_GET['group'];
        $group = $this->groupRepository->fetchGroupById($id);

        $tId = $group['tId'];
        $groups = $this->groupRepository->fetchGroupsByTournament($tId);
        $tournament = $this->tournamentRepository->find($tId);

        $teamId = $_GET['id_team'];

        if (isset($_POST['Team']) && isset($_POST['Token']) && isset($_POST['Logo']) && isset($_POST['PlayerCount'])) {
            $teamName = $_POST['Team'];
            $token = $_POST['Token'];
            $logo = $_POST['Logo'];
            $playerCount = $_POST['PlayerCount'];
            $TeamPic = $_POST['TeamPic'];
            $this->teamRepository->updateTeam($teamName, $token, $logo, $playerCount, $teamId, $TeamPic);
        }

        $team = $this->teamRepository->teamById($teamId);


        if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['number'])) {
            $pName = $_POST['name'];
            $pSurname = $_POST['surname'];
            $pNumber = $_POST['number'];
            $pPassId = $_POST['passId'];

            $this->playerRepository->insertPlayerForTeam($teamId, $pName, $pSurname, $pNumber, $pPassId);
        }

        $players = $this->playerRepository->getPlayerByTeam($teamId);

        $this->render("tmc/editteam", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'group' => $group,
            'groups' => $groups,
            'thisTournament' => $group['tId'],
            'team' => $team,
            'players' => $players
        ]);
    }

    public function showteam() {
        $tournaments = $this->tournamentRepository->tournamentByYear();

        $id = $_GET['group'];
        $group = $this->groupRepository->fetchGroupById($id);

        $tId = $group['tId'];
        $groups = $this->groupRepository->fetchGroupsByTournament($tId);
        $tournament = $this->tournamentRepository->find($tId);

        $teamId = $_GET['id_team'];

        $team = $this->teamRepository->teamById($teamId);

        $players = $this->playerRepository->getPlayerByTeam($teamId);

        $this->render("tmc/showteam", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'group' => $group,
            'groups' => $groups,
            'thisTournament' => $group['tId'],
            'team' => $team,
            'players' => $players
        ]);
    }

    public function login() {

        $tournaments = $this->tournamentRepository->tournamentByYear();

        if (isset($_GET['tournament'])) {
            $id = $_GET['tournament'];
        } else {
            $id = $tournaments[0]['id'];
        }

        $tournament = $this->tournamentRepository->find($id);
        $groups = $this->groupRepository->fetchGroupsByTournament($id);

        $this->render("user/login", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'groups' => $groups,
            'thisTournament' => $id
        ]);
    }

    public function impressum() {
        $tournaments = $this->tournamentRepository->tournamentByYear();

        if (isset($_GET['tournament'])) {
            $id = $_GET['tournament'];
        } else {
            $id = $tournaments[0]['id'];
        }

        $tournament = $this->tournamentRepository->find($id);
        $groups = $this->groupRepository->fetchGroupsByTournament($id);


        $this->render("tmc/impressum", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'groups' => $groups,
            'thisTournament' => $id
        ]);
    }

    public function dgsvo() {
        $tournaments = $this->tournamentRepository->tournamentByYear();

        if (isset($_GET['tournament'])) {
            $id = $_GET['tournament'];
        } else {
            $id = $tournaments[0]['id'];
        }

        $tournament = $this->tournamentRepository->find($id);
        $groups = $this->groupRepository->fetchGroupsByTournament($id);


        $this->render("tmc/dgsvo", [
            'tournament' => $tournament,
            'tournaments' => $tournaments,
            'groups' => $groups,
            'thisTournament' => $id
        ]);
    }

}

?>

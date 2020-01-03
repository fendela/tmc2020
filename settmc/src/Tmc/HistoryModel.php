<?php

namespace App\Tmc;

use App\Core\AbstractModel;

class HistoryModel extends AbstractModel
{
    public $team;
    public $name;
    public $surname;
    public $number;
    public $id;
    public $event;
    public $homeTeam;
    public $guestTeam;
    public $timeUnix;
    
    public $position;
    public $homePlayerName;
    public $homePlayerSurname;
    public $homeIcon;
    public $homeGoals;
    public $guestGoals;
    public $guestIcon;
    public $guestPlayerName;
    public $guestPlayerSurname;
}

?>


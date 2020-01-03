<?php

namespace App\User;

use App\Core\AbstractRepository;

class UserModel extends \App\Core\AbstractModel
{
    public $id;
    public $loginname;
    public $password;
    public $vorname;
    public $name;
    public $email;
    public $fon;
    public $mobile;
    
}


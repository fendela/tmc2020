<?php

namespace App\User;

use App\User\UsersRepository;

class LoginService {
    public function __construct(UsersRepository $usersRepository) {
        $this->usersRepository = $usersRepository;
    }
    
    public function attempt($loginname, $password){
        $user = $this->usersRepository->findByLoginname($loginname);
        if (empty($user)){
            return false;
        }         
        if (password_verify($password, $user->password)) {
            $_SESSION['login'] = $user->loginname;
            session_regenerate_id(true);
            return true;
        } else {
            return false;
        }
    }
    
    public function check() {
        if(isset($_SESSION['login'])){
            return true;
        } else {
            header("Location: login");
            die();
        }
    }

        public function logout() {
        unset($_SESSION['login']);
        session_regenerate_id(true);
 
    }
}

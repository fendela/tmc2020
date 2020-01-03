<?php

namespace App\User;

use App\Core\AbstractController;

class LoginController extends AbstractController
{
    public function __construct(LoginService $loginService) {
        $this->loginService = $loginService;        
    }
    
    public function dashboard() {
        $this->loginService->check();
        $this->render("user/dashboard", []);
    }

    public function logout() {
        $this->loginService->logout();
        header("Location: login");
    }

    public function login() {
        $error = false;
        $password = false;
        if (!empty($_POST['loginname']) AND !empty($_POST['password'])){
            $loginname = $_POST['loginname'];
            $password = $_POST['password'];
            
            if ($this->loginService->attempt($loginname, $password)) {
                header("Location: dashboard");
                return;
            } else {
                $error = true;
            }
        }
        $this->render("user/login", [
            'error' => $error,
            'pass' => $password
        ]);
    }
}

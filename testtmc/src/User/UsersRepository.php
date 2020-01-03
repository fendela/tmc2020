<?php

namespace App\User;

use PDO;
use App\Core\AbstractRepository;

class UsersRepository extends AbstractRepository 
{    
    public function getModelName(){
       return "App\\User\\UserModel"; 
    }
    public function getTableName(){
        return "tm_users";
    }
    
    public function findByLoginname($loginname){
        $model = $this->getModelName();
        $table = $this->getTableName();
        
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE loginname= :loginname;");
        $stmt->execute([
            'loginname' => $loginname
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $user = $stmt->fetch(PDO::FETCH_CLASS);
        
        return $user;        
    }
    
}



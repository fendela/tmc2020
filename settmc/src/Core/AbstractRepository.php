<?php

namespace App\Core;

use PDO;

abstract class AbstractRepository
{
    protected $pdo;
    
    public function __construct(PDO $pdo) 
    {
        $this->pdo = $pdo;
    }
    
    abstract public function getTableName();
    
    abstract public function getModelName();
    
    public function all()
    {
        $model = $this->getModelName();
        $table = $this->getTableName();
        
        $stmt = $this->pdo->prepare("SELECT * FROM {$table};");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        
        return $results;
    }
        
    public function find($id)
    {
        $model = $this->getModelName();
        $table = $this->getTableName();
        
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE id= :id;");
        $stmt->execute([
            'id' => $id
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $result = $stmt->fetch(PDO::FETCH_CLASS);
        
        return $result;
    }
}

?>

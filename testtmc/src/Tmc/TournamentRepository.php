<?php

namespace App\Tmc;

use App\Core\AbstractRepository;
use PDO;

class TournamentRepository extends AbstractRepository
{
    public function getTableName()
    {
        return "tm_tournament";
    }
    
    public function getModelName()
    {
        return "App\\Tmc\\TournamentModel";
    }

    public function tournamentByYear()
    {
        $model = $this->getModelName();
        $table = $this->getTableName();
        
        $stmt = $this->pdo->prepare("SELECT * FROM `tm_tournament` ORDER BY `year` DESC");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_CLASS, $model);
    } 
}
?>

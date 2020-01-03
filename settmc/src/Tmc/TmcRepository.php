<?php

namespace App\Tmc;

use App\Core\AbstractRepository;

class TmcRepository extends AbstractRepository
{
    public function getTableName()
    {
        return "tm_tournament";
    }
    
    public function getModelName()
    {
        return "App\\Tmc\\GroupModel";
    }
}

?>

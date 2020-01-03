<?php

namespace App\Tmc;

use App\Core\AbstractRepository;
use PDO;

class TableRepository extends AbstractRepository
{
    public function getTableName()
    {
        return "tm_table";
    }
    
    public function getModelName()
    {
        return "App\\Tmc\\TableModel";
    }
    
    public function getTableById($id)
    {
        $model = $this->getModelName();
        
        $stmt = $this->pdo->prepare(    
                "SELECT 
                    `tm_table`.`id` AS `platz`,
                    `tm_group_arrangement`.`id_team` AS `id_team`,
                    `tm_team`.`name` AS `team`,
                    IFNULL(COUNT(`tm_cross_tab`.`points_home`), 0) AS `games`,
                    IFNULL(SUM(`tm_cross_tab`.`goals_home`), 0) AS `goals`,
                    IFNULL(SUM(`tm_cross_tab`.`goals_guest`), 0) AS `goalsAgainst`,
                    IFNULL((SUM(`tm_cross_tab`.`goals_home`) - SUM(`tm_cross_tab`.`goals_guest`)), 0) AS `diff`,
                    IFNULL(SUM(`tm_cross_tab`.`points_home`), 0) AS `points`
                FROM
                    (((`tm_table`
                    LEFT JOIN `tm_group_arrangement` ON (((`tm_table`.`id` = `tm_group_arrangement`.`number`)
                        AND (`tm_group_arrangement`.`id_group` = :id))))
                    LEFT JOIN `tm_team` ON ((`tm_team`.`id` = `tm_group_arrangement`.`id_team`)))
                    LEFT JOIN `tm_cross_tab` ON (((`tm_cross_tab`.`id_team_home` = `tm_group_arrangement`.`number`)
                        AND (`tm_cross_tab`.`id_group` = `tm_group_arrangement`.`id_group`))))
                WHERE
                    (`tm_table`.`id` <= (SELECT 
                            `tm_group`.`team_count`
                        FROM
                            `tm_group`
                        WHERE
                            (`tm_group`.`id` = `tm_group_arrangement`.`id_group`)))
                GROUP BY `tm_team`.`name`
                ORDER BY `points` DESC , `diff` DESC , `goals` DESC , `tm_team`.`name`;"
                );
      
        $stmt->execute(['id' => $id]);
        $table = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
        
        return $table;         
    }
}
?>




<?php include __DIR__ . "/../layout/header.php"; ?>
<div class="page-header">
    <?php echo "<h3>{$tournament['name']} {$tournament['year']}</h3>"; ?>
</div>
<div class="panel-body">
    <div class="row">
        <?php for ($in = 0; $in < 4; $in++) { ?>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="text-right">
                    <small>
                        <?php
                        $date = new DateTime($groups[$in]['date']);
                        echo $date->format('d.m.Y - H:i') . " Uhr *";
                        ?>
                    </small>
                </div>
                <div class="panel panel-default table-responsive">
                    <div class="panel-heading">
                        <a href="group?group=<?php echo $groups[$in]['id']; ?>">
                            <?php echo "<strong>{$groups[$in]['groupName']}</strong>"; ?>
                        </a>
                    </div>
                    <table class="table table-condensed table-hover">
                        <?php
                        $currentgroup = $in;
                        $rows = $team[$groups[$currentgroup]['id']];
                        $i = 0;
                        foreach ($rows AS $row):
                            ?>    
                            <tr>
                                <td>
                                    <?php
                                    if ($rows[$i]['logo'] != "") {
                                        echo"<img src='../image/logo/{$rows[$i]['logo']}' class='img-rounded' alt='{$rows[$i]['token']} - ' style='
                                width: 20px;
                                heigth: 20px;'/>";
                                    }
                                    echo "<a href='showteam?group={$groups[$currentgroup]['id']}&id_team={$row['id']}'>";
                                    echo "<strong> {$row['team']}</strong>";
                                    echo "</a>";
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        endforeach;
                        ?>    
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="text-right">
                <small>
                    <?php
                    $date = new DateTime($groups[4]['date']);
                    echo $date->format('d.m.Y - H:i') . " Uhr *";
                    ?>
                </small>
            </div>
            <div class="panel panel-default table-responsive">
                <div class="panel-heading">
                    <a href="group?group=<?php echo $groups[4]['id']; ?>">
                        <?php echo "<strong>{$groups[4]['groupName']}</strong>"; ?>
                    </a>
                </div>
                <table class="table table-condensed table-hover">
                    <?php
                    $currentgroup = 4;
                    $rows = $team[$groups[$currentgroup]['id']];
                    $i = 0;
                    foreach ($rows AS $row):
                        ?>    
                        <tr>
                            <td>
                                <?php
                                if ($rows[$i]['logo'] != "") {
                                    echo"<img src='../image/logo/{$rows[$i]['logo']}' class='img-rounded' alt='{$rows[$i]['token']} - ' style='
                                width: 20px;
                                heigth: 20px;'/>";
                                }
                                echo "<a href='showteam?group={$groups[$currentgroup]['id']}&id_team={$row['id']}'>";
                                echo "<strong> {$row['team']}</strong>";
                                echo "</a>";
                                ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    endforeach;
                    ?>    
                </table>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-md-push-4">
            <div class="text-right">
                <small>
                    <?php
                    $date = new DateTime($groups[5]['date']);
                    echo $date->format('d.m.Y - H:i') . " Uhr *";
                    ?>
                </small>
            </div>
            <div class="panel panel-default table-responsive">
                <div class="panel-heading">
                    <a href="group?group=<?php echo $groups[5]['id']; ?>">
                        <?php echo "<strong>{$groups[5]['groupName']}</strong>"; ?>
                    </a>
                </div>
                <table class="table table-condensed table-hover">
                    <?php
                    $currentgroup = 5;
                    $rows = $team[$groups[$currentgroup]['id']];
                    $i = 0;
                    foreach ($rows AS $row):
                        ?>    
                        <tr>
                            <td>
                                <?php
                                if ($rows[$i]['logo'] != "") {
                                    echo"<img src='../image/logo/{$rows[$i]['logo']}' class='img-rounded' alt='{$rows[$i]['token']} - ' style='
                                width: 20px;
                                heigth: 20px;'/>";
                                }
                                echo "<a href='showteam?group={$groups[$currentgroup]['id']}&id_team={$row['id']}'>";
                                echo "<strong> {$row['team']}</strong>";
                                echo "</a>";
                                ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    endforeach;
                    ?>    
                </table>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-md-pull-4">
            <div class="text-right">
                <small>
                    <?php
                    $date = new DateTime($groups[6]['date']);
                    echo $date->format('d.m.Y - H:i') . " Uhr *";
                    ?>
                </small>
            </div>
            <div class="panel panel-default table-responsive">
                <div class="panel-heading">
                    <a href="finalfour?group=<?php echo $groups[6]['id']; ?>">
                        <?php echo "<strong>{$groups[6]['groupName']}</strong>"; ?>
                    </a>
                </div>
                <table class="table table-condensed table-hover">
                    <?php
                    $currentgroup = 6;
                    $rows = $team[$groups[$currentgroup]['id']];
                    $i = 0;
                    foreach ($rows AS $row):
                        ?>    
                        <tr>
                            <td>
                                <?php
                                if ($rows[$i]['logo'] != "") {
                                    echo"<img src='../image/logo/{$rows[$i]['logo']}' class='img-rounded' alt='{$rows[$i]['token']} - ' style='
                                width: 20px;
                                heigth: 20px;'/>";
                                }
                                echo "<a href='showteam?group={$groups[$currentgroup]['id']}&id_team={$row['id']}'>";
                                echo "<strong> {$row['team']}</strong>";
                                echo "</a>";
                                ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    endforeach;
                    ?>    
                </table>
            </div>
        </div>
    </div>
    <small>* Kurzfristige Änderungen vorbehalten.</small>
</div>
<?php include __DIR__ . "/../layout/footer.php"; ?>



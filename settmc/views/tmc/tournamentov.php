<?php include __DIR__ . "/../layout/header.php"; ?>
<div class="page-header">
    <?php echo "<h3>{$tournament['name']} {$tournament['year']}</h3>"; ?>
</div>
<?php if ($tournament['id']==10) {?>
    <div class="row">

            </br>
            <div class="text-center">
                <?php 
                // Display Logo and Link to Sponsor
                if ($groups[6]['logo'] != "") {
                    echo"<img src='../image/sponsors/{$groups[6]['logo']}' class='img-rounded' alt='{$rows[$i]['token']} - ' style='
                            height: 70px; display: center;'/>";
                                }
                                ?>                 
            </div>

            </br>
    </div>
    <div class="row">
            <div class="col-xs-8 col-xs-push-2 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4 col-lg-2 col-lg-push-5">

            <div class="panel panel-default table-responsive">
             <div class="panel-heading text-center">
                <span class="glyphicon glyphicon-book" aria-hidden="true"></span>
                Turnierheft 2020
                 
             </div>
                <table class="table table-default table-center">
                    <tr>
                        <td class="text-center">
                <a href='../pdf/turnierheft2020.pdf' target='_blank'>
                
                <span class="glyphicon glyphicon-book" aria-hidden="true"></span>
                Turnierheft 2020
                <span class="glyphicon glyphicon-download" aria-hidden="true"></span>
                    </a>
                            </td>
                    </tr>
                </table>
             </div></div>
        </div>
    </div>
<?php } ?>
<div class="panel-body">
    <div class="row">
        <?php for ($in = 0; $in < 4; $in++) { ?>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="text-center ">
                    <?php 
                    // Display Logo and Link to Sponsor
                    if ($groups[$in]['logo'] != "") {
                        echo"<img src='../image/sponsors/{$groups[$in]['logo']}' class='img-rounded' alt='{$rows[$i]['token']} - ' style='
                                height: 70px; display: center;'/>";
                                    }
                    ?>                    
                </div>
            </br>
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
            </br>
            <div class="text-center">
                <?php 
                // Display Logo and Link to Sponsor
                if ($groups[4]['logo'] != "") {
                    echo"<img src='../image/sponsors/{$groups[4]['logo']}' class='img-rounded' alt='{$rows[$i]['token']} - ' style='
                            height: 70px; display: center;'/>";
                                }
                ?>                    
            </div>
            </br>
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
            </br>
            <div class="text-center">
                <?php 
                // Display Logo and Link to Sponsor
                if ($groups[5]['logo'] != "") {
                    echo"<img src='../image/sponsors/{$groups[5]['logo']}' class='img-rounded' alt='{$rows[$i]['token']} - ' style='
                            height: 70px; display: center;'/>";
                                }
                ?>                    
            </div>
            </br>
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
            </br>
            <div class="text-center">
                <?php 
                // Display Logo and Link to Sponsor
                if ($groups[6]['logo'] != "") {
                    echo"<img src='../image/sponsors/{$groups[6]['logo']}' class='img-rounded' alt='{$rows[$i]['token']} - ' style='
                            height: 70px; display: center;'/>";
                                }
                ?>                    
            </div>
            </br>
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



<?php include __DIR__ . "/../layout/header.php"; ?>
<div class="page-header">
    <a class="btn btn-default" href="tournament?tournament=<?php echo $group['tId']; ?>" role="button">&Uuml;bersicht</a>
    <h3>
        <?php echo "{$group['tournamentName']} {$group['tYear']} - {$group['groupName']}"; ?>
    </h3>
</div>
<div class="panel-body">
    <div class="text-right">
        <?php
        $date = new DateTime($group['date']);
        echo $date->format('d.m.Y - H:i') . " Uhr *";
        
        $logos = [];
        ?>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default table-responsive">
                <div class="panel-heading"><strong>Tabelle</strong></div>
                <table class="table table-condensed table-hover">
                    <tr>
                        <th class='text-center'>Platz</th><th>Verein</th><th class='text-center'>Sp</th><th class='text-center'>Tore</th><th class='text-center'>Diff</th><th class='text-center'>Pkt</th>
                    </tr>
                    <?php
                    $i = 0;
                    foreach ($table AS $row):
                        if ($i < 2) {
                            echo "<tr class='active'>";
                        } else {
                            echo "<tr>";
                        }

                        //var_dump($group['id']);
                        //var_dump($teams[$group['id']]);

                        $logo = "";
                        foreach ($teams[$group['id']] as $team) {
                            if ($team['id'] == $row['id_team'] && $team['logo'] != "") {
                                $logo = $team['logo'];
                                $logos[$row['team']] = $team['logo'];
                            }
                        }


                        $i++;
                        echo "<td class='text-center'>{$i}</td>"
                        . "<td>";
                        if ($logo != "") {
                            echo"<img src='../image/logo/{$logo}' class='img-rounded' alt='{$logo} - ' style='
                                width: 20px;
                                heigth: 20px;'/>&nbsp;&nbsp;";
                        }
                        echo "{$row["team"]} "
                        . "<a class='btn btn-default btn-xs' href='showteam?group={$group['id']}&id_team={$row['id_team']}' role='button'><span class='glyphicon glyphicon-list' aria-hidden='true'></span></a>"
                        . "</td>"
                        . "<td class='text-center'>{$row["games"]}</td>"
                        . "<td class='text-center'>{$row["goals"]}:{$row["goalsAgainst"]}</td>"
                        . "<td class='text-center'>{$row["diff"]}</td>"
                        . "<td class='text-center'>{$row["points"]}</td>";
                        ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="panel panel-default table-responsive">
                <div class="panel-heading"><strong>Spielplan</strong></div>
                <table class="table table-condensed table-hover">
                    <tr>
                        <th class='text-center'>Spiel</th><th>Spielpaarung</th><th class='text-center'>Ergebnis</th><th class='text-center'>Details</th>
                    </tr>
                    <?php foreach ($schedule AS $row): ?>
                        <tr>
                            <?php echo "<td class='text-center'>{$row["id_number"]}</td>"; ?>
                            <?php echo "<td>{$row["homeTeam"]} - {$row["guestTeam"]}</td>"; ?>
                            <?php echo "<td class='text-center'>{$row["goals_home"]}:{$row["goals_guest"]}</td>"; ?>
                            <td class='text-center'>
                                <?php                                
                                if (count($history) > 0) {
                                    if ($row["goals_home"]>-1 && $row["goals_guest"]>-1) {
                                        ?>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal<?php echo $row["id_number"]; ?>">                                
                                            <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal<?php echo $row["id_number"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row["id_number"]; ?>">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel<?php echo $row["id_number"]; ?>">
                                                            <?php
                                                            // Home Logo

                                                            if (count($logos) > 0 && $logos[$row["homeTeam"]] != "") {
                                                                echo"<img src='../image/logo/{$logos[$row["homeTeam"]]}' class='img-rounded' alt='{$logos[$row["homeTeam"]]} - ' style='
                                                                      width: 24px;
                                                                      heigth: 24px;'/>&nbsp;&nbsp;";
                                                            }
                                                            echo "{$row["homeTeam"]} - {$row["guestTeam"]}";
                                                            // Away Logo
                                                            if (count($logos) > 0 && $logos[$row["guestTeam"]] != "") {
                                                                echo"&nbsp;&nbsp;<img src='../image/logo/{$logos[$row["guestTeam"]]}' class='img-rounded' alt='{$logos[$row["guestTeam"]]} - ' style='
                                                                      width: 24px;
                                                                      heigth: 24px;'/>";
                                                            }
                                                            ?>
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table>
                                                            <?php if (count($history[$row['id_number']]) == 0) { ?>
                                                                <tr>
                                                                    <td class="text-center">Keine Ereignisse.
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                            <?php foreach ($history[$row['id_number']] AS $row): ?>
                                                                <tr>
                                                                    <td class='col-xs-1 text-center'><?php echo "{$row["homeGoals"]}:{$row["guestGoals"]}"; ?></td>
                                                                    <td class='col-xs-1 text-center'>
                                                                        <?php
                                                                        if (isset($row["homeIcon"])) {
                                                                            echo "<img src='../image/icons/{$row["homeIcon"]}' alt='EventIcon'>";
                                                                        }
                                                                        if (isset($row["guestIcon"])) {
                                                                            echo "<img src='../image/icons/{$row["guestIcon"]}' alt='EventIcon'>";
                                                                        }
                                                                        echo "</td>";
                                                                        echo "<td class='col-xs-10 text-left'>";
                                                                        if (count($logos) > 0 && isset($row["homeIcon"]) && ($row['event'] != 7 && $row['event'] != 8 && $row['event'] != 9)) {
                                                                            if ($logos[$row["homeTeam"]] != "") {
                                                                                echo"<img src='../image/logo/{$logos[$row["homeTeam"]]}' class='img-rounded' alt='{$logos[$row["homeTeam"]]} - ' style='
                                                                                    width: 20px;
                                                                                    heigth: 20px;'/>&nbsp;&nbsp;";
                                                                            }
                                                                        }
                                                                        if (count($logos) > 0 && isset($row["guestIcon"]) && ($row['event'] != 7 && $row['event'] != 8 && $row['event'] != 9)) {
                                                                            if ($logos[$row["guestTeam"]] != "") {
                                                                                echo"<img src='../image/logo/{$logos[$row["guestTeam"]]}' class='img-rounded' alt='{$logos[$row["guestTeam"]]} - ' style='
                                                                                    width: 20px;
                                                                                    heigth: 20px;'/>&nbsp;&nbsp;";
                                                                            }
                                                                        }
                                                                        echo "{$row["name"]} {$row["surname"]}";
                                                                        ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Schlie&szlig;en</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                            
                                        <?php
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <small>* Kurzfristige Änderungen vorbehalten.</small>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>




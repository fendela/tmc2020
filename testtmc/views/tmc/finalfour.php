<?php
include __DIR__ . "/../layout/header.php";
//var_dump($group['id']);
//var_dump($teams[$group['id']]);

$logo = "";
$logos = [];

foreach ($teams[$group['id']] as $team) {
    $logo = $team['logo'];
    $logos[$team['team']] = $team['logo'];
}
//var_dump($logos);
?>





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
        echo $date->format('d.m.Y - H:i') . " Uhr";
        ?>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default table-responsive">
                <div class="panel-heading"><strong>Spielplan</strong></div>
                <table class="table table-condensed">
                    <tr>
                        <th class='text-center'>Spiel</th><th>Spielpaarung</th><th class='text-center'>Ergebnis</th><th class='text-center'>Details</th>
                    </tr>
                    <?php
                    foreach ($schedule AS $row):
                        ?>
                        <?php
                        $gameName = "";
                        switch ($row["id_number"]) {
                            case 1:
                                $gameName = "1.HF";
                                break;
                            case 2:
                                $gameName = "2.HF";
                                break;
                            case 3:
                                echo "<tr><td colspan='4'></td></tr>";
                                $gameName = "Pl.3";
                                break;
                            case 4:
                                echo "<tr><td colspan='4'></td></tr>";
                                $gameName = "Finale";
                                break;
                        }
                        ?>
                        <tr>
                            <?php echo "<td class='text-center'>{$gameName}</td>"; ?>
                            <?php echo "<td>{$row["homeTeam"]} - {$row["guestTeam"]}</td>"; ?>
                                <?php echo "<td class='text-center'>{$row["goals_home"]}:{$row["goals_guest"]}</td>"; ?>
                            <td class='text-center'>
                                <?php
                                if (count($history) > 0) {
                                    if ($row["goals_home"] > -1 && $row["goals_guest"] > -1) {
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
                                                            if ($logos[$row["homeTeam"]] != "") {
                                                                echo"<img src='../image/logo/{$logos[$row["homeTeam"]]}' class='img-rounded' alt='{$logos[$row["homeTeam"]]} - ' style='
                                                                      width: 24px;
                                                                      heigth: 24px;'/>&nbsp;&nbsp;";
                                                            }
                                                            echo "{$row["homeTeam"]} - {$row["guestTeam"]}";
                                                            // Away Logo
                                                            if ($logos[$row["guestTeam"]] != "") {
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
                                                                        if (isset($row["homeIcon"]) && ($row['event'] != 7 && $row['event'] != 8 && $row['event'] != 9)) {
                                                                            if ($logos[$row["homeTeam"]] != "") {
                                                                                echo"<img src='../image/logo/{$logos[$row["homeTeam"]]}' class='img-rounded' alt='{$logos[$row["homeTeam"]]} - ' style='
                                                                                    width: 20px;
                                                                                    heigth: 20px;'/>&nbsp;&nbsp;";
                                                                            }
                                                                        }
                                                                        if (isset($row["guestIcon"]) && ($row['event'] != 7 && $row['event'] != 8 && $row['event'] != 9)) {
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
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>




<?php include __DIR__ . "/../layout/setheader.php"; ?>
<div class="page-header">
    <a class="btn btn-default" href="settournament?tournament=<?php echo $group['tId']; ?>" role="button">&Uuml;bersicht</a>
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
                <div class="panel-heading"><strong>Teams</strong></div>
                <?php foreach ($table AS $row): ?>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <?php echo "{$row["team"]} <a class='btn btn-default btn-xs' href='editteam?group={$group['id']}&id_team={$row['id_team']}&source=setfinalfour' role='button'>"; ?>
                            <span class='glyphicon glyphicon-pencil' aria-hidden='true'>
                            </span>
                            </a>
                        </li>
                    </ul>
                <?php endforeach; ?>
            </div>

            <div class="panel panel-default table-responsive">
                <div class="panel-heading"><strong>Spielplan</strong></div>
                <table class="table table-condensed">
                    <tr>
                        <th class='text-center'>Spiel</th><th>Spielpaarung</th><th class='text-center'>Ergebnis</th><th class='text-center'>Details</th>
                    </tr>
                    <?php foreach ($schedule AS $row): ?>
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
                                                <h4 class="modal-title" id="myModalLabel<?php echo $row["id_number"]; ?>"><?php echo "{$row["homeTeam"]} - {$row["guestTeam"]}"; ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <table>
                                                    <?php if (count($history[$row['id_number']]) == 0) { ?>
                                                        <tr>
                                                            <td class="text-center">Keine Ereignisse.
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php foreach ($history[$row['id_number']] AS $rows): ?>
                                                        <tr>
                                                            <td class='col-xs-1 text-center'><?php echo "{$rows["timeUnix"]}"; ?></td>
                                                            <td class='col-xs-1 text-center'><?php echo "{$rows["homeGoals"]}:{$rows["guestGoals"]}"; ?></td>
                                                            <td class='col-xs-1 text-center'>
                                                                <?php
                                                                if (isset($rows["homeIcon"])) {
                                                                    echo "<img src='../image/icons/{$rows["homeIcon"]}' alt='EventIcon'>";
                                                                }
                                                                ?>
                                                                <?php
                                                                if (isset($rows["guestIcon"])) {
                                                                    echo "<img src='../image/icons/{$rows["guestIcon"]}' alt='EventIcon'>";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class='col-xs-9 text-left'><?php echo "{$rows["name"]} {$rows["surname"]}"; ?></td>
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
                                echo "<a class='btn btn-default btn-xs' href='edithistory?group={$group['id']}&id_fixture={$group['idFixture']}&id_number={$row['id_number']}&source=setfinalfour' role='button'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>";
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




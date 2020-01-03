<?php include __DIR__ . "/../layout/setheader.php"; ?>
<div class="page-header">
    <a class="btn btn-default" href="settournament?tournament=<?php echo $group['tId']; ?>" role="button">&Uuml;bersicht</a>
    <h3>
        <?php
        echo "{$group['tournamentName']} {$group['tYear']} - {$group['groupName']}";
        if ($group['type']==1) {
            echo "<a class='btn btn-default btn-xs' href='setgrouphistory?group={$group['id']}&reset=1' role='button'>"
            . "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>"
            . "</a>";
        }
        ?>
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
                <div class="panel-heading"><strong>Tabelle</strong></div>
                <table class="table table-condensed">
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
                        ?>


                        <?php
                        $i++;
                        echo "<td class='text-center'>{$i}</td><td>{$row["team"]} "
                        . "<a class='btn btn-default btn-xs' href='editteam?group={$group['id']}&id_team={$row['id_team']}' role='button'>"
                        . "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>"
                        . "</a>";

                        if ($i <= 2) {
                            echo "<a class='btn btn-default btn-xs' href='setgrouphistory?group={$group['id']}&promotion={$row['id_team']}&place={$i}' role='button'>"
                            . "<span class='glyphicon glyphicon-log-in' aria-hidden='true'></span>"
                            . "</a>";
                        }

                        echo "</td>"
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
                <table class="table table-condensed">
                    <tr>
                        <th class='text-center'>Spiel</th><th>Spielpaarung</th><th class='text-center'>Ergebnis</th><th class='text-center'>Details</th>
                    </tr>
                    <?php foreach ($schedule AS $rows): ?>
                        <tr>
                            <?php echo "<td class='text-center'>{$rows["id_number"]}</td>"; ?>
                            <?php echo "<td>{$rows["homeTeam"]} - {$rows["guestTeam"]}</td>"; ?>
                            <?php echo "<td class='text-center'>{$rows["goals_home"]}:{$rows["goals_guest"]}</td>"; ?>
                            <td class='text-center'>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal<?php echo $rows["id_number"]; ?>">                                
                                    <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal<?php echo $rows["id_number"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $rows["id_number"]; ?>">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel<?php echo $rows["id_number"]; ?>"><?php echo "{$rows["homeTeam"]} - {$rows["guestTeam"]}"; ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <table>
                                                    <?php if (count($history[$rows['id_number']]) == 0) { ?>
                                                        <tr>
                                                            <td class="text-center">Keine Ereignisse.
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php foreach ($history[$rows['id_number']] AS $row): ?>
                                                        <tr>
                                                            <td class='col-xs-1 text-center'><?php echo "{$row["homeGoals"]}:{$row["guestGoals"]}"; ?></td>
                                                            <td class='col-xs-1 text-center'>
                                                                <?php
                                                                if (isset($row["homeIcon"])) {
                                                                    echo "<img src='../image/icons/{$row["homeIcon"]}' alt='EventIcon'>";
                                                                }
                                                                ?>
                                                                <?php
                                                                if (isset($row["guestIcon"])) {
                                                                    echo "<img src='../image/icons/{$row["guestIcon"]}' alt='EventIcon'>";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class='col-xs-10 text-left'><?php echo "{$row["name"]} {$row["surname"]}"; ?></td>
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
                                echo "<a class='btn btn-default btn-xs' href='edithistory?group={$group['id']}&id_fixture={$group['idFixture']}&id_number={$rows['id_number']}' role='button'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>";
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




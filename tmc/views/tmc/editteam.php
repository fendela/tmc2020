<?php include __DIR__ . "/../layout/setheader.php"; ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo "{$group['tournamentName']} {$group['tYear']} - {$group['groupName']}"; ?>
    </div>
    <div class="panel-body">
        <div class="col-md-6">
            <div class="panel panel-default table-responsive">
                <div class="panel-heading">Spieler hinzufügen</div>
                <div class="panel-body">

                    <form name="addPlayer" class="form-horizontal" method="post" action="editteam?group=<?php echo $group['id']; ?>&id_team=<?php echo $team['id']; ?>">
                        <div class="form-group">
                            <label for="inputName" class="col-md-4 control-label">Vorname</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="inputName" placeholder="Vorname" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSurname" class="col-md-4 control-label">Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="inputSurname" placeholder="Name" name="surname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputNumber" class="col-md-4 control-label">Rückennummer</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="inputNumber" placeholder="Rückennummer" name="number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassId" class="col-md-4 control-label">Spieler Pass</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="inputPassId" placeholder="Spieler Pass" name="passId">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <input type="submit" value="Spieler hinzufügen" class="btn btn-default" />
                                <?php
                                if (isset($_GET['source'])) {
                                    echo "<a class='btn btn-default' href='setfinalfour?group={$group['id']}' role='button'>{$group['groupName']}</a>";
                                } else {
                                    echo "<a class='btn btn-default' href='setgrouphistory?group={$group['id']}' role='button'>{$group['groupName']}</a>";
                                }
                                ?>                            

                            </div>
                        </div>

                    </form>

                </div>
            </div><!-- Ende Spieler hinzufügen -->


            <div class="panel panel-default table-responsive">
                <div class="panel-heading"><?php echo $team['team'] . " - ID: " . $team['id']; ?></div>
                <div class="panel-body">
                    <form name="editTeam" class="form-horizontal" method="post" action="editteam?group=<?php echo $group['id']; ?>&id_team=<?php echo $team['id']; ?>">
                        <div class="form-group">
                            <label for="inputTeam" class="col-md-4 control-label">Team</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="inputTeam" name="Team" value="<?php echo $team['team']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputToken" class="col-md-4 control-label">Token</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="inputToken" name="Token" value="<?php echo $team['token']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLogo" class="col-md-4 control-label">Logo</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="inputLogo" name="Logo" value="<?php echo $team['logo']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPlayerCount" class="col-md-4 control-label">Player</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="inputPlayerCount" name="PlayerCount" value="<?php echo $team['playerCount']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputTeamPic" class="col-md-4 control-label">Mannschaftsfoto</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="inputPlayerCount" name="TeamPic" value="<?php echo $team['teamPic']; ?>">
                            </div>
                            <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-8"><br/>                                
                                <?php
                                $filepath = "../image/team/" . $team['teamPic'];
                                $folder = __DIR__ . '../../../public/image/team/';
                                if (!is_file($folder . $team['teamPic'])) {
                                    ?>
                                    <div class='well'>
                                        <?php
                                        $alledateien = scandir(__DIR__ . '../../../public/image/team/2017'); //Ordner "files" auslesen

                                        foreach ($alledateien as $datei) { // Ausgabeschleife
                                            echo $datei . "<br />"; //Ausgabe Einzeldatei
                                        };
                                        ?>

                                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span></button>
                                    </div>
                                <?php } else { ?>
                                    <img class="img-rounded img-responsive" src="<?php echo $filepath; ?>">
                                <?php } ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-8">
                                <button type="submit" class="btn btn-default">Speichern</button>
                                <?php
                                if (isset($_GET['source'])) {
                                    echo "<a class='btn btn-default' href='setfinalfour?group={$group['id']}' role='button'>{$group['groupName']}</a>";
                                } else {
                                    echo "<a class='btn btn-default' href='setgrouphistory?group={$group['id']}' role='button'>{$group['groupName']}</a>";
                                }
                                ?>                            
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- Ende Team bearbeiten -->            
        </div>
        <div class="col-md-6">
            <div class="panel panel-default table-responsive">
                <div class="panel-heading">Spieler bearbeiten:</div>
                <div class="panel-body">
                    <div class="list-group">
                        <?php foreach ($players AS $player): ?>
                            <?php echo"<a href='#' class='list-group-item'>{$player['name']} {$player['surname']} {$player['pass_id']}<span class='badge'>{$player['number']}</span></a>"; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div><!-- Ende Spieler bearbeiten -->            
        </div>


    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>
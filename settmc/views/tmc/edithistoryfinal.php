<?php include __DIR__ . "/../layout/setheader.php"; ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo "<h4>{$group['tournamentName']} {$group['tYear']} - {$group['groupName']}</h4>"; ?>
    </div>
    <div class="panel-body">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading text-center">
                <?php echo"{$game['homeTeam']} - {$game['guestTeam']}"; ?>
            </div>
            <div class="panel-body text-center">
                <div class="row">
                    <div class="col-xs-0 col-md-4"></div>
                    <div class="col-xs-12 col-md-4">
                        <table>
                            <?php
                            if (count($history) == 0) {
                                $homeGoalsResult = 0;
                                $guestGoalsResult = 0;
                                ?>
                                <tr>
                                    <td class="text-center">Keine Ereignisse.
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php foreach ($history AS $row): ?>
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
                                    <td class='col-xs-10 text-left'><?php echo "{$row["name"]} {$row["surname"]}"; ?>
                                        <!-- Alter Player -->
                                        <!-- Button trigger modal -->
                                        <a href='#' data-toggle="modal" data-target="#myPlayerModal<?php echo "{$row["id"]}"; ?>">
                                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade bs-example-modal-sm" id="myPlayerModal<?php echo "{$row["id"]}"; ?>" tabindex="-1" role="dialog" aria-labelledby="myPlayerModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myPlayerModalLabel">Spieler ändern?</h4>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <table>
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
                                                                <td class='col-xs-10 text-left'>
                                                                    <?php echo "{$row["name"]} {$row["surname"]} "; ?>
                                                                    <input type="hidden" name="delete" value="<?php echo "{$row["id"]}"; ?>">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="row">

                                                            <?php if (isset($row["homeIcon"])) { ?>
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <?php echo"{$game['homeTeam']}"; ?>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        <?php
                                                                        foreach ($homePlayer as $thishplayer) :
                                                                            echo "<a class='btn btn-default btn-block' href='edithistory?group={$_GET['group']}&id_fixture={$_GET['id_fixture']}&id_number={$_GET['id_number']}&playerID={$thishplayer['playerID']}&eventID={$row["id"]}' role='button'>{$thishplayer['playerNumber']} - {$thishplayer['playerName']} {$thishplayer['playerSurname']}</a>";

                                                                        endforeach;
                                                                        echo "<a class='btn btn-default btn-block' href='edithistory?group={$_GET['group']}&id_fixture={$_GET['id_fixture']}&id_number={$_GET['id_number']}&playerID=0&eventID={$row["id"]}' role='button'>Platzhalter</a>";
                                                                        ?>
                                                                    </div>
                                                                </div>

                                                            <?php } elseif (isset($row["guestIcon"])) { ?>
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <?php echo"{$game['guestTeam']}"; ?>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        <?php
                                                                        foreach ($guestPlayer as $thisgplayer) :
                                                                            echo "<a class='btn btn-default btn-block' href='edithistory?group={$_GET['group']}&id_fixture={$_GET['id_fixture']}&id_number={$_GET['id_number']}&playerID={$thisgplayer['playerID']}&eventID={$row["id"]}' role='button'>{$thisgplayer['playerNumber']} - {$thisgplayer['playerName']} {$thisgplayer['playerSurname']}</a>";

                                                                        endforeach;
                                                                        echo "<a class='btn btn-default btn-block' href='edithistory?group={$_GET['group']}&id_fixture={$_GET['id_fixture']}&id_number={$_GET['id_number']}&playerID=0&eventID={$row["id"]}' role='button'>Platzhalter</a>";
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Nein</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  DELETE EVENT -->
                                        <!-- Button trigger modal -->
                                        <a href='#' data-toggle="modal" data-target="#myModal<?php echo "{$row["id"]}"; ?>">
                                            <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade bs-example-modal-sm" id="myModal<?php echo "{$row["id"]}"; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form method="post" action="edithistoryfinal?group=<?php echo $_GET['group']; ?>&id_fixture=<?php echo $_GET['id_fixture']; ?>&id_number=<?php echo $_GET['id_number']; ?>">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Folgendes Event wirklich löschen?</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table>
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
                                                                    <td class='col-xs-10 text-left'>
                                                                        <?php echo "{$row["name"]} {$row["surname"]} "; ?>
                                                                        <input type="hidden" name="delete" value="<?php echo "{$row["id"]}"; ?>">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Nein</button>
                                                            <button type="submit" class="btn btn-danger">Löschen</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ALTER EVENT -->
                                    </td>
                                </tr>
                                <?php
                                if (count($history) > 0) {
                                    $homeGoalsResult = $row["homeGoals"];
                                    $guestGoalsResult = $row["guestGoals"];
                                }
                                ?>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <div class="col-xs-0 col-md-4"></div>
                </div>
            </div>
            <div class="panel-body">
                <form method="post" action="edithistory?group=<?php echo $_GET['group']; ?>&id_fixture=<?php echo $_GET['id_fixture']; ?>&id_number=<?php echo $_GET['id_number']; ?>">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <!-- new panel -->
                            <!-- http://localhost/tmc/public/index.php/edithistory?group=36&id_fixture=1&id_number=6 -->
                            <!-- Events -->
                            <div class="col-sm-12">

                                <!-- Start Game -->
                                <!--
                                Event:
                                <div class="row">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" name="options" id="option1" autocomplete="off"> <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
                                        </label>
                                    </div>
                                </div>
                                -->
                                <!-- In Game Events -->
                                <div class="row">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" name="event" id="option1" autocomplete="off" value="1" checked> <img src='../image/icons/tor.png' alt='Tor'> 
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="event" id="option2" autocomplete="off" value="2"> <img src='../image/icons/et.png' alt='ET'> 
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="event" id="option3" autocomplete="off" value="3"> <img src='../image/icons/2min.png' alt='2min'> 
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="event" id="option4" autocomplete="off" value="6"> <img src='../image/icons/gk.png' alt='Gelb'> 
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="event" id="option5" autocomplete="off" value="4"> <img src='../image/icons/grk.png' alt='GelbRot'> 
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="event" id="option6" autocomplete="off" value="5"> <img src='../image/icons/rk.png' alt='Rot'> 
                                        </label>
                                        <!-- New Events 2017 -->
                                        <!-- This Events are not bound to a Person and needs to be separeted
                                        <label class="btn btn-default">
                                            <input type="radio" name="event" id="option6" autocomplete="off" value="7"> <img src='../image/icons/pfiff.png' alt='Start'> 
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="event" id="option6" autocomplete="off" value="8"> <img src='../image/icons/pfiff.png' alt='Stop'> 
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="event" id="option6" autocomplete="off" value="9"> <img src='../image/icons/pfiff.png' alt='Pause'> 
                                        </label>
                                        -->
                                        <label class="btn btn-default">
                                            <input type="radio" name="event" id="option6" autocomplete="off" value="10"> <img src='../image/icons/eg.png' alt='Goal'> 
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="event" id="option6" autocomplete="off" value="11"> <img src='../image/icons/ex.png' alt='Parade'> 
                                        </label>

                                        <!-- Pause Game -->
                                        <!--
                                        <label class="btn btn-default">
                                            <input type="radio" name="options" id="option3" autocomplete="off"> <span class="glyphicon glyphicon-pause" aria-hidden="true"></span>
                                        </label>
                                        -->
                                    </div>
                                    <a class="btn btn-default" href="#" role="button" data-toggle="modal" data-target="#spielBeenden">
                                        <span class="glyphicon glyphicon-stop" aria-hidden="true"></span> Spiel beenden
                                    </a>
                                    <!-- Button trigger modal -->

                                    <!-- Modal -->
                                    <div class="modal fade bs-example-modal-sm" id="spielBeenden" tabindex="-1" role="dialog" aria-labelledby="spielBeenden">
                                        <div class="modal-dialog" role="saveGame">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Spiel wirklich beenden?</h4>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <p>
                                                        <?php echo"{$game['homeTeam']} - {$game['guestTeam']}"; ?>
                                                    </p>
                                                    <p>
                                                        <?php echo "{$homeGoalsResult}:{$guestGoalsResult}"; ?>
                                                    </p>
                                                    <input type="hidden" name="" value="<?php echo "{$row["id"]}"; ?>">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Nein</button>
                                                    <?php
                                                    $target = "";
                                                    if (isset($_GET['source'])) {
                                                        $target = "setfinalfour";
                                                    } else {
                                                        $target = "setfinalfour";
                                                    }
                                                    echo"<a class='btn btn-danger' href='{$target}"
                                                    . "?group={$_GET['group']}"
                                                    . "&id_number={$_GET['id_number']}"
                                                    . "&goals_home={$homeGoalsResult}"
                                                    . "&goals_guest={$guestGoalsResult}'>"
                                                    ?>
                                                    <span class="glyphicon glyphicon-stop" aria-hidden="true"></span> Spiel speichern
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Resume Game -->
                                <!--
                                <div class="row">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" name="options" id="option1" autocomplete="off"> <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
                                        </label>
                                    </div>
                                </div>
                                -->
                                <!-- Stop / End Game -->
                                <!--
                                <div class="row">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" name="options" id="option1" autocomplete="off"> <span class="glyphicon glyphicon-stop" aria-hidden="true"></span>
                                        </label>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>

                    <!-- Show Player -->
                    <div class="row">

                        <div class="col-xs-12 col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?php echo"{$game['homeTeam']}"; ?>
                                </div>
                                <div class="panel-body">
                                    <div class="btn-group-vertical" data-toggle="buttons">
                                        <?php foreach ($homePlayer as $thishplayer) : ?>
                                            <label class="btn btn-default">
                                                <?php echo "<input type='radio' name='homePlayer' id='option{$thishplayer['playerID']}' autocomplete='off' value='{$thishplayer['playerID']}'>{$thishplayer['playerNumber']} - {$thishplayer['playerName']} {$thishplayer['playerSurname']}"; ?>
                                            </label>                                    
                                            <?php
                                        endforeach;
                                        ?>
                                        <label class="btn btn-default">
                                            <?php echo "<input type='radio' name='homePlayer' id='option0' autocomplete='off' value='0'>Platzhalter"; ?>
                                        </label>
                                    </div>                                    
                                </div>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?php echo"{$game['guestTeam']}"; ?>
                                </div>
                                <div class="panel-body">
                                    <div class="btn-group-vertical" data-toggle="buttons">
                                        <?php foreach ($guestPlayer as $thisplayer) : ?>
                                            <label class="btn btn-default">
                                                <?php echo "<input type='radio' name='guestPlayer' id='option{$thisplayer['playerID']}' autocomplete='off' value='{$thisplayer['playerID']}'>{$thisplayer['playerNumber']} - {$thisplayer['playerName']} {$thisplayer['playerSurname']}"; ?>
                                            </label>
                                            <?php
                                        endforeach;
                                        ?>
                                        <label class="btn btn-default">
                                            <?php echo "<input type='radio' name='guestPlayer' id='option0' autocomplete='off' value='0'>Platzhalter"; ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="submit" class="btn btn-default">Speichern</button>                            
                            <?php
                            if (isset($_GET['source'])) {
                                echo "<a class='btn btn-default' href='setfinalfour?group={$group['id']}' role='button'>{$group['groupName']}</a>";
                            } else {
                                echo "<a class='btn btn-default' href='setfinalfour?group={$group['id']}' role='button'>{$group['groupName']}</a>";
                            }
                            ?>                            

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>
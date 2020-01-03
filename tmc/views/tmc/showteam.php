<?php include __DIR__ . "/../layout/header.php"; ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo "{$group['tournamentName']} {$group['tYear']} - {$group['groupName']}"; ?>
    </div>
    <div class="panel-body">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                <?php
                if ($team['logo'] != "") {
                    echo"<img src='../image/logo/{$team['logo']}' class='img-rounded' alt='{$team['logo']} - ' style='
                           width: 24px;
                           heigth: 24px;'/>&nbsp;&nbsp;";
                }
                echo "{$team['team']} - Kader {$group['tYear']}";
                ;
                ?>:</div>
            <div class="list-group">
                <?php foreach ($players AS $player): ?>
                    <?php echo"<div class='list-group-item'>{$player['name']} {$player['surname']} <button type='button' class='btn btn-default btn-xs' aria-label='Left Align'>{$player['number']}</button></div>"; ?>
                <?php endforeach; ?>
            </div>
            <div class="panel-footer">
                <?php
                echo "<a class='btn btn-default' href='group?group={$group['id']}' role='button'>{$group['groupName']}</a> ";
                echo "<a class='btn btn-default' href='tournament?tournament={$group['tId']}' role='button'>Übersicht</a>";
                ?>
            </div>
        </div><!-- Ende Spieler bearbeiten -->            
    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>
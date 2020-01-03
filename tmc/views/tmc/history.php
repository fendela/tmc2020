<?php include __DIR__ ."/../layout/header.php";  ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo "<h4>{$group['tournamentName']} {$group['tYear']} - {$group['groupName']}</h4>"; ?>
    </div>
    <div class="panel-body">
      <div class="panel panel-default table-responsive">
          <div class="panel-heading"><h4>History</h4></div>
        <table class="table table-striped">
            <?php foreach ($history AS $row): ?>
              <tr>
                  <?php echo "<td class='text-center'>{$row["homePlayerName"]} {$row["homePlayerSurname"]}</td><td>{$row["homeIcon"]}</td><td class='text-center'>{$row["homeGoals"]}:{$row["guestGoals"]}</td><td>{$row["guestIcon"]}</td><td>{$row["guestPlayerName"]} {$row["guestPlayerSurname"]}</td>"; ?>
              </tr>
              <?php endforeach; ?>
        </table>      
      </div>
    </div>
</div>


<?php include __DIR__ ."/../layout/footer.php";  ?>
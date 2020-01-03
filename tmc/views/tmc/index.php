<?php include __DIR__ . "/../layout/header.php"; ?>
<div class="page-header">
    <h3>
        <?php echo "{$tournament['name']} {$tournament['year']}"; ?>
    </h3>
</div>
<div class="panel-body">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading"><strong>Finalisten:</strong></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h2>Sieger: <img src="../image/logo/leer.gif" class="img-rounded" alt="Sieger" style="width: 32px; heigth: 32px;"/> ErstesTeam</h2></div>
                <div class="col-xs-6">
                    <img width="50%" class="img-responsive center-block" src="../image/2018/Sieger2018.jpg" alt="Sieger"></div>
                <div class="col-xs-6">
                    <img width="50%" class="img-responsive center-block" src="../image/2018/Team2018.jpg" alt="Team"></div>
                <div class="panel-body"></div>
                <div class="col-xs-12 text-center">
                    <h3>2.Platz: <img src="../image/logo/leer.gif" class="img-rounded" alt="Sieger" style="width: 32px; heigth: 32px;"/> ZweitesTeam</h3></div>
                <div class="col-xs-12 text-center">
                    <h3>3.Platz: <img src="../image/logo/leer.gif" class="img-rounded" alt="Sieger" style="width: 32px; heigth: 32px;"/> DrittesTeam</h3></div>
                <div class="col-xs-12 text-center">
                    <h3>4.Platz: <img src="../image/logo/leer.gif" class="img-rounded" alt="Sieger" style="width: 32px; heigth: 32px;"/> ViertesTeam</h3></div>
                <div class="panel-body"></div>
                <div class="col-xs-12 text-center">
                    <a href="../pdf/turnierheft2018.pdf" target="_blank">
                        <button type="button" class="btn btn-default">                    
                            <strong>Tackmann Cup Turnierheft 2018</strong>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel-body">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading"><strong>Beste Spieler:</strong></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 text-center">
                    <h3>Torwart:</h3></div>
                <div class="col-xs-6 text-center">
                    <h3>Torjäger:</h3></div>
                <div class="col-xs-6 text-center">
                    <h4><strong>Spieler</strong></h4>
                    <img src="../image/logo/leer.gif" class="img-rounded" alt="Sieger" style="width: 20px; heigth: 20px;"/> Team<br></div>
                <div class="col-xs-6 text-center">
                    <h4><strong>Spieler</strong></h4>
                    <img src="../image/logo/leer.gif" class="img-rounded" alt="Sieger" style="width: 20px; heigth: 20px;"/> Team<br>xx Tore</div>
                <div class="col-xs-6 text-center">
                    <img width="50%" class="img-responsive center-block" src="../image/2018/Torwart2018.JPG" alt="Tor"></div>
                <div class="col-xs-6 text-center">
                    <img width="50%" class="img-responsive center-block" src="../image/2018/Tore2018.JPG" alt="Torjäger"></div>
            </div>
        </div>
    </div>
</div>


<?php include __DIR__ . "/../layout/footer.php"; ?>




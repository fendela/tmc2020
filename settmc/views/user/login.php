<?php include __DIR__ . "/../layout/useheader.php"; ?>
<div class="page-header"><h3>Tackmanncup Administration Area</h3></div>
<div class="panel-body">
    <div class="row">
        <form method="POST" method="login" class="form-horizontal">
            <?php if ($error): ?>
                <div class="row">
                    <div class="col-xs-1"></div>
                    <p class="col-xs-10">
                        <?php
                        echo "Der Benutzer ist unbekannt oder das Passwort stimmt nicht!";
                        //echo " ";
                        //echo password_hash($pass, PASSWORD_DEFAULT);
                        ?>
                    </p>
                    <div class="col-xs-1"></div>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-1"></div>
                    <label class="col-xs-10">
                        Benutzername:
                    </label>
                    <div class="col-md-0 col-xs-1"></div>
                </div>
                <div class="row">
                    <div class="col-md-0 col-xs-1"></div>
                    <div class="col-xs-10">
                        <input type="text" name="loginname" class="form-control" />
                    </div>
                    <div class="col-xs-1"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-1"></div>
                    <label class="col-xs-10">
                        Password:
                    </label>
                    <div class="col-xs-1"></div>
                </div>
                <div class="row">
                    <div class="col-xs-1"></div>
                    <div class="col-xs-10">
                        <input type="password" name="password" class="form-control" />
                    </div>
                    <div class="col-xs-1"></div>
                </div>
            </div>

            <div class="col-xs-1"></div>
            <input type="submit" value="Einloggen" class="btn btn-primary" />
        </form>
    </div>
</div>
<br>

<?php include __DIR__ . "/../layout/footer.php"; ?>
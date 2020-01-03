<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tackmann Cup</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/default.css">

        <link rel="icon" href="../image/favicon.ico">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <img src="../image/personal2HD.png" alt="Main Image" style="width: 100%; padding-bottom: 0px">
        <nav class="navbar navbar-inverse" style="
             border-width: 0px;">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="settournament">Tackmann Cup</a>
                </div>

                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <?php echo $tournament["year"]; ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($tournaments AS $row): ?>
                                    <li><a href="settournament?tournament=<?php echo $row["id"]; ?>"><?php echo $row["year"]; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <?php
                                if (isset($group["groupName"])) {
                                    echo $group["groupName"];
                                } else {
                                    echo "Übersicht";
                                }
                                ?>                                            
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="settournament?tournament=<?php echo $thisTournament; ?>">&Uuml;bersicht</a></li>
                                <?php foreach ($groups AS $groupid): ?>
                                    <?php
                                    $target = "setgroup";
                                    if ($groupid['type'] == 0) {
                                        $target = "setfinalfour";
                                    }
                                    ?>
                                    <?php //if ($groupid['type']!=0){ ?>
                                    <?php echo "<li role='presentation'><a href='{$target}?group={$groupid['id']}'>{$groupid['groupName']}</a></li>"; ?>
                                    <?php //}  ?>
                                <?php endforeach; ?>
                                <li><a href="logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li><a href="logout"><span class='glyphicon glyphicon-off' aria-hidden='true'></span></a></li>
                    </ul>
                </div>
            </div>
        </nav>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Lennu broneering</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
    <!-- Bootstrapile lisaks -->
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= $_SERVER['PHP_SELF'] ?>">Lennu broneering</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav custom">
                <li class="active"><a href="<?= $_SERVER['PHP_SELF'] ?>">Pealeht</a></li>
                <li><a href="<?= $_SERVER['PHP_SELF']; ?>?view=about">Meist</a></li>
                <li><a href="#contact">Kontakt</a></li>
                <li><a href="<?= $_SERVER['PHP_SELF']; ?>?view=logout">Logi välja</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
<div class="container">
    <!-- laeb sõnumite olemasolul sõnumid välja -->
    <?php foreach (message_list() as $message):?>
        <div class="alert alert-danger">
            <?= $message; ?>
        </div>
    <?php endforeach; ?>
</div>
<div class="container">
    <!-- laeb sõnumite olemasolul sõnumid välja -->
    <?php foreach (message_list_successful() as $message):?>
        <div class="alert alert-success">
            <?= $message; ?>
        </div>
    <?php endforeach; ?>
</div>
<div class="container">
    <div class="starter-template flights">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Lennu suund</th>
                <th>Lennu aeg</th>
                <th>Kohti</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            // tsükkel mis koosneb HTML osast, lendude kirjed
            foreach (model_load_lennud($page) as $rida): ?>
                <tr>
                    <td>
                        <?=
                        // vältimaks pahatahtliku XSS sisu, kus kasutaja sisestab õige
                        // info asemel <script> tagi, peab asendama tekstiväljudis kõik HTML erisümbolid
                        htmlspecialchars($rida['lennu_nimi']);
                        ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($rida['lennu_algus']); ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($rida['kohti_kokku']); ?>
                    </td>
                    <td class="last">
                        <form method="get" action="<?= $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="view" value="book"/>
                            <input type="hidden" name="lennu_id" value="<?= $rida['lennu_id']; ?>"/>
                            <button class="btn btn-primary" type="submit">Broneerima</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.container -->
<!-- Lehekülgede vahetuse nupud -->
<ul class="pager">
    <li>
        <a href="<?= $_SERVER['PHP_SELF']; ?>?page=<?= $page - 1; ?>">
            Eelmine leht
        </a>
    </li>
    <li>
        <a href="<?= $_SERVER['PHP_SELF']; ?>?page=<?= $page + 1; ?>">
            Järgmine leht
        </a>
    </li>
</ul>
<!-- Bootstrap core JavaScript
   ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="css/bootstrap/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="css/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
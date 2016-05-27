<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">
    <title>Broneering</title>
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
            <a class="navbar-brand" href="<?= $_SERVER['PHP_SELF'] ?>">Lennu broneering</a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="starter-template flights">
        <table class="table table-responsive">
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
            // laeb vaid valitud lennu info
            foreach (model_show($lennu_id) as $rida): ?>
                <tr>
                    <td>
                        <?=
                        htmlspecialchars($rida['lennu_nimi']);
                        ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($rida['lennu_algus']); ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($rida['kohti_kokku']); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <div class="container">
            <table role="form">
                <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="action" value="bronn">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="lennu_id" value="<?= $lennu_id ?>">
                    <div class="form-group">
                        <label for="nimi">Nimi</label>
                        <input type="text" class="form-control" id="nimi" name="nimi"/>
                    </div>
                    <div class="form-group">
                        <label for="bronn_kohti">Kohtade arv</label>
                        <input type="number" class="form-control" id="bronn_kohti" name="bronn_kohti"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Kinnita broneering">
                        <button class="btn btn-danger"><a href="<?= $_SERVER['PHP_SELF']; ?>">Peata broneering</a></button>
                    </div>
                </form>
            </table>
        </div>
        <table class="table table-resonsive">
            <thead>
            <th>Kinnitatud broneeringud</th>
            </thead>
            <tbody>
            <?php
            // laeb valitud lennuks juba broneerinud kasutajanimed
            foreach (model_load_bronn($lennu_id) as $rida): ?>
                <tr>
                    <td><?= $rida['nimi'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.container -->
<!-- Bootstrap core JavaScript
   ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="css/bootstrap/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../css/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
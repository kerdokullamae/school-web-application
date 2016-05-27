<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Bootstrapile lisaks -->
    <link rel="stylesheet" href="css/registration-login.css" type="text/css"/>
    <title>Sisselogimine</title>
</head>
<body>
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
<!-- bootstrap template -->
<div class="container">
    <form class="form-signin" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="action" value="login"/>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        <h2 class="form-signin-heading">Sisselogimine</h2>
        <input type="text" class="form-control" placeholder="Kasutajanimi" name="kasutajanimi" required autofocus>
        <input type="password" class="form-control" placeholder="Parool" name="parool" required>
        <input class="btn btn-lg btn-primary btn-block" type="submit" value="Logi sisse">
    </form>
</div>
<!-- /container -->
<h3>Ei ole registreeritud? <a href="<?= $_SERVER['PHP_SELF']; ?>?view=register">Registreeri siit!</a></h3>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/registration-login.css" type="text/css"/>
    <!-- Bootstrapile lisaks -->
    <title>Registreerimine</title>
</head>
<body>
<form class="form-signin" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="action" value="register"/>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <h2 class="form-signin-heading">Registreeri siin</h2>
    <input type="text" class="form-control" placeholder="Sisesta kasutajanimi" name="kasutajanimi" required autofocus>
    <input type="password" class="form-control" placeholder="Sisesta parool" name="parool" required>
    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Registreeri">
</form>
<h3>Kasutaja olemas? <a href="<?= $_SERVER['PHP_SELF']; ?>?view=login">Logi sisse siit!</a></h3>
</body>
</html>
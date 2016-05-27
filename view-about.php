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
    <title>Meist</title>
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
<br>
<div class="container">
    <div class="col-md-6">
        <img class="img-responsive" src="http://az616578.vo.msecnd.net/files/2015/12/12/635855347395608393164383721_Airport-terminal1.jpg" alt="Lennujaam"/>
    </div>
    <div class="col-md-6">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in velit ac massa aliquet viverra sed at neque. Praesent augue elit, lobortis id tellus sit amet, hendrerit euismod diam. Sed tempus semper mi sed tempor. In iaculis erat sit amet elit accumsan, at vehicula nibh ultricies. In ut vestibulum augue. Nam accumsan egestas posuere. Phasellus a sodales felis. Nunc interdum viverra libero, quis viverra ligula. In sed metus lacinia, vestibulum enim eu, pretium lectus. Mauris lacinia tristique nisi, et lacinia lorem consectetur id. Quisque facilisis iaculis metus, quis hendrerit nulla ullamcorper vitae. Phasellus facilisis pulvinar metus aliquet pellentesque. Aenean leo leo, hendrerit at aliquam nec, rutrum vitae ligula.</p>
    </div>
</div>
</body>
</html>
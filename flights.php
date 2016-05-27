<?php

session_start();

// Genereerib sessiooni tarvis unikaalse CSRF(Cross Site Request Forgery) tokeni
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(20));
}

// andmete haldamis meetodite sisse laadimine
require 'model.php';

// andmete modifitseerimise meetodid
require 'controller.php';

// rakenduse "ruuter" POST päringu puhul
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // $result muutuja abil saab tuvastada kas toimus mõni õnnestunud tegevus
    $result = false;

    // POST tegevused on lubatud vaid siis kui päringuga tuleb kaasa õige CSRF token.
    // Eeldusel, et kõikkidesse vormi väljadesse on pandud see peidetuna sisse
    if (!empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {

        switch ($_POST['action']) {

            case 'register':
                $kasutajanimi = $_POST['kasutajanimi'];
                $parool       = $_POST['parool'];
                $result       = controller_register($kasutajanimi, $parool);
                break;

            case 'login':
                $kasutajanimi = $_POST['kasutajanimi'];
                $parool       = $_POST['parool'];
                $result       = controller_login($kasutajanimi, $parool);
                break;

            case 'bronn':
                $lennu_id    = intval($_POST['lennu_id']);
                $nimi        = $_POST['nimi'];
                $bronn_kohti = intval($_POST['bronn_kohti']);
                $result      = controller_add_bronn($nimi, $lennu_id, $bronn_kohti);
                break;
        }
    }


    else {
        // ilmub, kui POST päringuga ei kaasne korrektset CSRF tokenit
        message_add('Vigane päring, CSRF token ei vasta oodatule');

    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    // POST päringu puhul sisu ei näita
    exit;
}

// rakenduse "ruuter" GET päringu korral
if (!empty($_GET['view'])) {
    switch ($_GET['view']) {
        case 'login':
            require 'view-login.php';
            break;
        case 'register':
            require 'view-registration.php';
            break;
        case 'logout':
            $result = controller_logout();
            header('Location: ' . $_SERVER['PHP_SELF']);
            break;
        case 'book':
            $lennu_id = $_GET['lennu_id'];
            require 'view-booking.php';
            break;
        case 'about':
            require 'view-about.php';
            break;
        default:
            header('Content-type: text/plain; charset=utf-8');
            echo "Tundmatu valik!";
            exit;
    }
} else {
    // kontroll, korrektse login sessiooni üle
    // korrektse sessiooni puudumise korral suunab sisselogimisele
    if (!controller_user()) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?view=login');
        exit;
    }

    if (empty($_GET['page'])) {
        $page = 1;
    } else {
        $page = intval($_GET['page']);
        if ($page < 1) {
            $page = 1;
        }
    }

    // laeb sisse pealehe vaate
    require 'view.php';
}

mysqli_close($con);




















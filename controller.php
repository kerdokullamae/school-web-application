<?php

/**
 * Kontroll kasutaja sisselogimise üle
 *
 * @return korrektne sessioon
 */
function controller_user()
{
    if (empty($_SESSION['login'])) {
        return false;
    }

    return $_SESSION['login'];
}

/**
 * Lisab uue konto ja kontrollib kasutajanime ja parooli sobivust
 *
 * @param $kasutajanimi
 * @param $parool
 * @return bool|int
 */
function controller_register($kasutajanimi, $parool)
{

    if ($kasutajanimi == "" || $parool == "") {
        message_add('Vigased andmed! Palun proovige uuesti!');
        return false;
    }

    if (model_user_add($kasutajanimi, $parool)) {
        message_add_successful('Konto on registreeritud!');
        return true;
    }

    message_add('Konto registreerimine ebaõnnestus, kasutajanimi võib juba olla kasutusel!');
    return false;
}

/**
 * Logib kasutaja sisse kasutajanime ja parooli sobivuse korral
 *
 * @param $kasutajanimi
 * @param $parool
 * @return bool
 */
function controller_login($kasutajanimi, $parool)
{
    if ($kasutajanimi == "" || $parool == "") {
        message_add('Vigased andmed!');
        return false;
    }

    $id = model_user_get($kasutajanimi, $parool);

    if (!$id) {
        message_add('Vale kasutajanimi või parool!');
        return false;
    }

    session_regenerate_id();

    message_add_successful('Sisselogimine õnnestus!');

    $_SESSION['login'] = $id;
    return $id;
}

/**
 * Logib kasutaja välja
 *
 * @return bool
 */
function controller_logout()
{

    // sessiooni küpsis muutub kehtetuks
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }

    // sessiooni massiivi tühejndus
    $_SESSION = array();
    session_destroy();

    message_add_successful('Olete edukalt välja loginud!');

    return true;
}

/**
 * Laeb valitud kirjed
 *
 * @param $lennu_id
 * @return array
 */
function controller_show($lennu_id)
{
    if (!controller_user()) {
        message_add('Palun logige sisse!');
        return false;
    }

    if ($lennu_id > 0) {
        $row = model_show($lennu_id);
        return $row;
    }
}

/**
 * Lisab uue kirje ning edastab teate vastavalt kasutaja sisestusele
 *
 * @param $nimi
 * @param $lennu_id
 * @param $bronn_kohti
 * @return bool
 */
function controller_add_bronn($nimi, $lennu_id, $bronn_kohti)
{
    if (!controller_user()) {
        message_add('Palun logige sisse!');
        return false;
    }

    $row = model_check($lennu_id);

    $lennu_algus = strtotime($row['lennu_algus']);
    $bronn_aeg   = time();

    if ($nimi == "" || $bronn_kohti <= 0) {
        message_add('Vigased andmed, broneering ebaõnnestus!');
        return false;
    }

    if ($bronn_kohti > $row['kohtade_arv']) {
        message_add('Valitud lennul ei ole piisavalt kohti!');
        return false;
    }

    if ($bronn_aeg >= $lennu_algus) {
        message_add('Valitud lennule broneerimise aeg on lõppenud!');
        return false;
    }

    if (model_add_bronn($nimi, $lennu_id, $bronn_kohti)) {
        message_add_successful('Broneering kinnitatud!');
        return true;
    }
}

/**
 * Lisab järjekorda uue sõnumi kasutajale kuvamiseks
 *
 * @param $message
 */
function message_add($message)
{

    if (empty($_SESSION['messages'])) {
        $_SESSION['messages'] = array();
    }

    $_SESSION['messages'][] = $message;
}

/**
 * Tagastab kõik hetkel ootel olevad sõnumid
 *
 * @return array sõnumite massiiv
 */
function message_list()
{

    if (empty($_SESSION['messages'])) {
        return array();
    }

    $messages             = $_SESSION['messages'];
    $_SESSION['messages'] = array();

    return $messages;
}

/**
 * Lisab järjekorda uue sõnumi kasutajale kuvamiseks
 *
 * @param $message
 */
function message_add_successful($message)
{
    if (empty($_SESSION['messages_suc'])) {
        $_SESSION['messages_suc'] = array();
    }

    $_SESSION['messages_suc'][] = $message;
}

/**
 * Tagastab kõik hetkel ootel olevad sõnumid
 *
 * @return array sõnumite massiiv
 */
function message_list_successful()
{

    if (empty($_SESSION['messages_suc'])) {
        return array();
    }

    $messages                 = $_SESSION['messages_suc'];
    $_SESSION['messages_suc'] = array();

    return $messages;
}
















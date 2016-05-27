<?php

$host = "localhost";
$user = "test";
$pass = "t3st3r123";
$db   = "test";

$con = mysqli_connect($host, $user, $pass, $db);
mysqli_query($con, 'SET CHARACTER SET UTF8') or die("Error, andmebaasi charsetti seadmine ebaõnnestus");


/**
 * Lisab kasutaja andmebaasi ning kasutaja nimi peab olema unikaalne.
 * Parool salvestakse BCRYPT räsina.
 *
 * @param $kasutajanimi mis lisatakse andmebaasi
 * @param $parool algne parool, mis lisatakse hashina andmebaasi
 * @return int $id lisatud kasutaja ID
 */
function model_user_add($kasutajanimi, $parool)
{
    global $con;

    $hash = password_hash($parool, PASSWORD_DEFAULT);

    $query = 'INSERT INTO kerdok__kasutajad (kasutajanimi, parool) VALUES (?,?)';
    $stmt  = mysqli_prepare($con, $query);
    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'ss', $kasutajanimi, $hash);
    mysqli_stmt_execute($stmt);

    $id = mysqli_stmt_insert_id($stmt);

    mysqli_stmt_close($stmt);

    return $id;
}


/**
 * Tagastab kasutaja ID kui kasutajanimi ja parool ühtivad andmebaasis olevaga
 *
 * @param $kasutajanimi otsitavada kasutaja kasutajanimi
 * @param $parool otsitava kasutaja parool
 * @return $id kasutaja ID
 */
function model_user_get($kasutajanimi, $parool)
{
    global $con;

    $query = 'SELECT kasutaja_id, parool FROM kerdok__kasutajad WHERE kasutajanimi=? LIMIT 1';
    $stmt  = mysqli_prepare($con, $query);

    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 's', $kasutajanimi);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $hash);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (password_verify($parool, $hash)) {
        return $id;
    } else {
        return false;
    }

}

/**
 * Laeb andmebaasist kõik kirjed ja tagastab need massiivina
 *
 * @param $page lehekülje nr, mille kirjeid kuvatakse
 * @return array andmebaasi read
 */
function model_load_lennud($page)
{
    global $con;
    $max   = 8;
    $start = ($page - 1) * $max;

    $query = 'SELECT lennu_id, lennu_nimi, lennu_algus, kohtade_arv FROM kerdok__lennud ORDER BY lennu_nimi ASC LIMIT ?,?';
    $stmt  = mysqli_prepare($con, $query);

    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'ii', $start, $max);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $lennu_id, $lennu_nimi, $lennu_algus, $kohti_kokku);

    $rows = array();
    while (mysqli_stmt_fetch($stmt)) {
        $rows[] = array(
            'lennu_id' => $lennu_id,
            'lennu_nimi' => $lennu_nimi,
            'lennu_algus' => $lennu_algus,
            'kohti_kokku' => $kohti_kokku
        );
    }

    mysqli_stmt_close($stmt);

    return $rows;
}

/**
 * Laeb andmebaasist vastava lennu_id kirjed ning tagastab massiivina
 *
 * @param $lennu_id valitud lennu ID
 * @return array valitud lennu kirjed
 */
function model_show($lennu_id)
{
    global $con;

    $query = 'SELECT lennu_nimi, lennu_algus, kohtade_arv FROM kerdok__lennud WHERE lennu_id=?';
    $stmt  = mysqli_prepare($con, $query);

    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'i', $lennu_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $lennu_nimi, $lennu_algus, $kohti_kokku);


    $rows = array();
    while (mysqli_stmt_fetch($stmt)) {
        $rows[] = array(
            'lennu_nimi' => $lennu_nimi,
            'lennu_algus' => $lennu_algus,
            'kohti_kokku' => $kohti_kokku
        );
    }

    mysqli_stmt_close($stmt);

    return $rows;

}

/**
 * Lisab andmebaasi uue broneeringu rea ning uuendab vastava lennu kohtade arvu
 *
 * @param $nimi sisestud broneeringu nimetus
 * @param $lennu_id lennu ID, mille pihta broneering käib
 * @param $bronn_kohti broneeritud kohtade arv
 * @return $id lisatud rea ID
 */
function model_add_bronn($nimi, $lennu_id, $bronn_kohti)
{
    global $con;

    $query = "INSERT INTO kerdok__broneeringud (nimi, lennu_id, kohtade_arv) VALUES (?,?,?)";
    $stmt  = mysqli_prepare($con, $query);

    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'sii', $nimi, $lennu_id, $bronn_kohti);
    mysqli_stmt_execute($stmt);

    $id = mysqli_stmt_insert_id($stmt);

    mysqli_stmt_close($stmt);

    $update = "UPDATE kerdok__lennud SET kohtade_arv = kohtade_arv - ? WHERE lennu_id= ?";
    $stmt2  = mysqli_prepare($con, $update);

    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    mysqli_stmt_bind_param($stmt2, 'ii', $bronn_kohti, $lennu_id);
    mysqli_stmt_execute($stmt2);

    mysqli_stmt_close($stmt2);

    return $id;
}

/**
 * Laeb andmebaasist kirjed broneeringu teinud kasutajate kohta
 *
 * @param $lennu_id lennu ID mille kirjeid kuvada
 * @return array andmebaasi read
 */
function model_load_bronn($lennu_id)
{
    global $con;

    $query = 'SELECT nimi FROM kerdok__broneeringud WHERE lennu_id=?';
    $stmt  = mysqli_prepare($con, $query);

    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'i', $lennu_id);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nimi);

    $rows = array();
    while (mysqli_stmt_fetch($stmt)) {
        $rows[] = array(
            'nimi' => $nimi
        );
    }
    return $rows;
}

/**
 * Laeb andmebaasist kirjed, broneeringu tarvis
 *
 * @param $lennu_id lennu ID mille kirjed lähevad kasutusse
 * @return array andmebaasi read
 */
function model_check($lennu_id)
{
    global $con;

    $query = 'SELECT kohtade_arv, lennu_algus FROM kerdok__lennud WHERE lennu_id=? LIMIT 1';
    $stmt  = mysqli_prepare($con, $query);

    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'i', $lennu_id);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $kohtade_arv, $lennu_algus);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $row = array(
        'kohtade_arv' => $kohtade_arv,
        'lennu_algus' => $lennu_algus
    );

    return $row;
}
























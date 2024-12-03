<?php
session_start();

$summa = floatval($_POST['summa']);
$tililta = $_POST['from'];
$tilille = $_POST['to'];

$dbhost = 'localhost';
$dbport = '5432';
$dbname = 'tietokanta_nimi';
$dbuser = 'tietokanta_kayttaja';
$dbpass = 'tietokanta_salasana';

$conn = pg_connect("host=$dbhost port=$dbport dbname=$dbname user=$dbuser password=$dbpass");
if (!$conn) {
    die('Ei voitu yhdistää tietokantaan: ' . pg_last_error());
}

pg_query($conn, 'BEGIN');

$veloita_query = "UPDATE TILIT SET summa = summa - $1 WHERE tilinumero = $2 AND summa >= $1";
$veloita_result = pg_query_params($conn, $veloita_query, array($summa, $tililta));

if (!$veloita_result || pg_affected_rows($veloita_result) != 1) {
    pg_query($conn, 'ROLLBACK');
    die('Virhe: Ei tarpeeksi katetta tai väärä lähtötilinumero.');
}

$hyvita_query = "UPDATE TILIT SET summa = summa + $1 WHERE tilinumero = $2";
$hyvita_result = pg_query_params($conn, $hyvita_query, array($summa, $tilille));

if (!$hyvita_result || pg_affected_rows($hyvita_result) != 1) {
    pg_query($conn, 'ROLLBACK');
    die('Virhe: Väärä kohdetilinumero.');
}

$omistaja_1_query = "SELECT omistaja FROM TILIT WHERE tilinumero = $1";
$omistaja_1_result = pg_query_params($conn, $omistaja_1_query, array($tililta));
$omistaja_1_row = pg_fetch_assoc($omistaja_1_result);
$omistaja_1 = $omistaja_1_row['omistaja'];

$omistaja_2_query = "SELECT omistaja FROM TILIT WHERE tilinumero = $1";
$omistaja_2_result = pg_query_params($conn, $omistaja_2_query, array($tilille));
$omistaja_2_row = pg_fetch_assoc($omistaja_2_result);
$omistaja_2 = $omistaja_2_row['omistaja'];

pg_query($conn, 'COMMIT');

$_SESSION['omistaja_1'] = $omistaja_1;
$_SESSION['omistaja_2'] = $omistaja_2;
$_SESSION['summa'] = $summa;

pg_close($conn);

header('Location: tulos.php');
exit();

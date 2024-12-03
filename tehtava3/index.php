<?php
session_start();

include 'db.php';

$conn = pg_connect("host=$dbhost port=$dbport dbname=$dbname user=$dbuser password=$dbpass");
if (!$conn) {
    die('Ei voitu yhdistää tietokantaan: ' . pg_last_error());
}

$create_table_query = "
CREATE TABLE IF NOT EXISTS TILIT (
    tilinumero VARCHAR(20) PRIMARY KEY,
    omistaja VARCHAR(100),
    summa NUMERIC(15,2)
);
";
$result = pg_query($conn, $create_table_query);
if (!$result) {
    die('Taulun luominen epäonnistui: ' . pg_last_error());
}

$insert_account_query = "
INSERT INTO TILIT (tilinumero, omistaja, summa) VALUES
('abc', 'Testikäyttäjä', 100.00)
ON CONFLICT (tilinumero) DO NOTHING;
";
$result = pg_query($conn, $insert_account_query);
if (!$result) {
    die('Testitilin lisääminen epäonnistui: ' . pg_last_error());
}

pg_close($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tilisiirto</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <h1>Tilisiirto</h1>
    <form action="tilisiirto.php" method="post">
        <label for="summa">Siirrettävä summa:</label><br>
        <input type="number" step="0.01" name="summa" id="summa" required><br><br>

        <label for="from">Veloitettava tilinumero:</label><br>
        <input type="text" name="from" id="from" required><br><br>

        <label for="to">Tilinumero, jonne summa siirretään:</label><br>
        <input type="text" name="to" id="to" required><br><br>

        <input type="submit" value="Siirrä">
    </form>
</body>

</html>
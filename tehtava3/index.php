<?php
session_start();
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
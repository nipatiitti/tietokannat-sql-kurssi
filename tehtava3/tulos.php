<?php
session_start();

if (!isset($_SESSION['omistaja_1']) || !isset($_SESSION['omistaja_2']) || !isset($_SESSION['summa'])) {
    die('Ei siirtotietoja saatavilla.');
}

$omistaja_1 = $_SESSION['omistaja_1'];
$omistaja_2 = $_SESSION['omistaja_2'];
$summa = $_SESSION['summa'];

// Tyhjennetään sessiomuuttujat
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tilisiirron tulos</title>
</head>

<body>
    <h1>Tilisiirto onnistui</h1>
    <p><?php echo htmlspecialchars($omistaja_1); ?> on siirtänyt <?php echo htmlspecialchars(number_format($summa, 2)); ?> euroa henkilölle <?php echo htmlspecialchars($omistaja_2); ?>.</p>
</body>

</html>
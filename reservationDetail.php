<?php
session_start();

//Controleert of ik de pagina wel mag bezoeken.
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/** @var $db */
require_once "DB.php";

//Als er geen ID gedetecteerd wordt, dan redirect je naar de reserveringen page.
if (!isset($_GET['id']) || $_GET['id'] === '') {
    header('Location: afsprakenAdminPageV2.php');
    exit;
}

$reservationId = $_GET['id'];

//De specifieke data uit de database halen.
$query = "SELECT * FROM reservation WHERE id = " . $reservationId;
$result = mysqli_query($db, $query);

//Als de reservering niet gevonden is, of bestaat niet dan terug naar de reserveringen page.
if (mysqli_num_rows($result) == 0) {
    header('Location: afsprakenAdminPageV2.php');
    exit;
}
//De specifieke rij in de database wordt een array
$reservation = mysqli_fetch_assoc($result);

mysqli_close($db);

?>

<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Patta's By Tom</title>
    <link rel="stylesheet" href="./styleHomepage.css">
</head>

<body>

<header>
    <h1>
        <img src="pattasbytomlogo.jpg" width="400" height="440">
    </h1>
</header>
<div class="menubar">
    <nav>
        <div><a href="logout.php">Log Uit</a></div>
    </nav>
</div>

<main>
    <section id="Detail">
        <h2>Details van reservering nr. <?= $reservation['id'] ?></h2>
    <ul>
        <li>Voornaam: <?= htmlspecialchars($reservation['firstName']) ?></li>
        <br>
        <li>Achternaam: <?= $reservation['lastName'] ?></li>
        <br>
        <li>E-mail: <?= $reservation['email'] ?></li>
        <br>
        <li>Telefoonnummer: <?= $reservation['number'] ?></li>
        <br>
        <li>Sneaker model: <?= $reservation['model'] ?></li>
        <br>
        <li>Wensen: <?= $reservation['wish'] ?></li>
    </ul>
        <br>
        <a href="afsprakenAdminPageV2.php">Terug</a>
    </section>
</main>

<footer>
    <div>Links</div>
    <br>
    <a href = "https://www.instagram.com/pattas_by_tom/" title="Klik om onze Instagram pagina te bekijken" target="_blank">Instagram</a>
    <br>
    <br>
    <a href = "loginpagereal.php" title="Klik om naar de in log pagina te gaan">Log In</a>
</footer>
<!-- partial -->

</body>
</html>


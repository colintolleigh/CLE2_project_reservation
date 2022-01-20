<?php
session_start();
/** @var $db */
require_once "DB.php";

//Mag ik deze pagina bezoeken?
if (!isset($_SESSION['admin'])) {
    header("Location: loginpagereal.php");
    exit;
}

//SQL query opbouwen en het resultaat er vandaan halen
$query = "SELECT * FROM reservation";
$result = mysqli_query($db, $query);

//Steeds het resultaat loopen en dat in een array te zetten.
$reservations = [];
while ($row = mysqli_fetch_assoc($result))  {
    $reservations[] = $row;
}

//Connectie met de database afsluiten.
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
        <div><a href="homepage.php">Home</a></div>
        <div><a href="reservepage.php">Reserveren</a></div>
        <div><a href="aboutPage.php">About</a></div>
        <div><a href="logout.php">Log Uit</a></div>
    </nav>
</div>

<main>

    <section id="Welcome">
        <h2>Welkom!</h2>
        <p>Welkom op de adminpage, hier zijn alle admin gerelateerde functies.</p>
        <br>
        <p>Hier staan alle reserveringen en kunt u ze ook aanpassen en eventueel verwijderen.
        </p>
    </section>
    <section id="Reservations">
        <h2>Reserveringen</h2>
        <br>
        <table>
            <thead>
            <tr>
                <th>id</th>
                <th>Achternaam</th>
                <th>E-mail</th>
                <th>Telefoonnummer</th>
                <th>Sneaker</th>
                <th>Acties</th>
                <th colspan="3"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reservations as $reservation) { ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['id']) ?></td>
                    <td><?= htmlspecialchars($reservation['lastName']) ?></td>
                    <td><?= htmlspecialchars($reservation['email'] ) ?></td>
                    <td><?= htmlspecialchars($reservation['number']) ?></td>
                    <td><?= htmlspecialchars($reservation['model']) ?></td>
                    <td><a href="reservationDetail.php?id=<?= $reservation['id'] ?>">Details</a></td>
                    <td><a href="reservationEditV2.php?id=<?= $reservation['id'] ?>">Edit</a></td>
                    <td><a href="reservationDelete.php?id=<?= $reservation['id'] ?>">Delete</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
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


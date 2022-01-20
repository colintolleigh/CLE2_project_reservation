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

if (isset($_POST['submit']))  {
    //Haalt de id op en slaat het in een andere variabale op.
    //Maakt de query waarbij je de specifieke reserering uit de database verwijdert.
    $reservationId = mysqli_escape_string($db, $_POST['id']);
    $query = "SELECT * FROM reservation WHERE id = '$reservationId'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    $reservation = mysqli_fetch_assoc($result);

    //De reservering verwijderen
    $query = "DELETE FROM reservation WHERE id = '$reservationId'";
    mysqli_query($db, $query) or die ('Error: ' . mysqli_error($db));

    //Verbinding met de database wordt afgebroken.
    mysqli_close($db);

    //Als de reservering is verwijderd word je teruggestuurd naar de reserveringen page.
    header("Location: afsprakenAdminPageV2.php");
    exit;

} else if (isset($_GET['id']) || $_GET['id'] != '') {
    $reservationId = mysqli_escape_string($db, $_GET['id']);

    $query = "SELECT * FROM reservation WHERE id = '$reservationId'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    if (mysqli_num_rows($result) == 1) {
        $reservation = mysqli_fetch_assoc($result);
    } else {
        //Redirect als er geen resultaat is.
        header('Location: afsprakenAdminPageV2.php');
        exit;
    }
} else {
    //Redirecten als er geen Id is verstuurd in de form.
    header('Location: afsprakenAdminPageV2.php');
    exit;
}
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
    <section id="Details">
        <section id="Detail">
            <h2>Details van reservering nr. <?= $reservation['id'] ?></h2>
            <ul>
                <li>Voornaam: <?= $reservation['firstName'] ?></li>
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
        </section>
    </section>
    <section id="Delete">
        <h2>Verwijderen van reservering nr. <?= $reservation['id'] ?></h2>
        <form action="" method="post">
            <p>
                Weet u zeker dat u reservering nummer "<?= $reservation['id'] ?>" wilt verwijderen?
            </p>
            <input type="hidden" name="id" value="<?= $reservation['id'] ?>"/>
            <input type="submit" name="submit" value="Verwijderen"/>
        </form>
        <br>
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

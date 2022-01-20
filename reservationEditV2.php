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

if (isset($_POST['submit'])) {
    $firstName = mysqli_escape_string($db, $_POST['firstName']);
    $lastName = mysqli_escape_string($db, $_POST['lastName']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $number = mysqli_escape_string($db, $_POST['number']);
    $model = mysqli_escape_string($db, $_POST['model']);
    $wish = mysqli_escape_string($db, $_POST['wish']);

    $errors = [];
    if ($firstName == "") {
        $errors['naam'] = "Vul aub de naam in";
    }
    if ($lastName == "") {
        $errors['merk'] = "Vul aub het merk in";
    }
    if ($email == "") {
        $errors['soort'] = "Vul aub de soort in";
    }

    if ($number == "") {
        $errors['prijs'] = "Vul aub de prijs in";
    }

    if ($model == "") {
        $errors['prijs'] = "Vul aub de prijs in";
    }

    if ($wish == "") {
        $errors['prijs'] = "Vul aub de prijs in";
    }

    if (empty($errors)) {
        //UPDATE in DB
        $query = "UPDATE reservation
                        SET firstName = '$firstName', lastName = '$lastName', email = '$email', number = '$number',
                            model = '$model', wish = '$wish' WHERE id = '$reservationId'";
        $result = mysqli_query($db, $query);

        if ($result) {
            $success = "Hij is geupdate in de DB";
            header('Location: reservationDetail.php');
            exit;
        } else {
            $errors['db'] = mysqli_error($db);
        }
    }
}
//Verbinding verbreken.
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

<style>
    input[type=text]{
        width: 100%;
        padding: 12px 15px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

</style>

<div class="menubar">
    <nav>
        <div><a href="homepage.php">Home</a></div>
        <div><a href="reservepage.php">Reserveren</a></div>
        <div><a href="aboutPage.php">About</a></div>
        <div><a href="logout.php">Log Uit</a></div>
    </nav>
</div>

<main>
    <section id="Detail">
        <h2>Huidige details van reservering nr. <?= $reservation['id'] ?></h2>
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

    <section id="reservationEdit">
        <h2>Bewerken van reservering nr. <?= $reservation['id'] ?></h2>
        <form action ="" method="post">
            <div>
                <label for="firstName">Voornaam:</label>
                <input type="text" name="firstName" id="firstName" autocomplete="off" value="<?= htmlentities($reservation['firstName']); ?>"/>
                <?php if (isset($errors['firstName']))  {
                    echo $errors['firstName'];
                }
                ?>
            </div>
            <br>
            <div>
                <label for="lastName">Achternaam:</label>
                <input type="text" name="lastName" id="lastName" autocomplete="off" value="<?= htmlentities($reservation['lastName']); ?>"/>
                <?php if (isset($errors['lastName']))  {
                    echo $errors['lastName'];
                }
                ?>
            </div>
            <br>
            <div>
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" autocomplete="off" value="<?= htmlentities($reservation['email']); ?>"/>
                <?php if (isset($errors['email']))  {
                    echo $errors['email'];
                }
                ?>
            </div>
            <br>
            <div>
                <label for="number">Telefoonnummer:</label>
                <input type="text" name="number" id="number" autocomplete="off" value="<?= htmlentities($reservation['number']); ?>"/>
                <?php if (isset($errors['number']))  {
                    echo $errors['number'];
                }
                ?>
            </div>
            <br>
            <div>
                <label for="model">Sneaker Model:</label>
                <input type="text" name="model" id="model" autocomplete="off" value="<?= htmlentities($reservation['model']); ?>"/>
                <?php if (isset($errors['model']))  {
                    echo $errors['model'];
                }
                ?>
            </div>
            <br>
            <div>
                <label for="wish">Wensen:</label>
                <input type="text" name="wish" id="wish" autocomplete="off" value="<?= htmlentities($reservation['wish']); ?>"/>
                <?php if (isset($errors['wish']))  {
                    echo $errors['wish'];
                }
                ?>
            </div>
            <br>
            <div class="data-submit">
                <input type="hidden" name="id" value="<?= htmlentities($reservationId); ?>"/>
                <input type="submit" name="submit" value="Verstuur"/>
            </div>
        </form>
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


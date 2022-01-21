<?php

//Connectie met de database.
/** @var $db */
require_once "DB.php";


//Als er op de bevestigen knop is gedrukt dan worden de waardes in de variabelen opgeslagen
if (isset($_POST['submit'])) {
    $firstName = htmlspecialchars(mysqli_escape_string($db, $_POST['firstName']));
    $lastName = htmlspecialchars(mysqli_escape_string($db, $_POST['lastName']));
    $email = htmlspecialchars(mysqli_escape_string($db, $_POST['email']));
    $number = htmlspecialchars(mysqli_escape_string($db, $_POST['number']));
    $model = htmlspecialchars(mysqli_escape_string($db, $_POST['model']));
    $wish = htmlspecialchars(mysqli_escape_string($db, $_POST['wish']));

//De error messages als een invulveld bijvoorbeeld leeg is
    if (empty($_POST['firstName'])) {
        $errorFirstName = 'U moet uw voornaam invullen!';
    }

    if (empty($_POST['lastName'])) {
        $errorLastName = 'U moet uw achternaam invullen!';
    }

    if (empty($_POST['email'])) {
        $errorEmail = 'Uw email is verplicht!';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorFirstName = '<p>U moet een geldige e-mail invoeren!</p>';
        }
    }

    if (empty($_POST['number'])) {
        $errorNumber = 'Uw telefoonnummer is verplicht';
    }

    if (empty($_POST['model'])) {
        $errorModel = 'Vul in welke sneaker u gebruikt!';
    }

    if (empty($_POST['wish'])) {
        $errorWish = 'Vul in wat uw wensen zijn van uw custom sneaker!';
    }

    //De commando (query) die de php moet uitvoeren om de info in de database op te slaan en vervolgens bij
    // succes naar de bevestiginspagina wordt doorgestuurd.
    if (empty($errorFirstName || $errorLastName || $errorEmail || $errorNumber || $errorModel || $errorWish)) {
        $query = "INSERT INTO reservation (firstName, lastName, email, number, model, wish)
                  VALUES ('$firstName', '$lastName', '$email', '$number', '$model', '$wish')";
        $result = mysqli_query($db, $query) or die('Error: ' . $query);
        if ($result == TRUE) {
            header('Location: testVoorReserverenDB.php');
        }
    }
}




?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Patta's By Tom</title>
    <link rel="stylesheet" href="./styleHomepage.css">

    <style>
        .error {color: #FF0000;}
    </style>

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
    </nav>
</div>

<style>
    input[type=text], input[type=password], input[type=email] {
        width: 100%;
        padding: 12px 15px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }
</style>

<main>
    </section>
    <section id="Reserveren">
        <h1>Reserveren</h1>
        <p>
        <div>
            <main class="content-wrapper">
                <article class="site-content">
                    <h2>Welkom op de reserveringspagina!</h2>
                    <p>
                        U doorloopt hier het proces om een reservering te maken.
                        <br>
                        Vul hier alstublieft alle velden in.
                        <br>
                    <form action="" method="post">
                        <div class="data-field">
                            <label for="firstName">Voornaam: </label>
                            <input id="firstName" type="text" name="firstName"
                                   placeholder="Vul hier uw voornaam in" autocomplete="off"
                                   value="<?= isset($firstName) ? htmlentities($firstName) : ''?>"/>
                            <span class = "error"><?php echo $errorFirstName;?></span>
                            <br><br>
                            <label for="lastName">Achternaam: </label>
                            <input id="lastName" type="text" name="lastName"
                                   placeholder="Vul hier uw achternaam in" autocomplete="off"
                                   value="<?= isset($lastName) ? htmlentities($lastName) : ''?>"/>
                            <span class = "error"><?php echo $errorLastName;?></span>
                            <br><br>
                            <label for="email">E-mail: </label>
                            <input id="email" type="email" name="email"
                                   placeholder="Vul hier uw e-mail in" autocomplete="off"
                                   value="<?= isset($email) ? htmlentities($email) : ''?>" />
                            <span class = "error"><?php echo $errorEmail;?></span>
                            <br><br>
                            <label for="number">Telefoonnummer: </label>
                            <input id="number" type="text" name="number"
                                   placeholder="Vul hier uw telefoonnummer in" autocomplete="off"
                                   value="<?= isset($number) ? htmlentities($number) : ''?>"/>
                            <span class = "error"><?php echo $errorNumber;?></span>
                            <br><br>
                            <label for="model">Sneaker model: </label>
                            <input id="model" type="text" name="model"
                                   placeholder="Vul hier in welk sneaker model u gebruikt" autocomplete="off"
                                   value="<?= isset($model) ? htmlentities($model) : ''?>"/>
                            <span class = "error"><?php echo $errorModel;?></span>
                            <br><br>
                            <label for="wish">Wensen: </label>
                            <input id="wish" type="text" name="wish"
                                   placeholder="Vul hier uw wensen in bijv. restauratie, andere kleur, patroon etc." autocomplete="off"
                                   value="<?= isset($wish) ? htmlentities($wish) : ''?>"/>
                            <span class = "error"><?php echo $errorWish;?></span>
                        </div>
                        <br>
                        <div class="data-submit">
                            <input type="submit" name="submit" value="Bevestigen"/>
                        </div>
                    </form>
                    </p>
                </article>
            </main>
        </div>
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


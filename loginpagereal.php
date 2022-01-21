
<?php

session_start();

/** @var $db */
require_once "DB.php";
$login = false;


if (isset($_POST['submit'])) {
    $username = htmlspecialchars(mysqli_escape_string($db, $_POST['username']));
    $password = htmlspecialchars(mysqli_escape_string($db, $_POST['password']));

    //Gegevens uit de databse halen met de juiste ingevulde gebruikersnaam
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $login = true;
        } else {
            $error = "Onjuiste inloggegevens";
        }
    } else {
        $error = "Onjuiste inloggegevens";
    }
    if (!isset($error)) {
        $_SESSION['admin'] = $user['admin'];
        echo $_SESSION['admin'];
    }
}

if (empty($_POST['username'])) {
    $errorUsername = "Vul uw email in";
}

if (empty($_POST['password'])) {
    $errorPassword = "Vul uw wachtwoord in";
}

if (isset($_SESSION['admin'])) {
    header("Location: afsprakenAdminPageV2.php ");
    exit;
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
    input[type=text], input[type=password], input[type=email]{
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
        <h1>Log In</h1>
        <p>
        <div>
            <span class = "error"> <?php echo $error;?></span>
            <br>
            <br>
            <main class="content-wrapper">
                <article class="site-content">
                    <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post">
                        <div class="data-field">
                            <label for="username">Email: </label>
                            <input id="username" type="email" name="username" autocomplete="off" value="<?= isset($username) ? htmlentities($username) : ''?>"/>
                            <br><br>
                            <label for="password">Wachtwoord: </label>
                            <input id="password" type="password" name="password" autocomplete="off" value="<?= htmlentities($password)?> "/>
                            <br><br>
                            <div class="data-submit">
                                <input type="submit" name="submit" value="Inloggen"/>
                            </div>
                    </form>
                    </p>
                </article>
            </main>
        </div>
        <br>
     <!-- <p>
            <h1>Registreren</h1>
            <br>
            <br>
            Nog geen account?
            <br>
            <br>
            Klik op registreren om een account aan te maken om een reservering te plaatsen!
            <br>
            <br>
            <a href="registerpage.php">Registreren</a>
        </p> -->
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










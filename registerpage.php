<?php
/** @var $db */
require_once "DB.php";

//Als er op de register knop wordt gedrukt dan wordt het wachtwoord gehashed en opgeslagen samen met het emailadres.
if (isset($_POST['submit'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $password2 = password_hash($_POST['password2'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
//Als de ingevoerde wachtwoorden overeenkomen dan wordt het emailadres en het gehashte wachtwoord veilig in de database bewaard.
    if ($_POST['password'] == $_POST['password2']){
        $query = "INSERT INTO users (username, password)
                  VALUES ('$email', '$password')";
        $result = mysqli_query($db, $query) or die('Error: ' . $query);

        if ($result) {
            header('Location: homepage.php');
            exit;
        } else {
            $error['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }
    }else{
        $errors['herhalen'] = 'Wachtwoord herhalen ging fout';
    }
    //Save the record to the database

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./styleHomepage.css">
    <title>Patta's By Tom</title>
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

<?php if (isset($error)) { ?>
    <p><?= $error['db']; ?></p>
<?php } ?>

<main>
<section id="register">
    <h1>Registreren</h1>
<form method="post" action="<?= $_SERVER['REQUEST_URI']; ?>">
    <div>
        <label for="email">E-mail:</label>
        <input id="email" type="email" name="email"/>
    </div>
    <div>
        <label for="password">Wachtwoord:</label>
        <input id="password" type="password" name="password"/>
    </div>
    <div>
        <label for="password2">Wachtwoord herhalen:</label>
        <input id="password2" type="password" name="password2"/>
        <span class="errors"><?= isset($errors['herhalen']) ? $errors['herhalen'] : '' ?></span>
    </div>
    <div>
        <input type="submit" name="submit" value="Aanmelden"/>
    </div>
</form>
</section>
</main>
<footer>
    <div>Links</div>
    <br>
    <a href = "https://www.instagram.com/pattas_by_tom/" title="Klik om onze Instagram pagina te bekijken" target="_blank">Instagram</a>
    <br>
    <br>
    <a href = "loginpagereal.php">Log In</a>
</footer>
</body>
</html>
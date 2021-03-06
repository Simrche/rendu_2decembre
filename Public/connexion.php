<?php
include "coBdd.php";

use App\ConnController;

$Conn = new ConnController($bdd);
$isCo = $Conn->isConnected($bdd);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <title>Connexion</title>
</head>

<body>

    <header>
        <a href='index.php'>
            <h1>Exo_sondage</h1>
        </a>
    </header>

    <section id='connexion'>
        <div id='connexionContenu'>
            <h2>Connexion</h2>
            <form action='#' method='post'>
                <div>
                    <label for='Pseudo'>Pseudo :</label>
                    <input type='text' placeholder='Pseudo' name='pseudo'>
                </div>
                <div>
                    <label for='Mot de passe'>Mot de passe :</label>
                    <input type='password' placeholder='Mot de passe' name='mdp'>
                </div>
                <p>Vous n'avez pas de compte ? <a href='inscription.php'>Inscrivez-vous</a></p>
                <div>
                    <input type="submit" class='button' name='envoyer'>
                </div>
            </form>
        </div>
    </section>

    <footer>

    </footer>

</body>

</html>
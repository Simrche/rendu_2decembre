<?php
include "coBdd.php";

use App\InscriController;

$Sign = new InscriController($bdd);
$SignIn = $Sign->isSignIn($bdd);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <title>Inscription</title>
</head>

<body>

    <header>
        <a href="index.php">
            <h1>Exo_sondage</h1>
        </a>
    </header>


    <section id='inscription'>
        <div id='inscriptionContenu'>
            <h2>INSCRIPTION</h2>
            <form action='#' method='post'>
                <div>
                    <label for='Pseudo'>Pseudo :</label>
                    <input type='text' placeholder='Pseudo' name='pseudo' required>
                </div>
                <div>
                    <label for='MotDePasse'>Mot de passe :</label>
                    <input type='password' placeholder='Mot de passe' name='mdp' required>
                </div>
                <div>
                    <label for='Email'>Email :</label>
                    <input type='text' placeholder='Email' name='email' required>
                </div>
                <p>Vous avez déja un compte ? <a href='connexion.php'>Connectez-vous</a></p>
                <div><input type="submit" name='envoyer' class='button' value='INSCRIPTION'></div>
            </form>
        </div>
    </section>

    <footer>

    </footer>

</body>

</html>
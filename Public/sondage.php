<?php
include "coBdd.php";
$reponseEnTout = 0;

// Bouton Deconnexion ------------------------------------------------------------------------------------------

include "../App/deconnexion.php";

// Récupération du titre depuis la bdd --------------------------------------------------------------------
use App\SondageControler;
$sonda = new SondageControler($bdd);
$recupTitreQ = $sonda->titleQ($bdd);

$reponse = $sonda->repName($bdd);

// Récupération des messages du chat

$chatRep = $sonda->chatContro($bdd);

// Affichage des messages du chat ---------------------------------------------------------------------------

$chatAff = $sonda->chatView($bdd);

// Verifie que l'on a pas deja participer ------------------------------------------------------------------

$verif = $sonda->hasChosen($bdd);

// Envoie de participation -------------------------------------------------------------------------------
$participation = $sonda->sendQ($bdd);

// Récupération des votes -----------------------------------------------------------------------------------
$recupVote = $sonda->catchVotes($bdd,$reponseEnTout);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>

    <?php if (isset($_SESSION['pseudo'])) { ?>

        <header>
            <a href="index.php">
                <h1>Exo_sondage</h1>
            </a>
            <div id='headerContenu'>
                <p id='bonjourPseudo'>Bonjour, <?= $_SESSION['pseudo'] ?></p>
                <a href="profil.php" class='button'>MON PROFIL</a>
                <form action="#" method='post'>
                    <input type="submit" name='deco' value='Déconnexion' Class='button'>
                </form>
            </div>
        </header>

        <section id='contenuSondage'>
            <div id='leftSondage'>
                <h2><?= $recupTitreQ['sond_question'] ?></h2>
                <form action="#" method='post'>
                    <?php
                    foreach ($reponse as $reponses) {
                        if ($verif == false && $recupTitreQ['sond_enCours']) { ?>
                            <input type="submit" value='<?= $reponses['rep_name'] ?>' class='reponsesSondage' name='reponses'>
                        <?php } else { ?>
                            <div class='reponsesSondageFini'>
                                <p><?= $reponses['rep_name'] ?></p>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </form>
                <h3>Partager le lien avec vos amis !</h3>
                <input type="text" value="sondage.php?lien=<?= $_GET['lien'] ?>" class='reponsesSondage'>
            </div>
            <div id='rightSondage'>
                <h2>CHAT</h2>
                <div>
                    <div id="messageChat">
                        <?php foreach ($chatAff as $chatAffs) { ?>
                            <p><span><?= $chatAffs['msg_pseudo'] ?></span> : <?= $chatAffs['msg_message'] ?></p>
                        <?php } ?>
                    </div>
                    <div id="envoyerMessage">
                        <form action="#" method='post'>
                            <input type="text" placeholder="Message ..." name='message' id='contentMsg'>
                            <input type="submit" value='✔' name='envoyerMsg' id='msgChat'>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <footer>

        </footer>

    <?php } else { ?>
        <header>
            <a href="index.php">
                <h1>Exo_sondage</h1>
            </a>
        </header>

        <section id='nonCo'>
            <h2>EXO_SONDAGE</h2>
            <p>
                Exo_sondage est une application qui vous permet
                de realiser des sondages sur une période donnée.
                Vous pouvez ajouter des amis et répondre aux même
                sondages que eux. <br><br>
                Connectez vous pour pouvoir
                avoir accès aux sondages.
            </p>
            <div>
                <a href="connexion.php" class='button'>CONNEXION</a>
                <a href="inscription.php" class='button'>INSCRIPTION</a>
            </div>
        </section>
    <?php } ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='../js/main.js'></script>
</body>

</html>
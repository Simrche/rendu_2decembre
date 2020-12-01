<?php
include "coBdd.php";
$verif = false;
$reponseEnTout = 0;
$reponse1;
$reponse2;
$reponse3;
$reponse4;

// Bouton Deconnexion ------------------------------------------------------------------------------------------

if (isset($_POST['deco'])) {
    session_destroy();
    header('location:index.php');
}

// Récupération du titre depuis la bdd --------------------------------------------------------------------

$TitreQ =  $bdd->prepare('SELECT sond_question, sond_enCours FROM sondage WHERE sond_lien=:lienTitre');
$TitreQ->execute(array('lienTitre' => $_GET['lien']));
$recupTitreQ = $TitreQ->fetch();

// Récupération des reponses depuis la bdd --------------------------------------------------------------------

$reponse =  $bdd->prepare('SELECT rep_name FROM reponses WHERE rep_sondage_id=:lien');
$reponse->execute(array('lien' => $_GET['lien']));

// Récupération des messages du chat

$chatRep = $bdd->prepare('INSERT INTO message_chat(msg_chat_id, msg_message, msg_pseudo) VALUES(?, ?, ?);');
if (isset($_POST['envoyerMsg'])) {
    $chatRep->execute(array($_GET['lien'], $_POST['message'], $_SESSION['pseudo']));
    header('location:sondage.php?lien=' . $_GET['lien'] . '');
}

// Affichage des messages du chat ---------------------------------------------------------------------------

$chatAff = $bdd->prepare('SELECT msg_message, msg_pseudo FROM message_chat WHERE msg_chat_id = :lienChat ORDER BY msg_id DESC LIMIT 0, 15;');
$chatAff->execute(array('lienChat' => $_GET['lien']));

// Verifie que l'on a pas deja participer ------------------------------------------------------------------

$verifPart = $bdd->prepare('SELECT part_name, part_sondage_id FROM participant WHERE part_name = :pseudo AND part_sondage_id = :liensondage');
if (isset($_SESSION['pseudo'])) {
    $verifPart->execute(array('pseudo' => $_SESSION['pseudo'], 'liensondage' => $_GET['lien']));
    $verifParts = $verifPart->fetch();
    if (isset($verifParts['part_name'])) {
        $verif = true;
    }
}

// Envoie de participation -------------------------------------------------------------------------------

$participation = $bdd->prepare('INSERT INTO participant(part_name, part_sondage_id, part_reponse) VALUES (?,?,?);');
if (isset($_POST['reponses'])) {
    $participation->execute(array($_SESSION['pseudo'], $_GET['lien'], $_POST['reponses']));
    header('location:sondage.php?lien=' . $_GET['lien'] . '');
}

// Récupération des votes -----------------------------------------------------------------------------------

$recupVote = $bdd->prepare('SELECT part_name, part_reponse FROM participant WHERE part_sondage_id = :sondageid');
$recupVote->execute(array('sondageid' => $_GET['lien']));

foreach ($recupVote as $recupVotes) {
    $reponseEnTout = $reponseEnTout + 1;
}
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
                            <input type="text" placeholder="Message ..." name='message'>
                            <input type="submit" value='->' name='envoyerMsg'>
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

</body>

</html>
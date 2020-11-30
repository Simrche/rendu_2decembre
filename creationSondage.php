<?php 
    session_start();
    include "codes.php";
    $bdd = new PDO("mysql:host=localhost;dbname=exo_sondage;charset=utf8", $indivRoots, $indivMdp);

    // Ajout de tournoi dans la bdd --------------------------------------------------------------

    $ajoutTournoi = $bdd->prepare("INSERT INTO sondage(sond_question, sond_lien, sond_time, sond_debut, sond_createur) VALUES(?, ?, ?, ?, ?);");
    $ajoutReponse = $bdd->prepare("INSERT INTO reponses(rep_name, rep_sondage_id) VALUES(?, ?);");
    $ajoutChat = $bdd->prepare("INSERT INTO chat(chat_sondage_id) VALUES(?);");

    if(isset($_POST['envoyer'])) {
        $lien = rand(0,1000000000);
        $ajoutTournoi->execute(array($_POST['titre'], $lien, intval($_POST['time']), time(), $_SESSION['pseudo']));
        $ajoutReponse->execute(array($_POST['rep1'], $lien));
        $ajoutReponse->execute(array($_POST['rep2'], $lien));
        if($_POST['rep3'] != "") {
            $ajoutReponse->execute(array($_POST['rep3'], $lien));
        }
        if($_POST['rep4'] != "") {
            $ajoutReponse->execute(array($_POST['rep4'], $lien));
        }
        header('Location:index.php');

        // Création du chat pour le sondage -------------------------------------------------------------
        
        $ajoutChat->execute(array($lien));
        
    }

    // Bouton deconnexion -------------------------------------------------------------------------

    if(isset($_POST['deco'])) {
        session_destroy();
        header('location:index.php');
    }

    




?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <title>Document</title>
    </head>

    <body>

    <?php if(isset($_SESSION['pseudo'])) { ?>
            
        <header>
            <a href="index.php"><h1>Exo_sondage</h1></a>
            <div id='headerContenu'>
                <p id='bonjourPseudo'>Bonjour, <?= $_SESSION['pseudo'] ?></p>
                <a href="profil.php" class='button'>MON PROFIL</a>
                <form action="#" method='post'>
                    <input type="submit" name='deco' value='Déconnexion' Class='button'>
                </form>
            </div>
        </header>

        <section>
            <div id='creationContenu'>
                <h2>CRÉE SON SONDAGE</h2>
                <form action="#" method='post'>
                    <div>
                        <label for="Titre">TITRE :</label>
                        <input type="text" name="titre" id="" placeholder='Entrez un titre'>
                    </div>
                    <div id='reponses'>
                        <label for="Reponses">REPONSES :</label>
                        <input type="text" name="rep1" id="" placeholder='Reponse 1 ...'>
                        <input type="text" name="rep2" id="" placeholder='Reponse 2 ...'>
                        <input type="text" name="rep3" id="" placeholder='Reponse 3 ... ( Facultatif )'>
                        <input type="text" name="rep4" id="" placeholder='Reponse 4 ... ( Facultatif )'>
                    </div>
                    <div>
                        <label for="durée">DURÉE :</label>
                        <select name="time" id="time-select">
                            <option value="">-- Choisir une durée --</option>
                            <option value="300">5 minutes</option>
                            <option value="1800">30 minutes</option>
                            <option value="3600">1 heure</option>
                            <option value="10800">3 heure</option>
                            <option value="43200">12 heure</option>
                            <option value="86400">24 heures</option>
                        </select>
                    </div>
                    <div>
                        <label for="envoyer">ENVOYER :</label>
                        <input type="text" name="emailAmis" id="amis" placeholder='Envoyer à des amis'>
                    </div>
                    <div>
                        <input type="submit" name='envoyer' value='CRÉER' class='button'>
                    </div>
                </form>
            </div>
        </section>

        <footer>

        </footer>

    <?php } else {?>
        <header>
            <a href="index.php"><h1>Exo_sondage</h1></a>
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
    <?php }?>


        
    </body>
</html>
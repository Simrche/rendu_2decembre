<?php 
    session_start();
    $bdd = new PDO("mysql:host=localhost;dbname=exo_sondage;charset=utf8", "root", "");

    // Bouton Deconnexion ------------------------------------------------------------------------------------------

    if(isset($_POST['deco'])) {
        session_destroy();
        header('location:index.php');
    }

    // Affichage de mes sondages en cours --------------------------------------------------------------------------------------

    $sondageEnCours =  $bdd->prepare('SELECT sond_question, sond_lien FROM sondage WHERE sond_createur=:pseudo AND sond_enCours = 1');
    if(isset($_SESSION['pseudo'])) {
        $sondageEnCours->execute(array('pseudo' => $_SESSION['pseudo']));
    }
    

    // Affichage de mes sondages finis --------------------------------------------------------------------------------------

    $sondageFini = $bdd->prepare('SELECT sond_question, sond_lien FROM sondage WHERE sond_createur=:pseudo AND sond_enCours = 0');
    if(isset($_SESSION['pseudo'])) {
        $sondageFini->execute(array('pseudo' => $_SESSION['pseudo']));
    }

    // Affichage de mes amis -------------------------------------------------------------------------------------------------

    $amisEnLigne = $bdd->prepare('SELECT amis_users_id2 FROM listeamis WHERE amis_users_id = :pseudo');
    if(isset($_SESSION['pseudo'])) {
        $amisEnLigne->execute(array('pseudo' => $_SESSION['pseudo']));
    }

    // Afficher tous les sondages -------------------------------------------------------------------------------------------------

    $recupSondage = $bdd->query('SELECT sond_id, sond_question, sond_lien, sond_createur, sond_debut, sond_time FROM sondage');

    // Verification que les sondages ne sont pas fini -----------------------------------------------------------------------------
    
    $recupVerifFinSondage = $bdd->query('SELECT sond_id, sond_question, sond_lien, sond_createur, sond_debut, sond_time FROM sondage');
    $finSondage = $bdd->prepare('UPDATE sondage SET sond_enCours = 0 WHERE id = :sondage');
    foreach($recupVerifFinSondage as $finito) {
        $temps = $finito['sond_debut'] + $finito['sond_time'];
        if(time() >= $temps ) {
            $finSondage = $bdd->prepare('UPDATE sondage SET sond_enCours = 0 WHERE sond_id = :sondage');
            $finSondage->execute(array('sondage' => $finito['sond_id']));
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <title>Exo_sondage</title>
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

            <section id='indexContenu'>
                <div id='left'>
                    <a href="creationSondage.php" class='button'>Crée un sondage +</a>
                    <h2>Les sondages de mes amis</h2>
                    <ul>
                        <?php foreach($recupSondage as $recupSondages) {?>
                            <li><div class="ecart"><a href='sondage.php?lien=<?=$recupSondages['sond_lien']?>'><?=$recupSondages['sond_question']?></a></div><a href='sondage.php?lien=<?=$recupSondages['sond_lien']?>'>Par <?= $recupSondages['sond_createur'] ?></a></li>
                        <?php } ?>
                    </ul>
                    <div id='bas'>
                        <div id='basLeft'>
                            <h2>Mes sondages</h2>
                            <ul>
                                <?php 
                                    foreach ($sondageEnCours as $sondages) { ?>
                                        <li><a href="sondage.php?lien=<?=$sondages['sond_lien']?>"><?= $sondages['sond_question']?></a></li>
                                    <?php }
                                ?>
                            </ul>
                        </div>
                        <div id='basRight'>
                            <h2>Mes sondages finis</h2>
                            <ul>
                            <?php 
                                    foreach ($sondageFini as $sondages) { ?>
                                        <li><a href="sondage.php?lien=<?=$sondages['sond_lien']?>"><?= $sondages['sond_question']?></a></li>
                                    <?php }
                                ?>
                            </ul>
                        </div>
                    </div>

                </div>
                <div id='right'>
                    <h2>MES AMIS</h2>
                    <hr>
                    <div id='amisPlus'>
                        <a href="amis.php" id='ajoutAmis'>Ajouter +</a>
                    </div>
                    <?php foreach($amisEnLigne as $amisEnLignes) {?>
                        <div>
                            <img src="img/csgo3.png" alt="csgo">
                            <p class='enligne'><?= $amisEnLignes['amis_users_id2'] ?></p>
                        </div>
                    <?php } ?>
                </div>
            </section>

            <footer>

            </footer>

        <?php } else { ?>

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

        <?php } ?>


        
    </body>
</html>
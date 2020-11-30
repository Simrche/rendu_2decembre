<?php 
    session_start();
    include "codes.php";
    $bdd = new PDO("mysql:host=localhost;dbname=exo_sondage;charset=utf8", $indivRoots, $indivMdp);
    
    // Bouton Deconnexion ------------------------------------------------------------------------------------------
    
    if(isset($_POST['deco'])) {
         session_destroy();
          header('location:index.php');
     }

    // Recupération des infos de l'utilisateur ---------------------------------------------------------------------

    $recupInfo =  $bdd->prepare('SELECT users_email, users_mdp FROM users WHERE users_pseudo=:pseudo');
    $recupInfo->execute(array('pseudo' => $_SESSION['pseudo']));
    $recupInfos = $recupInfo->fetch();
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

            <section id="contenuProfil">
                <div id='headerProfil'>
                    <img src="img/csgo3.png" alt="Photo de profil">
                    <h2><?= $_SESSION['pseudo'] ?></h2>
                </div>
                <hr>
                <div>
                    <p>
                        Pseudo : <?= $_SESSION['pseudo'] ?>
                    </p>
                    <p>
                        Email : <?= $recupInfos['users_email'] ?>
                    </p>
                    <p>
                        Mot de passe : ********
                    </p>
                    <p>
                        Pays : France
                    </p>
                </div>
                <a href="#" class='button'>MODIFIER</a>
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
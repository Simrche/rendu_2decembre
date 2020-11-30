<?php 
    session_start();
    include "codes.php";
    $bdd = new PDO("mysql:host=localhost;dbname=exo_sondage;charset=utf8", $indivRoots, $indivMdp);
    
    // Bouton Deconnexion ------------------------------------------------------------------------------------------
    
    if(isset($_POST['deco'])) {
         session_destroy();
          header('location:index.php');
     }

     // Récupération de tout les utilisateurs --------------------------------------------------------------------

     $allUser = $bdd->prepare('SELECT users_pseudo, users_id FROM users WHERE users_pseudo != :pseudo ORDER BY users_pseudo ASC');
     $allUser->execute(array('pseudo' => $_SESSION['pseudo']));
     if(isset($_GET['search'])) {
        $allUser = $bdd->prepare("SELECT users_pseudo, users_id FROM users WHERE users_pseudo = :pseudo ORDER BY users_pseudo ASC");
        $allUser->execute(array('pseudo' => $_GET['valueSearch']));
     }


     // Récupération de mes amis ------------------------------------------------------------------------------------

     $allFriend = $bdd->prepare('SELECT amis_users_id2, amis_id FROM listeamis WHERE amis_users_id = :pseudo ORDER BY amis_users_id2 ASC');
     $allFriend->execute(array('pseudo' => $_SESSION['pseudo']));
     if(isset($_GET['searchFriend'])) {
        $allFriend = $bdd->prepare('SELECT amis_users_id2, amis_id FROM listeamis WHERE amis_users_id = :pseudo AND amis_users_id2 = :search ORDER BY amis_users_id2 ASC');
        $allFriend->execute(array('pseudo' => $_SESSION['pseudo'], 'search' => $_GET['searchFriendValue']));
     }
     

     // Ajout d'amis -------------------------------------------------------------------------------------------------

     $ajoutFriend = $bdd->prepare('INSERT INTO listeamis(amis_users_id, amis_users_id2, amis_anti_double) VALUES(?, ?, ?);');
     if(isset($_POST['ajout'])) {
         $ajoutFriend->execute(array($_SESSION['pseudo'], $_POST['nameAdd'], $_SESSION['pseudo'].$_POST['nameAdd']));
         header("location:amis.php");
     }

     // suppression d'amis -------------------------------------------------------------------------------------------

     $suppFriend = $bdd->prepare('DELETE FROM listeamis WHERE amis_id = :id');
     if(isset($_POST['delete'])) {
         $suppFriend->execute(array('id' => $_POST['idSupp']));
         header("location:amis.php");
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

            <section id='amis'>
                <div id='amisLeft'>
                    <h2>MES AMIS</h2>
                    <form action="#" method='get'>
                        <input type="search" placeholder='Recherche ...' class='rechercheAmis' name='searchFriendValue'>
                        <input type="submit" name='searchFriend' class='searchButton'>
                    </form>
                    <?php foreach($allFriend as $allFriends) { ?>
                        <div class='listeAmis'>
                            <div>
                                <img src="img/csgo3.png" alt="">
                                <p><?= $allFriends['amis_users_id2'] ?></p>
                            </div>
                            <form action="#" method='post'>
                                <input type="text" name="idSupp" class='hidden' value="<?= $allFriends['amis_id'] ?>">
                                <input type="submit" class='button' value='SUPPRIMER' name='delete'>
                            </form>
                        </div>
                    <?php } ?>
                </div>
                <div id='amisRight'>
                <h2>AJOUTER UN AMIS</h2>
                    <form action="#" method='get'>
                        <input type="search" placeholder='Recherche ...' class='rechercheAmis' name='valueSearch'>
                        <input type="submit" name='search' class='searchButton'>
                    </form>
                    <?php foreach($allUser as $allUsers) { ?>
                        <div class='listeAmis'>
                            <div>
                                <img src="img/csgo3.png" alt="">
                                <p><?= $allUsers['users_pseudo'] ?></p>
                            </div>
                            <form action="#" method='post'>
                                <input type="text" name="nameAdd" class="hidden" value="<?= $allUsers['users_pseudo'] ?>">
                                <input type="submit" class='button' value='AJOUTER' name='ajout'>
                            </form>
                        </div>
                    <?php } ?>
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
<?php
include "coBdd.php";
// Bouton Deconnexion ------------------------------------------------------------------------------------------
include "../App/deconnexion.php";

// Récupération de tout les utilisateurs --------------------------------------------------------------------
use App\FriendsControler;
$friend = new FriendsControler($bdd);
$allUser = $friend->getUsers($bdd);

// Récupération de mes amis ------------------------------------------------------------------------------------
$allFriend = $friend->myFriends($bdd);

// Ajout d'amis -------------------------------------------------------------------------------------------------
$ajoutFriend = $friend->newFriend($bdd);

// suppression d'amis -------------------------------------------------------------------------------------------
$suppFriend = $friend->lessFriend($bdd);


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

        <section id='amis'>
            <div id='amisLeft'>
                <h2>MES AMIS</h2>
                <form action="#" method='get'>
                    <input type="search" placeholder='Recherche ...' class='rechercheAmis' name='searchFriendValue'>
                    <input type="submit" name='searchFriend' class='searchButton'>
                </form>
                <?php foreach ($allFriend as $allFriends) { ?>
                    <div class='listeAmis'>
                        <div>
                            <img src="../img/csgo3.png" alt="">
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
                <?php foreach ($allUser as $allUsers) { ?>
                    <div class='listeAmis'>
                        <div>
                            <img src="../img/csgo3.png" alt="">
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
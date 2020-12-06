<?php

namespace App;

class ConnController
{

    public function __construct()
    {
    }


    public function isConnected($bdd)
    {
        $connexion = $bdd->prepare('SELECT users_mdp FROM users WHERE users_pseudo=:pseudo');

        if (isset($_POST['envoyer'])) {
            $connexion->execute(array('pseudo' => $_POST['pseudo']));
            $donnees = $connexion->fetch();
            if (password_verify($_POST['mdp'], $donnees['users_mdp'])) {
                $_SESSION['pseudo'] = $_POST['pseudo'];
                header('Location: index.php');
            }
        }
    }
}

<?php

namespace App;

class InscriController
{

    public function __construct()
    {
    }


    public function isSignIn($bdd)
    {
        $ajoutUsers = $bdd->prepare("INSERT INTO users(users_pseudo, users_mdp, users_email) VALUES(?, ?, ?);");

        if (isset($_POST['envoyer'])) {
            $ajoutUsers->execute(array($_POST['pseudo'], password_hash($_POST['mdp'], PASSWORD_DEFAULT), $_POST['email']));
            header("location:connexion.php");
        }
    }
}

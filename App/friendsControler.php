<?php

namespace App;

use CoBdd;



class FriendsControler extends CoBdd
{
    private $bd;
    
    public function __construct()
    {

        $bd = parent::__construct();
        return $bd;
        
    }


    public function getUsers()
    {
        $bdd = $this->bd;
        $allUser = $bdd->prepare('SELECT users_pseudo, users_id FROM users WHERE users_pseudo != :pseudo ORDER BY users_pseudo ASC');
        $allUser->execute(array('pseudo' => $_SESSION['pseudo']));
        if (isset($_GET['search'])) {
            $allUser = $bdd->prepare("SELECT users_pseudo, users_id FROM users WHERE users_pseudo = :pseudo ORDER BY users_pseudo ASC");
            $allUser->execute(array('pseudo' => $_GET['valueSearch']));
        }
        return $allUser;
    }

    public function myFriends()
    {
        $bdd = $this->bd;
        $allFriend = $bdd->prepare('SELECT amis_users_id2, amis_id FROM listeamis WHERE amis_users_id = :pseudo ORDER BY amis_users_id2 ASC');
        $allFriend->execute(array('pseudo' => $_SESSION['pseudo']));
        if (isset($_GET['searchFriend'])) {
            $allFriend = $bdd->prepare('SELECT amis_users_id2, amis_id FROM listeamis WHERE amis_users_id = :pseudo AND amis_users_id2 = :search ORDER BY amis_users_id2 ASC');
            $allFriend->execute(array('pseudo' => $_SESSION['pseudo'], 'search' => $_GET['searchFriendValue']));
        }
        return $allFriend;
    }

    public function newFriend()
    {
        $bdd = $this->bd;
        $ajoutFriend = $bdd->prepare('INSERT INTO listeamis(amis_users_id, amis_users_id2, amis_anti_double) VALUES(?, ?, ?);');
        if (isset($_POST['ajout'])) {
            $ajoutFriend->execute(array($_SESSION['pseudo'], $_POST['nameAdd'], $_SESSION['pseudo'] . $_POST['nameAdd']));
            header("location:amis.php");
        }
    }

    public function lessFriend()
    {
        $bdd = $this->bd;
        $suppFriend = $bdd->prepare('DELETE FROM listeamis WHERE amis_id = :id');
        if (isset($_POST['delete'])) {
            $suppFriend->execute(array('id' => $_POST['idSupp']));
            header("location:amis.php");
        }
    }
}

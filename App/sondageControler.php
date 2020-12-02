<?php

namespace App;

class SondageControler
{

    public function __construct()
    {
    }


    public function titleQ($bdd)
    {
        $TitreQ =  $bdd->prepare('SELECT sond_question, sond_enCours FROM sondage WHERE sond_lien=:lienTitre');
        $TitreQ->execute(array('lienTitre' => $_GET['lien']));
        $recupTitreQ = $TitreQ->fetch();
        return $recupTitreQ;
    }

    public function repName($bdd)
    {
        $reponse =  $bdd->prepare('SELECT rep_name FROM reponses WHERE rep_sondage_id=:lien');
        $reponse->execute(array('lien' => $_GET['lien']));
        return $reponse;
    }

    public function answer($bdd)
    {
        $TitreQ =  $bdd->prepare('SELECT sond_question, sond_enCours FROM sondage WHERE sond_lien=:lienTitre');
        $TitreQ->execute(array('lienTitre' => $_GET['lien']));
        $recupTitreQ = $TitreQ->fetch();
        return $TitreQ;
    }

    public function chatContro($bdd)
    {
        $chatRep = $bdd->prepare('INSERT INTO message_chat(msg_chat_id, msg_message, msg_pseudo) VALUES(?, ?, ?);');
        if (isset($_POST['envoyerMsg'])) {
            $chatRep->execute(array($_GET['lien'], $_POST['message'], $_SESSION['pseudo']));
            header('location:sondage.php?lien=' . $_GET['lien'] . '');
        }
        return $chatRep;
    }

    public function chatView($bdd)
    {
        $chatAff = $bdd->prepare('SELECT msg_message, msg_pseudo FROM message_chat WHERE msg_chat_id = :lienChat ORDER BY msg_id DESC LIMIT 0, 15;');
        $chatAff->execute(array('lienChat' => $_GET['lien']));
        return $chatAff;
    }

    public function hasChosen($bdd)
    {
        $verif = false;
        $verifPart = $bdd->prepare('SELECT part_name, part_sondage_id FROM participant WHERE part_name = :pseudo AND part_sondage_id = :liensondage');
        if (isset($_SESSION['pseudo'])) {
            $verifPart->execute(array('pseudo' => $_SESSION['pseudo'], 'liensondage' => $_GET['lien']));
            $verifParts = $verifPart->fetch();
            if (isset($verifParts['part_name'])) {
                $verif = true;
            }
        }
        return $verif;
    }

    public function sendQ($bdd)
    {
        $participation = $bdd->prepare('INSERT INTO participant(part_name, part_sondage_id, part_reponse) VALUES (?,?,?);');
        if (isset($_POST['reponses'])) {
            $participation->execute(array($_SESSION['pseudo'], $_GET['lien'], $_POST['reponses']));
            header('location:sondage.php?lien=' . $_GET['lien'] . '');
        }
        return $participation;
    }

    public function catchVotes($bdd, $reponseEnTout)
    {
        $recupVote = $bdd->prepare('SELECT part_name, part_reponse FROM participant WHERE part_sondage_id = :sondageid');
        $recupVote->execute(array('sondageid' => $_GET['lien']));

        foreach ($recupVote as $recupVotes) {
            $reponseEnTout = $reponseEnTout + 1;
        }
        return $reponseEnTout;
    }
}

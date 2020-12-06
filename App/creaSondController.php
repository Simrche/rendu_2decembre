<?php

namespace App;

class CreaSondController
{

    public function __construct()
    {
    }


    public function creaNewSond($bdd)
    {
        $ajoutSond = $bdd->prepare("INSERT INTO sondage(sond_question, sond_lien, sond_time, sond_debut, sond_createur) VALUES(?, ?, ?, ?, ?);");
        $ajoutReponse = $bdd->prepare("INSERT INTO reponses(rep_name, rep_sondage_id) VALUES(?, ?);");
        $ajoutChat = $bdd->prepare("INSERT INTO chat(chat_sondage_id) VALUES(?);");

        if (isset($_POST['envoyer'])) {
            $lien = rand(0, 1000000000);
            $ajoutSond->execute(array($_POST['titre'], $lien, intval($_POST['time']), time(), $_SESSION['pseudo']));
            $ajoutReponse->execute(array($_POST['rep1'], $lien));
            $ajoutReponse->execute(array($_POST['rep2'], $lien));
            if ($_POST['rep3'] != "") {
                $ajoutReponse->execute(array($_POST['rep3'], $lien));
            }
            if ($_POST['rep4'] != "") {
                $ajoutReponse->execute(array($_POST['rep4'], $lien));
            }
            header('Location:index.php');

            // Création du chat pour le sondage -------------------------------------------------------------

            $ajoutChat->execute(array($lien));
        }
    }
}

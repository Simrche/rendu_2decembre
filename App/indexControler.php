<?php

namespace App;

class IndexControler
{

    public function __construct($bdd)
    {
    }


    public function sondNow($bdd)
    {
        $sondageEnCours =  $bdd->prepare('SELECT sond_question, sond_lien FROM sondage WHERE sond_createur=:pseudo AND sond_enCours = 1');
        if (isset($_SESSION['pseudo'])) {
            $sondageEnCours->execute(array('pseudo' => $_SESSION['pseudo']));
        }
        return $sondageEnCours;
    }
}

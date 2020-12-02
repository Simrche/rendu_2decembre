<?php

namespace App;

use CoBdd;


class IndexControler extends CoBdd
{

    private $bd;
    
    public function __construct()
    {

        $bd = parent::__construct();
        return $bd;
    }


    public function sondNow()
    {
        $bdd = $this->bd;
        $sondageEnCours =  $bdd->prepare('SELECT sond_question, sond_lien FROM sondage WHERE sond_createur=:pseudo AND sond_enCours = 1');
        if (isset($_SESSION['pseudo'])) {
            $sondageEnCours->execute(array('pseudo' => $_SESSION['pseudo']));
        }
        return $sondageEnCours;
    }
}

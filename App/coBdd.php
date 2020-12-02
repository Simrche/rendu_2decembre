<?php

session_start();
// include "codes.php";
use App\Codes;

require "../Autoloader.php";
Autoloader::register();
class CoBdd{

    var $code;
    var $indivRoots;
    var $indivMdp;
    var $bdd;

    function __construct()
    {
        $code = new Codes();
        $indivRoots = $code->theRoot();
        $indivMdp = $code->theMdp();
        $bdd = new PDO("mysql:host=localhost;dbname=exo_sondage;charset=utf8", $indivRoots, $indivMdp);
        return $bdd;
    }
        
}

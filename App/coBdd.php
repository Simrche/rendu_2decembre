<?php
session_start();
// include "codes.php";
use App\Codes;

require "../Autoloader.php";
// Autoloader::register();

namespace App;

class CoBdd
{

    var $code;
    var $indivRoots;
    var $indivMdp;
    var $bdd;

    function __construct()
    {
        require "../Autoloader.php";
        Autoloader::register();
        $code = new Codes();
        $indivRoots = $code->theRoot();
        $indivMdp = $code->theMdp();
        $bdd = new PDO("mysql:host=localhost;dbname=exo_sondage;charset=utf8", $indivRoots, $indivMdp);
        return $bdd;
    }
}

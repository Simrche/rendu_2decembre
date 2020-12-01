<?php

session_start();
// include "codes.php";
use App\Codes;

require "../Autoloader.php";
Autoloader::register();
$code = new Codes();
$indivRoots = $code->theRoot();
$indivMdp = $code->theMdp();

$bdd = new PDO("mysql:host=localhost;dbname=exo_sondage;charset=utf8", $indivRoots, $indivMdp);

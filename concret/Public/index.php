<?php

define("ROOT", dirname(__DIR__));
$path = explode("index.php", $_SERVER["SCRIPT_NAME"]);
$path = "http://".$_SERVER["HTTP_HOST"].$path[0];
define("SERVER", $path);

require ROOT."/Autoloader.php";
Autoloader::register();

require ROOT."/router.php";
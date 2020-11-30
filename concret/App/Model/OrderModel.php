<?php
namespace App\Model;

use Core\Database;

class orderModel extends Database{
// ça récupère les informations dans la BDD, et ça les stocke

public function saveOrder($data){
    $statement = "INSERT INTO orders (prop1, prop2,...) VALUES (:prop1, :prop2, ...)";
    $this->prepare($statement, $data);
}
}
<?php

use App\Controller\OrderController;

if(array_key_exists("page", $_GET)){
    switch ($_GET["page"]) {
        case 'orders':
            $controller = new OrderController();
            $controller->renderIndex();
            break;
        case 'order':
            $controller = new OrderController();
            $controller->renderOne();

        case 'saveOrder':
            $controller = new OrderController();
            $controller->saveOrders($_POST);
        default:
            # code...
            break;
    }
} else{
    $controller = new OrderController();
    $controller->renderIndex();
}
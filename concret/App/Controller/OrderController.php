<?php
namespace App\Controller;

use App\Model\OrderModel;
use Core\Controller\DefaultController;

class OrderController extends DefaultController{

    public function __construct()
    {
        $this->model = new OrderModel();
    }

    /**
     * Modification apportée: Pour utiliser la method render, je lui passe le nom de la vue
     * et les paramètres que je veux envoyer à la vue. Je passe ces paramètres sous forme de tableau
     * et je leur donne une clé. Cette clé deviendra le nom de la variable dans la vue(ici on récupèrera $orders)
     * Maintenant regarde DefaultController.php!
     *
     * @return void
     */
    public function renderIndex()
    {
        $orders = $this->model->query("SELECT * FROM orders");
        $this->render("orderIndexView", [
            'orders' => $orders
        ]);
    }

    public function renderOne()
    {
        $order = $this->model->query("SELECT * FROM orders WHERE orderNumber = $this", true);
        require ROOT."/App/View/orderOneView.php";
    }

    public function saveOrders($data)
    {
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars($value);
            password_hash($data["password"], PASSWORD_DEFAULT);
        }
        $this->model->saveOrder($data);
    }
}
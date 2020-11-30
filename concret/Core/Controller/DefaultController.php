<?php
namespace Core\Controller;

class DefaultController{

    /**
     * Cette method render est modifiée. Elle prend 2 paramètres.
     * ob_start(), ob_get_clean permettent de "sauvegarder les informations qu'il y a entre les deux fonctions
     * dans une variable (ici content)"
     * et de les réafficher tel quel ailleurs (Dans la view base.php. Va voir cette view!).
     * extract($param) récupère toutes les informations de param et créé les variables à partir des clés indiquées
     * en leur donnant en valeur les valeurs contenus dans le tableau.
     *
     * @param string $filename le nom de la vue
     * @param array $param les informations que l'on souhaite passer à la vue comme les commandes
     * @return void
     */
    public function render($filename, $param = array()){
        ob_start();
        extract($param);
        require ROOT."/App/View/$filename.php";
        $content = ob_get_clean();
        require ROOT."/App/View/base.php";
    }
}
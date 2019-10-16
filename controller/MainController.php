<?php

namespace controller;

class MainController {

    public function __construct() {
        require_once('view/LayoutView.php');
        require_once('view/LoginView.php');
        require_once('view/ScribbleView.php');
        // require_once('ScribbleController.php');

        require_once('model/ScribbleItem.php');
        require_once('model/ScribbleCollection.php');

        $scribbleItem = new \model\ScribbleItem("hej", "jag tycker om solen", "Lisa37");
        $this->collection = new \model\ScribbleCollection();
        $this->collection->addItem($scribbleItem);

        $scribbleItem2 = new \model\ScribbleItem("Tjoho", "jag tycker om solen", "Pricken");
        $this->collection->addItem($scribbleItem2);
        

    
        $lv = new \view\LayoutView();
        $v = new \view\LoginView();
        $sv = new \view\ScribbleView();

        // $collection = new ScribbleController();

        $lv->render($v, $sv,  $this->collection->getCollection());
    }
}


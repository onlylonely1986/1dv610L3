<?php

namespace controller;

require_once('view/LayoutView.php');
require_once('view/LoginView.php');
require_once('view/ScribbleView.php');
// require_once('.env');

// require_once('ScribbleController.php');
require_once('model/ScribbleSaver.php');
require_once('model/ScribbleItem.php');
require_once('model/ScribbleCollection.php');
class MainController {

    public function __construct() {

        
        // connect servern ..............................
        $saver = new \model\ScribbleSaver();
        $data = $saver->getSavedScribbles();        
        

        // new item created manually
        // $scribbleItem = new \model\ScribbleItem("Tjoho", "Hatar verkligen att slänga sopor, det luktar pyton!", "Pricken");
        $this->collection = new \model\ScribbleCollection();
        // $this->collection->addItem($scribbleItem);

        // try to push in data
        // funkar
        // $saver->saveScribbles($scribbleItem);
        // ...............................................................

        $scribbleItem2 = new \model\ScribbleItem("Tjoho", "Hatar verkligen att slänga sopor, det luktar pyton!", "Pricken");
        $this->collection->addItem($scribbleItem2);

        $scribbleItem2 = new \model\ScribbleItem("Coola bananer", "Rackarns bananer!!!", "Tomu");
        $this->collection->addItem($scribbleItem2);       
    
        $lv = new \view\LayoutView();
        $v = new \view\LoginView();
        $sv = new \view\ScribbleView($data);

        $lv->render($v, $sv,  $this->collection->getCollection());
    }
}


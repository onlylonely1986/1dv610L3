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
        $data;
        // if(count($saver->getSavedScribbles(), COUNT_NORMAL) > 0){
            $data = $saver->getSavedScribbles(); 
        // } else {
        //    $data = array();
        // }
             
        

        // new item created manually
        $scribbleItem = new \model\ScribbleItem("Tjoho", "Hatar verkligen att slänga sopor, det luktar pyton!", "Pricken");
        $this->collection = new \model\ScribbleCollection();
        $this->collection->addItem($scribbleItem);

        $scribbleItem2 = new \model\ScribbleItem("Hej alla mina vänner!", "Rackarns bananer alltså", "Tomu");
        $this->collection->addItem($scribbleItem2);

        // $scribbleItem3 = new \model\ScribbleItem("Coola bananer", "Rackarns bananer!!!", "Tomu");
        // $this->collection->addItem($scribbleItem3);  

        // var_dump($this->collection);
        // save to db
        // $saver->saveScribbles($scribbleItem);
        // $saver->saveScribbles($scribbleItem2);
        // ...............................................................             
        
        // var_dump($data);
        $lv = new \view\LayoutView();
        $v = new \view\LoginView();
        $sv = new \view\ScribbleView($data, true);

        $lv->render($v, $sv,  $this->collection->getCollection());
    }
}


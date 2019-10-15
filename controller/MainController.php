<?php

class MainController {

    public function __construct() {
        require_once('view/LayoutView.php');
        require_once('view/LoginView.php');
        require_once('view/PicsView.php');
    
        $lv = new LayoutView();
        $v = new LoginView();
        $pv = new PicsView();
    
        $lv->render($v, $pv);
    }
}


<?php

// MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');


require_once('view/LayoutView.php');
require_once('view/LoginView.php');
require_once('view/PicsView.php');


$lv = new LayoutView();
$v = new LoginView();
$pv = new PicsView();

$lv->render($v, $pv);


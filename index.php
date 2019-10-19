<?php

// MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('settings.php');
require_once('Application.php');

session_start();
$settings = new settings();
$start= new Application($settings);
$start->run();

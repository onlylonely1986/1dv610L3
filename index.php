<?php

// MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// TODO skapa upp settings och skicka med instansen
require_once('RunApplication.php');
$start= new RunApplication();
$start->run();

<?php

require_once('settings.php');
require_once('Application.php');

session_start();

$settings = new settings();
$start= new Application($settings);
$start->run();

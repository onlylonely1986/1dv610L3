<?php

require_once('settings.php');
require_once('Application.php');

session_start();
try {
    $settings = new settings();
    $start= new Application($settings);
    $start->run();
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


<?php

namespace controller;

require_once('view/LayoutView.php');
require_once('view/LoginView.php');
require_once('view/ScribbleView.php');
// require_once('.env');

// require_once('ScribbleController.php');

require_once('model/ScribbleItem.php');
require_once('model/ScribbleCollection.php');
class MainController {

    public function __construct() {

        // testar connection till servern flytta detta sen!
        // TODO: fixa dessa som säkra environment variables
        $servername = "localhost";
        $username = "user1";
        $password = "SU4toRmJ0PAlEhI2";
        $dbName = "scribbledb";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbName);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";
        // connect servern ..............................
        

        $scribbleItem = new \model\ScribbleItem("hej", "jag tycker om solen", "Lisa37");
        $this->collection = new \model\ScribbleCollection();
        $this->collection->addItem($scribbleItem);

        // try to push in data
        $sql = "INSERT INTO scribbleitem (user, title, text)
        VALUES ('$scribbleItem->user', '$scribbleItem->title', '$scribbleItem->text')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
        // ...............................................................

        $scribbleItem2 = new \model\ScribbleItem("Tjoho", "Hatar verkligen att slänga sopor, det luktar pyton!", "Pricken");
        $this->collection->addItem($scribbleItem2);

        $scribbleItem2 = new \model\ScribbleItem("Coola bananer", "Rackarns bananer!!!", "Tomu");
        $this->collection->addItem($scribbleItem2);       
    
        $lv = new \view\LayoutView();
        $v = new \view\LoginView();
        $sv = new \view\ScribbleView();

        $lv->render($v, $sv,  $this->collection->getCollection());
    }
}


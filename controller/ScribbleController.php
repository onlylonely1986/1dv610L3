<?php

// Controller för scribbleactivities

// validering för att kolla om inloggad
// kollar om användare lägger till en ny scribble

// hämtar i view, skickar till model
// validering för vissa input i view

// validering av input i model
// model sparar till db
// uppdaterar view med nya content

namespace controller;
require_once('model/ScribbleItem.php');
require_once('model/ScribbleCollection.php');

class ScribbleController {
    private $collection;

    public function __construct() {
        $scribbleItem = new \model\ScribbleItem("hej", "jag tycker om solen", "Lisa37");
        $this->collection = new \model\ScribbleCollection();
        $this->collection->addItem($scribbleItem);
        return $this->collection->getCollection();
    }

}

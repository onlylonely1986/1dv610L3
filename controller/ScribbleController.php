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
    private $view;
    private $storage;

    public function __construct($view, $storage) {
        $this->view = $view;
        $this->storage = $storage;
    }

    public function checkForNewScribble($user) {
        // TODO fixa meddelandefält som säger till om fälten är tomma att fylla i dem
        // fixa trimning och htmlentities
        if ($this->view->postNewScribble()) {
			try {
                $item = new \model\ScribbleItem($_POST['title'], $_POST['text'], $user);
                // $this->collection->addItem($scribbleItem);
                // $this->storage->saveScribbles($item);
                $_POST = [];
			} catch (\Exception $e) {
				$this->view->setNameWasTooShort();
			}
        } else {
            // echo ' no post no post ';
        }   
    }
}

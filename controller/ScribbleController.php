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
    private $session;

    public function __construct($view, $storage, \model\SessionModel $session) {
        $this->view = $view;
        $this->storage = $storage;
        $this->session = $session;
    }

    public function isThereNewScribble() : bool {
        if ($this->view->postNewScribble()) {
            return true;
        }
        return false;        
    }

    public function checkForNewScribble($user) : bool {
        // TODO fixa meddelandefält som säger till om fälten är tomma att fylla i dem
        // fixa trimning och htmlentities
        if ($this->view->postNewScribble()) {
			// try {
            $title = $this->view->getTitle();
            $text = $this->view->getText();
            $item = new \model\ScribbleItem($title, $text, $user);
                // $this->collection->addItem($scribbleItem);
            $this->storage->saveScribbles($item);
            $_POST = [];
            return true;
			// } catch (\Exception $e) {
			// 	$this->view->setNameWasTooShort();
			// }
        } else {
            return false;
        }
    }
}

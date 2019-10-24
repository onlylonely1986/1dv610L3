<?php

namespace controller;

require_once('model/ScribbleItem.php');

class ScribbleController {
    private $view;
    private $storage;
    private $session;

    public function __construct($view, $storage, \model\SessionModel $session) {
        $this->view = $view;
        $this->storage = $storage;
        $this->session = $session;
    }

    public function checkForNewScribble($user) : bool {
        // TODO fix a validation for empty input or to large texts
        // TODO fix the remove button functionality
        if ($this->view->postNewScribble()) {
			try {
                $title = $this->view->getTitle();
                $text = $this->view->getText();
                $item = new \model\ScribbleItem($user, $title, $text);
                $this->storage->saveScribbles($item);
                $_POST = [];
                return true;

			} catch (\Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
        } else {
            return false;
        }
    }
}

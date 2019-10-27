<?php

namespace controller;
require_once('view/ExceptionHTMLMessages.php');
require_once("model/ConnectionException.php");
require_once('model/ScribbleItem.php');

class ScribbleController {
    private $view;
    private $storage;
    private $session;
    private $userMsg;

    public function __construct($view, $storage, \model\SessionModel $session) {
        $this->view = $view;
        $this->storage = $storage;
        $this->session = $session;
        $this->userMsg = new \view\ExceptionHTMLMessages();
    }

    public function checkForNewScribble($user) : bool {
        // TODO fix a validation for empty input or to large texts
        // TODO fix the remove button functionality
        if ($this->view->postNewScribble()) {
            $title = $this->view->getTitle();
            $text = $this->view->getText();
            $item = new \model\ScribbleItem($user, $title, $text);
            try {
                $this->storage->saveScribbles($item);
                $_POST = [];
                return true;
			} catch (\model\ConnectionException $e) {
                // $this->layoutView->setMessage($this->userMsg::$messageToUser);
                $this->view->setMessage($this->userMsg::$messageToUserPublish);
                return false;
			}
        } else {
            return false;
        }
    }
}

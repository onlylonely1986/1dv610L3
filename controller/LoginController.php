<?php

namespace controller;

require_once("model/User.php");

class LoginController {

    public function __construct(\view\LoginView $view, \model\UserStorage $storage) {
        $this->view = $view;
        $this->storage = $storage;
    }

    public function checkForLoggedIn () : bool {
        $this->view->tryToLogin();
        // TODO bättre namn!
        if ($this->view->bothFieldsFilled()) {
            $user = $this->view->getUserName();
            $password = $this->view->getPassword();
            $newUser = new \model\User($user, $password);
            if ($this->storage->getUserFromDB($newUser)) {
                $this->view->loggedIn();
            } else {
                $this->view->wrongNameorPass();
            }
        }
        return false;
    }

    public function getUserName() {
        $user = $this->storage->getUser();
        return $user;
    }
}

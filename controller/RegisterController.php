<?php

namespace controller;

require_once("model/User.php");

class RegisterController {
    private $view;
    private $storage;

    public function __construct(\view\RegisterView $view, \model\UserStorage $storage) {
        $this->view = $view;
        $this->storage = $storage;
    }

    public function newRegistration() : bool {
        // return $this->view->wantsToRegister();
        if ($this->view->wantsToRegister()) {
            if($this->view->hitButton()) {
                if($this->view->isAllFieldsFilled()) {
                    if($this->view->validateInputs()) {
                        $newUser = new \model\User($user, $password);
                        if($this->storage->checkForPossibleName()) {
                            $this->view->createNewUser();
                        } else {
                            // kör nästa som kollar mot db "User exists, pick another username."
                            $this->view->wasNotPossibleToCreate();
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            }
                // TODO
                // hasch password 
                // create new user
                // check if user is in userstorage
                // save new user to db if everyting is ok
                // $newUser = new \model\User($user, $password);
                // if ($this->storage->getUserFromDB($newUser)) {
                //    $this->view->loggedIn();
                // } else {
                //     $this->view->wrongNameorPass();
                // }
        }
        return false;
    }
}

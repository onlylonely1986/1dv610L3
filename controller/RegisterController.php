<?php

namespace controller;

require_once("model/User.php");

class RegisterController {
    private $view;
    private $storage;
    private $session;
    private $newUser;

    public function __construct(\view\RegisterView $view, \model\UserStorage $storage, \model\SessionModel $session) {
        $this->view = $view;
        $this->storage = $storage;
        $this->session = $session;
    }

    public function newRegistration() : bool {
        if ($this->view->wantsToRegister()) {
            if($this->view->hitButton()) {
                if($this->view->isAllFieldsFilled()) {
                    if($this->view->validateInputs()) {
                        $user = $this->view->returnNewUserName();
                        if($this->storage->checkForPossibleName($user)) {
                            $password = $this->view->returnNewPassword();
                            $this->setNewUser($user, $password);
                            $this->storage->saveNewUserToDB($this->newUser);
                            $this->session->setRegisterSession();
                            return true;
                        } else {
                            $this->view->wasNotPossibleToCreate();
                            return false;
                        }
                    }
                }
            }
        }
        return false;
    }

    private function setNewUser($user, $password) {
        $this->newUser = new \model\User($user, $password);
    }

    public function getUserName() {
        return $this->newUser->getName();
    }
}

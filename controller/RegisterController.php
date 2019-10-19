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
        return $this->view->wantsToRegister();
    }
}

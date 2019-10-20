<?php

namespace controller;

require_once("model/User.php");

class LoginController {
    private $view;
    private $storage;
    private $session;
    private $user;

    public function __construct(\view\LoginView $view, \model\UserStorage $storage, \model\SessionModel $session) {
        $this->view = $view;
        $this->storage = $storage;
        $this->session = $session;
    }

    public function checkForLoggedIn () : bool {
        if($this->view->loggedOut($this->session->checkLoggedinSession())) {
            $this->session->unsetUserinSession();
            return false;
            // $isSessionWelcome = $this->session->checkWelcomeSession();
        } else if($this->view->loginWithCookies($this->session->checkWelcomeSession())) {
            $session->setUserSession();
            $this->user = $this->session->getUserName();
            return true;
        }else if ($this->session->checkReloadSession()) {
            $this->view->loggedInReload();
            $this->session->unsetWelcomeSession();
            $this->user = $this->session->getUserName();
            return true;
        } else  {
            return $this->tryToLogin();
        }
        return false;
    }

    private function tryToLogin () : bool {
        if ($this->view->tryToLogin()) {
            // TODO bättre namn!
            if ($this->view->bothFieldsFilled()) {
                $user = $this->view->getUserName();
                $password = $this->view->getPassword();
                $this->user = new \model\User($user, $password);
                if ($this->storage->getUserFromDB($this->user)) {
                    $this->session->setWelcomeSession($this->user);
                    $this->view->loggedIn();
                    return true;
                } else {
                    $this->view->wrongNameorPass();
                    return false;
                }
            }
        }
        return false;
    }
}

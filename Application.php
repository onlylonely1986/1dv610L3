<?php

require_once("model/UserStorage.php");
require_once("model/ScribbleStorage.php");
require_once("model/SessionModel.php");
require_once("controller/LoginController.php");
require_once("controller/RegisterController.php");
require_once("controller/ScribbleController.php");
require_once("view/ExceptionHTMLMessages.php");
require_once("view/LayoutView.php");
require_once("view/LoginView.php");
require_once("view/RegisterView.php");
require_once("view/DateTimeView.php");
require_once("view/ScribbleView.php");

class Application {
    private $userMsg;
    private $userStorage;
    private $scribbleStorage;
    private $session;
    private $mainController;
    private $loginController;
    private $registerController;
    private $scribbleController;
	private $username;
    private $layoutView;
    private $loginView;
    private $scribbleView;
    private $userIsLoggedIn;

    public function __construct($settings) {
        $this->userMsg = new \view\ExceptionHTMLMessages();
        $this->layoutView  = new \view\LayoutView();
        $this->scribbleView  = new \view\ScribbleView();
        $this->loginView  = new \view\LoginView();
        $this->registerView  = new \view\RegisterView();
        $this->session = new \model\SessionModel();
        $this->userStorage = new \model\UserStorage($settings);
        $this->scribbleStorage = new \model\ScribbleStorage($settings);
        try {
            $this->scribbleStorage->connect();
            $this->userStorage->connect();
        } catch (\model\ConnectionException $e) {
            $this->layoutView->setMessage($this->userMsg::$messageToUserConn);
        } catch (\Exception $e) {
            $this->layoutView->setMessage($this->userMsg::$messageToUser);
        }
        
        
        $this->loginController = new \controller\LoginController($this->loginView,
                                                                    $this->userStorage, 
                                                                    $this->session);
        $this->registerController = new \controller\RegisterController($this->registerView, 
                                                                        $this->userStorage, 
                                                                        $this->session);
        $this->scribbleController = new \controller\ScribbleController($this->scribbleView, 
                                                                        $this->scribbleStorage, 
                                                                        $this->session);
        
    }

	public function run() {
		$this->changeState();
		$this->generateOutput();
    }

	private function changeState() {
        if ($this->registerController->newRegistration()) {
            $this->username = $this->registerController->getUserName();
            $this->loginView->registerNewMessage($this->username);
            $this->layoutView->setRegisterState($this->session->checkRegisterSession());
        } else if($this->loginController->checkForLoggedIn()) {
            $this->registrationStates();
            $this->setSessionStates();
        } else if($this->session->checkLoggedinSession()) {
            if($this->session->checkLoggedinAndWelcomeSession()) {
                $this->session->unsetWelcomeSession();
            }
            $this->registrationStates();
            $this->setSessionStates();
        }
    }

    private function registrationStates() {
        if($this->session->checkRegisterSession()) {
            $this->session->unsetRegisterSession();
        }
        $this->layoutView->setRegisterState($this->session->checkRegisterSession());
    }

    private function setSessionStates () {
        $this->username = $this->session->getUserName();
        $this->loginView->setLoggedinState($this->username);
        $this->scribbleView->setLoggedinState($this->username);
        $this->layoutView->setLoggedinState($this->session->checkLoggedinSession());
        try {
            $this->scribbleController->checkForNewScribble($this->username);
        } catch (\model\ConnectionException $e) {
            $this->layoutView->setMessage($e->messageToUserConn);
        }
    }

	private function generateOutput() {
        $data = [];
        try {
            if ($this->scribbleStorage->connect()) {
                $data = $this->scribbleStorage->getSavedScribbles();
            }
        } catch (\model\ConnectionException $e) {
            $this->layoutView->setMessage($this->userMsg::$messageToUserConn);
        }
        $this->scribbleView->setCollection($data);        
        $dateView  = new \view\DateTimeView();
        $this->layoutView->render($this->loginView, $this->registerView, $dateView, $this->scribbleView);
	}
}

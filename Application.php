<?php

require_once("model/UserStorage.php");
require_once("model/ScribbleStorage.php");
require_once("model/ScribbleCollection.php");
require_once("controller/MainController.php");
require_once("controller/LoginController.php");
require_once("controller/ScribbleController.php");
require_once("view/LayoutView.php");
require_once("view/LoginView.php");
require_once("view/DateTimeView.php");
require_once("view/ScribbleView.php");

class Application {
    private $userStorage;
    private $scribbleStorage;
    private $mainController;
    private $loginController;
    private $scribbleController;
	private $user; 
    private $layoutView;
    private $loginView;
    private $scribbleView;
    private $userIsLoggedIn;
    
    public function __construct($settings) {
        $this->userStorage = new \model\UserStorage($settings);
        $this->scribbleStorage = new \model\ScribbleStorage($settings);
        $this->scribbleView  = new \view\ScribbleView();
        $this->loginView  = new \view\LoginView();
        $this->loginController = new \controller\LoginController($this->loginView, $this->userStorage);
        $this->scribbleController = new \controller\ScribbleController($this->scribbleView, $this->scribbleStorage);
    }

	public function run() {
		$this->changeState();
		$this->generateOutput();
	}
	private function changeState() {
        // $this->user = $this->userStorage->getUser();
		$this->userIsLoggedIn = $this->loginController->checkForLoggedIn();
        $this->userStorage->setUser($this->user);
        // TODO obs hårdkodat obs visa bara scribbles om man är inloggad
        // $this->scribbleView->setLoggedInState(self::$userIsLoggedIn, $this->user);
        // if ($this->user == 'Pricken') {
        //    $this->scribbleController->checkForNewScribble($this->user);
        // }
	}
	private function generateOutput() {
        $layoutView  = new \view\LayoutView();
        
        // $data = $this->scribbleStorage->getSavedScribbles();
        // $this->scribbleView->setCollection($data);        
        $dateView  = new \view\DateTimeView();

        // TODO om man är inloggad kör en speciell view för scribbles
        $layoutView->render($this->loginView, $dateView, $this->scribbleView);
	}
}

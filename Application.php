<?php

require_once("model/UserStorage.php");
require_once("model/ScribbleStorage.php");
require_once("model/ScribbleCollection.php");
require_once("controller/MainController.php");
require_once("controller/LoginController.php");
require_once("controller/ScribbleController.php");
require_once("view/LayoutView.php");
require_once("view/LoginView.php");
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
    private static $userIsLoggedIn;
    
    public function __construct($settings) {

        $this->userStorage = new \model\UserStorage($settings);
        $this->scribbleStorage = new \model\ScribbleStorage($settings);
        $this->scribbleView  = new \view\ScribbleView();
        // TODO behövs kanske inte för denna fil används till detta
        // $this->mainController = new \controller\MainController();
        $this->loginController = new \controller\LoginController();
        $this->scribbleController = new \controller\ScribbleController($this->scribbleView, $this->scribbleStorage);

        $this->user = $this->userStorage->getUser();
    }

	public function run() {
		$this->changeState();
		$this->generateOutput();
	}
	private function changeState() {
        // return true or false
		self::$userIsLoggedIn = $this->loginController->checkForLoggedIn();
        $this->userStorage->setUser($this->user);
        $this->scribbleView->setLoggedInState(self::$userIsLoggedIn, $this->user);
         // TODO obs hårdkodat
        if ($this->user == 'Pricken') {
            $this->scribbleController->checkForNewScribble($this->user);
        }
	}
	private function generateOutput() {
        $layoutView  = new \view\LayoutView();
		$body = $layoutView->getBody();
        $title = $layoutView->getTitle();
        
        $data = $this->scribbleStorage->getSavedScribbles();
        $this->scribbleView->setCollection($data);
 
        $loginView  = new \view\LoginView($title, $body);

        // TODO om man är inloggad kör en speciell view för scribbles
        $layoutView->render($loginView, $this->scribbleView);
	}
}

<?php

require_once("model/UserStorage.php");
require_once("model/ScribbleSaver.php");
require_once("model/ScribbleCollection.php");
require_once("controller/MainController.php");
require_once("controller/LoginController.php");
require_once("controller/ScribbleController.php");
require_once("view/LayoutView.php");
require_once("view/LoginView.php");
require_once("view/ScribbleView.php");

class RunApplication {
    private $storage;
    private $mainController;
    private $loginController;
    private $scribbleController;
	private $user; 
    private $layoutView;
    private $loginView;
    private $scribbleView;
    
    // TODO ta en settings i sin konstruktor, skicka in till de som sparar via db
    public function __construct() {

        $this->storage = new \model\UserStorage();
        $this->mainController = new \controller\MainController();
        $this->loginController = new \controller\LoginController();
        $this->scribbleController = new \controller\ScribbleController();

        $this->user = $this->storage->loadUser();
        $this->layoutView  = new \view\LayoutView();
    }

	public function run() {
		$this->changeState();
		$this->generateOutput();
	}
	private function changeState() {
		$this->loginController->doChangeUserName();
        $this->storage->saveUser($this->user);
        // TODO om vi är inloggade kör scribblecontroller annars kör inte den
	}
	private function generateOutput() {
		$body = $this->layoutView->getBody();
        $title = $this->layoutView->getTitle();
        $loginView  = new \view\LoginView($title, $body);
        $scribbleView  = new \view\ScribbleView();
        // $pageView = new \View\HTMLPageView($title, $body);

        // TODO om man är inloggad kör en speciell view för scribbles
        $loginView->echoHTML();
        $scribbleView->echoHTML();
	}
}

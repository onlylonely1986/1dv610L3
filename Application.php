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
    
    // TODO ta en settings i sin konstruktor, skicka in till de som sparar via db
    public function __construct($settings) {

        $this->userStorage = new \model\UserStorage();
        $this->scribbleStorage = new \model\ScribbleStorage($settings);
        // $this->mainController = new \controller\MainController();
        $this->loginController = new \controller\LoginController();
        $this->scribbleController = new \controller\ScribbleController();

        $this->user = $this->userStorage->loadUser();
    }

	public function run() {
		$this->changeState();
		$this->generateOutput();
	}
	private function changeState() {
		$this->loginController->checkForLoggedIn();
        $this->userStorage->setUser($this->user);
        // TODO om vi är inloggade kör scribblecontroller annars kör inte den
	}
	private function generateOutput() {
        $layoutView  = new \view\LayoutView();
		$body = $layoutView->getBody();
        $title = $layoutView->getTitle();
        // TODO kolla upp detta: Warning: mysqli_num_rows() expects parameter 1 to be mysqli_result, bool given in C:\xampp\htdocs\1dv610L3\model\ScribbleStorage.php on line 52
        $data = $this->scribbleStorage->getSavedScribbles();
 
        $loginView  = new \view\LoginView($title, $body);
        $scribbleView  = new \view\ScribbleView($data, true);
        // $pageView = new \View\HTMLPageView($title, $body);

        // TODO om man är inloggad kör en speciell view för scribbles
        $layoutView->render($loginView, $scribbleView);
	}
}

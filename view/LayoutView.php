<?php 

namespace view;

class LayoutView {

  private $sessionLoggedin;
  private $sessionRegister;
  private $message = "";

  public function setLoggedinState($sessionLoggedin) {
		$this->sessionLoggedin = $sessionLoggedin;
  }
  
  public function setRegisterState($sessionRegister) {
		$this->sessionRegister = $sessionRegister;
  }
  
  public function setMessage($message) {
    $this->message = $message;
  }
  
  public function render(LoginView $v, RegisterView $rv, DateTimeView $dv, ScribbleView $sv) {

    echo '<!DOCTYPE html>
      <html>
        <head>
            <meta charset="utf-8">
            <title>Scribbles</title>
        </head>
        <body>
          <h1>SCRIBBLEBOARD</h1>
          ' . $this->title() . '
          ' . $this->message . '
          <div class="container">
            ' . $this->body($v, $rv) . '
            ' . $dv->echoHTML() . '
          </div>
              ' . $this->ifLoggedIn($sv) . '
         </body>
      </html>
    ';
  }
  

  private function ifLoggedIn($sv) {
    if ($this->sessionLoggedin){
        return '<div> ' . $sv->echoHTML($this->sessionLoggedin) . ' </div';
    }
  }


  private function title() {
    if ($this->sessionRegister && isset($_GET['register'])) {
      if($this->sessionLoggedin) {
        return '<h2>Logged in</h2>';
      } else {
        return '<a href="?register">Register a new user</a>
              <h2>Not logged in</h2>';
      }
    } else if (isset($_GET['register'])) {
      return '<a href="?">Back to login</a>
                <h2>Register new member</h2>';
    } else if($this->sessionLoggedin) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<a href="?register">Register a new user</a>
              <h2>Not logged in</h2>';
    }
  }

  private function body(LoginView $v, RegisterView $rv) {
    if ($this->sessionRegister && isset($_GET['register'])){
      return $v->echoHTML($this->sessionLoggedin);
    } else if (isset($_GET['register'])) {
      return $rv->echoHTML();
    } else {
      return $v->echoHTML($this->sessionLoggedin);
    }
  }
}

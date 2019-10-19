<?php 

namespace view;

class LayoutView {
  
  public function render(LoginView $v, RegisterView $rv, DateTimeView $dv, ScribbleView $sv) {

    echo '<!DOCTYPE html>
      <html>
        <head>
            <meta charset="utf-8">
            <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->title() . '
          <div class="container">
            ' . $this->body($v, $rv) . '
            ' . $dv->echoHTML() . '
          </div>
          
         </body>
      </html>
    ';
  } /** <div class="container2">
            <h1>SCRIBBLEBOARD</h1>
            ' . $sv->echoHTML() . '
          </div>
    */
  /**
   *             ' . $this->renderIsLoggedIn($isLoggedIn) . '
            ' . $rv->showLink($showRegView) . '
            ' . $this->renderRegisterNew($showRegView) . '
          
          <div class="container">
              ' . $lv->response() . '
              ' . $rv->response($showRegView) . '
              
              ' . $dtv->show() . '
          </div>
   */


  private function title() {
    if (isset($_SESSION['register']) && isset($_GET['register'])) {
      return '<a href="?register">Register a new user</a>
              <h2>Not logged in</h2>';
    } else if (isset($_GET['register'])) {
      return '<a href="?">Back to login</a>
                <h2>Register new member</h2>';
    } else if(isset($_SESSION['loggedin'])) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<a href="?register">Register a new user</a>
              <h2>Not logged in</h2>';
    }
  }

  private function body(LoginView $v, RegisterView $rv) {
    if (isset($_SESSION['register']) && isset($_GET['register'])){
      unset($_SESSION['register']);
      return $v->echoHTML();
    } else if (isset($_GET['register'])) {
      return $rv->echoHTML();
    } else {
      return $v->echoHTML();
    }
  }
}

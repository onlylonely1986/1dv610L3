<?php 

namespace view;

class LayoutView {
  
  public function render(LoginView $v, DateTimeView $dv, ScribbleView $sv) {

    echo '<!DOCTYPE html>
      <html>
        <head>
            <meta charset="utf-8">
            <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          <a href="?register">Register a new user</a>
          ' . $this->titleIsLoggedIn() . '
          <div class="container">
            ' . $v->echoHTML() . '
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

  private function titleIsLoggedIn() {
    if(isset($_SESSION['loggedin'])) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function renderRegisterNew($registerNew) {
    if ($registerNew) {
      return '<h2>Register new member</h2>';
    }
    else {
      return '<h2></h2>';
    }
  }
}

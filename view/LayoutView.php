<?php

class LayoutView {
  
  public function render() {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Login to your place</h1>

         </body>
      </html>
    ';
  }
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

  private function renderIsLoggedIn($isLoggedIn) {
    if(isset($_SESSION['loggedin'])) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function renderRegisterNew($registerNew) {
    if ($registerNew) {
      return '<h2>Register new user</h2>';
    }
    else {
      return '<h2></h2>';
    }
  }
}

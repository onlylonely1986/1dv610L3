<?php

class LayoutView {
  
  public function render(LoginView $v, PicsView $pv) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
          <title>Favvo bilder</title>
        </head>
        <body>
          <h1>Logga in</h1>
          <div class="container">
            ' . $v->response() . '
          </div>
          <div class="container2">
            ' . $pv->showHTML() . '
          </div>
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

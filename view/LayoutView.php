<?php

namespace view;

class LayoutView {
  
  public function getBody() {

  }

  public function getTitle() {
  }

  public function render(LoginView $v, DateTimeView $dv, ScribbleView $sv) {

    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
          <title>Klotterplanket</title>
        </head>
        <body>
          <h1>KLOTTERPLANKET</h1>
          <h1>Logga in</h1>
          <div class="container">
            ' . $v->echoHTML() . '
            ' . $dv->echoHTML() . '
          </div>
          <div class="container2">
            ' . $sv->echoHTML() . '
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
      return '<h2>Inloggad</h2>';
    }
    else {
      return '<h2>Inte inloggad</h2>';
    }
  }

  private function renderRegisterNew($registerNew) {
    if ($registerNew) {
      return '<h2>Registrera ny användare</h2>';
    }
    else {
      return '<h2></h2>';
    }
  }
}

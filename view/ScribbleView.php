<?php

namespace view;

class ScribbleView {
  private static $isLoggedIn;
  private static $userName;
  private static $collection;
  private static $send;
  private static $title;
  private static $text;

  public function __construct() {
  }

  public function echoHTML() {
    // TODO om inloggad skicka med en rubrik, om inte skicka en annan
    if (!self::$isLoggedIn) {
      return '<h2>Dagens senaste klotter:</h2>
                 ' . $this->iterateOverScribbles() . '
              ';
    } else {
      return '<h2>Vad har du på hjärtat idag ' . self::$userName . ' ?</h2>
                 ' . $this->scribbleFormHTML(). '
                 ' . $this->iterateOverScribbles() . '
              ';
    }
  }

  public function postNewScribble() : bool {
    if (isset($_POST['title']) && isset($_POST['text'])) {
      return true;
    }
		  return false;
  }
  
  public function setCollection($data) {
    self::$collection = $data;
  }

  public function setLoggedInState($isLoggedIn, $user) {
    self::$isLoggedIn = $isLoggedIn;
    self::$userName = $user;
  }

  private function iterateOverScribbles() {
    $ret = "";
    foreach (self::$collection as $item) {
      $user = $item['user'];
      $title = $item['title'];
      $text = $item['text'];
      $ret .= "<p>Ny post: <b>$user</b>  säger: $title $text</p>";
      if(self::$isLoggedIn && self::$userName == $item['user']) {
        $ret .= '<input type="submit" value="Ta bort"/>';
      }
    }
    return $ret;
  }

  // TODO: ska vara synlig om man är inloggad och veta vem som är inloggad
  // TODO name = ej stringar
  private function scribbleFormHTML() {
    return '<form method="POST">
                <label for="">Hälsning:</label>
                <input type="text" id="' . self::$title . '" name="title" value="" />
                <label for="">Inlägg:</label>
                <input type="text" id="' . self::$text . '" name="text" />
                <input type="submit" name="' . self::$send . '"/>
            </form>';
  }
}

<?php

namespace view;

class ScribbleView {
  private static $isLoggedIn;
  private static $userName;

  private static $collection;

  public function __construct(array $data, bool $isLoggedIn) {
    self::$collection = $data;
    self::$isLoggedIn = $isLoggedIn;
    // TODO ta bort hårdkodningen av denna!
    self::$userName = "Tomu";
  }

  public function scribbleHTML() {
    // TODO om inloggad skicka med en rubrik, om inte skicka en annan
      return '<h2>Vad har du på hjärtat idag ' . self::$userName . ' ?</h2>
                 ' . $this->scribbleFormHTML(). '
                 ' . $this->iterateOverScribbles() . '
              ';
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
  private function scribbleFormHTML() {
    return '<form method="POST">
                <label for="">Hälsning:</label>
                <input type="text" id="" name="" value="" />
                <label for="">Inlägg:</label>
                <input type="text" id="" name="" value="" />
                <input type="submit"/>
            </form>';
  }
}

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

  public function echoHTML($sessionLoggedin) {
    // TODO om inloggad skicka med en rubrik, om inte skicka en annan
    if (!$sessionLoggedin) {
      return '<h2>The latest scribbles:</h2>
                 ' . $this->iterateOverScribbles() . '
              ';
    } else {
      return '<h2>What s up today ' . self::$userName . ' ?</h2>
                 ' . $this->scribbleFormHTML(). '
                 ' . $this->iterateOverScribbles() . '
              ';
    }
  }

  public function postNewScribble() : bool {
    if(isset($_POST[self::$send])) {
      echo "yes nu har du post";
      if (isset($_POST[self::$title]) && isset($_POST[self::$text])) {
				return true;
			}
    }
		return false;
  }
  
  public function setCollection($data) {
    self::$collection = $data;
  }

  public function setLoggedinState($user) {
    self::$userName = $user;
  }

  private function iterateOverScribbles() {
    $ret = "";
    foreach (self::$collection as $item) {
      $user = $item['user'];
      $title = $item['title'];
      $text = $item['text'];
      $ret .= "<p>Post: <b>$user</b>  says: $title || $text</p>";
      if(self::$isLoggedIn && self::$userName == $item['user']) {
        $ret .= '<input type="submit" value="Remove"/>';
      }
    }
    return $ret;
  }

  // TODO: ska vara synlig om man är inloggad och veta vem som är inloggad
  // TODO name = ej stringar
  private function scribbleFormHTML() {
    return '<form method="POST">
                <label for="">Say:</label>
                <input type="text" id="' . self::$title . '" name="title" value="" />
                <label for="">Say more:</label>
                <input type="text" id="' . self::$text . '" name="text" />
                <input type="submit" name="' . self::$send . '"/>
            </form>';
  }
}

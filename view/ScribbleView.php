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
      return '';
    } else {
      return '<h2>What s up today ' . self::$userName . ' ?</h2>
                 ' . $this->scribbleFormHTML(). '
                 ' . $this->iterateOverScribbles() . '
              ';
    } 
  }

  public function postNewScribble() : bool {
    // if(isset($_POST[self::$send])) {
      if (isset($_POST['title']) && isset($_POST['text'])) {
        self::$title = $_POST['title'];
        self::$text = $_POST['text'];
        return true;
    } else return false;
  }

  public function getTitle() {
    return self::$text;
  }
  
  public function getText() {
    return self::$title;
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
      if(self::$userName == $item['user']) {
        $ret .= '<input type="submit" value="Remove"/>';
      }
    }
    return $ret;
  }

  // TODO: ska vara synlig om man är inloggad och veta vem som är inloggad
  // TODO name = ej stringar
  private function scribbleFormHTML() {
      /**return '<form method="POST">
                  <label for="">Hälsning:</label>
                  <input type="text" id="" name="" value="" />
                  <input type="text" id="' . self::$title . '" name="title" value="" />
                  <label for="">Inlägg:</label>
                  <input type="text" id="' . self::$text . '" name="text" />
                  <input type="submit" name="' . self::$send . '"/>
              </form>';
              */
   return '<form href="?" method="POST">
                <label for="">Say:</label>
                <input type="text" id="' . self::$title . '" name="title" value="" />
                <label for="">Say more:</label>
                <input type="text" id="' . self::$text . '" name="text" />
                <input type="submit" name="' . self::$send . '" value="send"/>
            </form>
          ';
  }
}

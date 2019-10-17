<?php

namespace view;

class ScribbleView {
  private static $collection;

  public function __construct(array $data) {
    self::$collection = $data;
  }

  public function scribbleHTML() {
      return '<h2>Vad har du på hjärtat idag?</h2>

              ' . $this->iterateOverScribbles() . '
      ';
  }

  private function iterateOverScribbles() {
    $ret = "";
    foreach(self::$collection as $d) {
      $ret .= "<p>Klotter: </br><b>";
      $ret .= "$d['user']";
      $ret .= "</b> säger: ";
      $ret .= "$d['title'] $d['text']";
      $ret .= "</p>\n";
    }
    // foreach (self::$collection as $item => $item_value) {
    //  $ret .= "<p>Ny post: <b>$item_value->user</b>  säger: $item_value->title  $item_value->text</p>\n";
    // }
    return $ret;
  }
}

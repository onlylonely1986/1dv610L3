<?php

namespace view;

class ScribbleView {

  
  public function scribbleHTML(array $collection) {
      return '<h2>Vad har du på hjärtat idag?</h2>

              ' . $this->iterateOverScribbles($collection) . '
      ';
  }

  private function iterateOverScribbles($collection) {
    $ret = "";
    foreach ($collection as $item => $item_value) {
      $ret .= "<p>Ny post: <b>$item_value->user</b>  säger: $item_value->title  $item_value->text</p>\n";
    }
    return $ret;
  }
}

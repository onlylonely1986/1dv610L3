<?php

namespace view;

class ScribbleView {

  
  public function scribbleHTML(array $collection) {
      return '<h2>Vad har du på hjärtat idag?</h2>
              <h4>Rubrik</h4>
              <p>Innehåll</p>

              ' . $this->iterateOverScribbles($collection) . '
      ';
  }

  private function iterateOverScribbles($collection) {
    
    foreach ($collection as $item => $item_value) {
      return "<p>Ny post: $item_value->user  säger  $item_value->title !</p>\n";
    }
  }
}

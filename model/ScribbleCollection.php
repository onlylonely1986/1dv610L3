<?php

namespace model;

class ScribbleCollection {

    private $collection = array();

    public function addItem(ScribbleItem $item) {
        array_push($this->collection, $item);
    }

    public function getCollection() {
        return $this->collection;
    }
}


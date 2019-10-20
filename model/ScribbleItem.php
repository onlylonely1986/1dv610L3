<?php

namespace model;

class ScribbleItem {
    // TODO encapsulates and write getters for these, also make them private
    public $title;
    public $text;
    public $user;

    public function __construct(string $title, string $text, string $user) {
        $this->title = $title;
        $this->text = $text;
        $this->user = $user;
    }
}

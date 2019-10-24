<?php

namespace model;

class ScribbleItem {
    // TODO encapsulates and write getters for these, also make them private
    public $user;
    public $title;
    public $text;

    public function __construct(string $user, string $title, string $text) {
        $this->user = $user;
        $this->title = $title;
        $this->text = $text;
    }
}

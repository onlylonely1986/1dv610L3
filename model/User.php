<?php

namespace model;

class User {
    private static $username;
    private static $password;

    public function __construct($username, $password) {
        self::$username = $username;
        self::$password = $password;
    }

    public function getName () {
        return self::$username;
    }

    public function getPass () {
        return self::$password;
    }
}

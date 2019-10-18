<?php

class User {
    private static $userName;
    private static $passWord;

    public function __construct($username, $password) {
        self::$username = $username;
        self::$password = $password;
    }
}

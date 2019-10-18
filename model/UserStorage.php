<?php

namespace model;

class UserStorage {
    private static $serverName;
    private static $userName;
    private static $passWord;
    private static $dbName;
    private static $dbTable;
    private static $conn;

    private static $user;

    public function __construct($settings) {
        self::$serverName = $settings->dbserverName;
        self::$userName = $settings->dbuserName;
        self::$passWord = $settings->dbpassWord;
        self::$dbName = $settings->dbName;
        self::$dbTable = $settings->dbTableNameUsers;
    }

    public function getUser() {
        return 'Pricken';
    }

    public function setUser($user) {
        self::$user = $user;
    }
}
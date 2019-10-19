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

        self::$conn = $this->connect();
        if (self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
    }

    // TODO sql injections
    // use prepered statements
    private function connect() {
        self::$conn = new \mysqli(
                self::$serverName,
                self::$userName, 
                self::$passWord, 
                self::$dbName
        );
        if(self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
        return self::$conn;
    }

    public function getUserFromDB(User $newUser) {
        $query = "SELECT * FROM " . self::$dbTable;
        if ($result = self::$conn->query($query)) {
            while ($row = $result->fetch_row()) {
                if ($row[0] == $newUser->getName() && $row[1] == $newUser->getPass()) {
                    return true;
                }
            }
            $result->close();
        }
        return false;
    }

    public function checkForPossibleName() {
        // TODO kolla mot db om username finns där sen innan
    }

    public function getUser() {
        return 'Pricken';
    }

    public function setUser($user) {
        self::$user = $user;
    }
}
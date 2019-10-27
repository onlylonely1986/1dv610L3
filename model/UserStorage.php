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
    
    // TODO do an abstract class for storage and let the two storages inherit from it
    // TODO create kind of facade so I do not let other classes know about how I save things
    public function __construct($settings) {
        self::$serverName = $settings->dbserverName;
        self::$userName = $settings->dbuserName;
        self::$passWord = $settings->dbpassWord;
        self::$dbName = $settings->dbName;
        self::$dbTable = $settings->dbTableNameUsers;
    }

    // TODO avoid sql injections and use prepered statements
    // TODO avoid repeating code in different classes (ScribbleStorage)
    public function connect() {
        self::$conn = new \mysqli(
            self::$serverName,
            self::$userName, 
            self::$passWord, 
            self::$dbName
        );
        if (!self::$conn->connect_errno) {
            return true;
        } else {
            throw new ConnectionException();
            exit();
            return false;
        }
    }

    public function getUserFromDB(User $newUser) {
        $this->connect();
        $query = "SELECT * FROM " . self::$dbTable;
        
        if ($result = self::$conn->query($query)) {
            if(!$result) {
                throw new ConnectionException();
                return false;
            }
            while ($row = $result->fetch_row()) {
                if ($row[0] == $newUser->getName() && $row[1] == password_verify($newUser->getPass(), $row[1])) {
                    return true;
                }
            }
            $result->close();
        }
        return false;
    }

    public function checkForPossibleName(string $username) : bool {
        $query = "SELECT * FROM " . self::$dbTable;
        if ($result = self::$conn->query($query)) {
            if(!$result) {
                throw new ConnectionException();
                return false;
            }
            while ($row = $result->fetch_row()) {
                if ($row[0] == $username) {
                    return false;
                }
            }
            $result->close();
        }
        return true;
    }

    public function saveNewUserToDB(User $user) {
        $this->connect();
        $inputPwd = $user->getPass();
        $hashPwd = password_hash($inputPwd, PASSWORD_DEFAULT);

        $sql = "INSERT INTO " . self::$dbTable;
        $sql .= "(";
        $sql .= "`username`, `password`";
        $sql .= ")";
        $sql .= "VALUES ";
        $sql .= "(";
        $sql .= "'". $user->getName() ."', ";
        $sql .= "'". $hashPwd ."'";
        $sql .= ");";

        $results = self::$conn->query($sql);       
        if(!$results) {
            throw new ConnectionException();
        }
    }
}
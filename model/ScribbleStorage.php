<?php

namespace model;
require_once("ConnectionException.php");

class ScribbleStorage {

    private static $serverName;
    private static $userName;
    private static $passWord;
    private static $dbName;
    private static $dbTable;
    private static $conn;
    private $collectionOfItems;

    public function __construct($settings) {
        self::$serverName = $settings->dbserverName;
        self::$userName = $settings->dbuserName;
        self::$passWord = $settings->dbpassWord;
        self::$dbName = $settings->dbName;
        self::$dbTable = $settings->dbTableName;
    }

    public function connect() : bool {
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

    public function getSavedScribbles() : array {
        $sqli = "SELECT * FROM " . self::$dbTable;
        $result = mysqli_query(self::$conn, $sqli);
        if(!$result) {
            throw new ConnectionException();
        }
        $data = array();
        if(mysqli_num_rows($result) > 0) {
            while($obj = $result->fetch_object()) {
                $this->collectionOfItems[] = new ScribbleItem($obj->user, $obj->title, $obj->text);
            }
        }

        mysqli_close(self::$conn);
        return $this->collectionOfItems;
        
    }

    // TODO avoid sql injections and use prepered statements
    public function saveScribbles($scribbleItem) {
        $sql = "INSERT INTO " . self::$dbTable;
        $sql .= "(";
        $sql .= "`user`, `title`, `text`";
        $sql .= ")";
        $sql .= "VALUES ";
        $sql .= "(";
        $sql .= "'".$scribbleItem->user."', ";
        $sql .= "'".$scribbleItem->title."', ";
        $sql .= "'".$scribbleItem->text."' ";
        $sql .= ");";

        $results = self::$conn->query($sql);  
        if(!$results) {
            throw new ConnectionException();
        }
    }

    public function removeScribble() {
        // TODO implement this
    }

    public function closeConnection () {
        if (!self::$conn->connect_errno) {
            self::$conn->close();
        } 
    }
}

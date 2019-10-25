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
 
        $this->connect();  
    }

    private function connect() {
        self::$conn = new \mysqli(self::$serverName, 
                                    self::$userName, 
                                    self::$passWord, 
                                    self::$dbName
                                );

        if (self::$conn->connect_errno) {
            throw new ConnectionException();
            exit();
        }
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

        try {
            $this->connect();
            $results = self::$conn->query($sql);        
        } catch (Exception $e) {
            echo "Error: " . $e . "<br>" . self::$conn->error;
        } finally {
            $this->closeConnection();
        }
    }

    public function getSavedScribbles() : array {

        try {
            $this->connect();
            $sqli = "SELECT * FROM " . self::$dbTable;
            $result = mysqli_query(self::$conn, $sqli);

            $data = array();
            if(mysqli_num_rows($result) > 0) {
                while($obj = $result->fetch_object()) {
                    $this->collectionOfItems[] = new ScribbleItem($obj->user, $obj->title, $obj->text);
                }
            }

            mysqli_close(self::$conn);
            return $this->collectionOfItems;
        } catch (Exception $e) {
            echo "Problems!! .... $e";
        } finally {
            $this->closeConnection();
        }
    }

    public function removeScribble() {
        // TODO implement this
    }

    public function closeConnection () {
        // echo "connection closed";
        self::$conn->close();
    }
}

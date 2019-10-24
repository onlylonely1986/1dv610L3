<?php

namespace model;

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
 
        try {
            self::$conn = $this->connect();
        // TODO write more specific exceptions for specific problems
        // TODO do an exeptions class for all exeptions so I don't repeat them or overuse strings
        } catch (Exception $e){
            self::$conn->connect_error;
            die("Connection failed: " . $e . "  " . self::$conn->connect_error);
        }
    }

    private function connect() {
        try {
            self::$conn = new \mysqli(
                self::$serverName,
                self::$userName, 
                self::$passWord, 
                self::$dbName
            );
            return self::$conn; 
        } catch(Exception $e) {
            die("Connection failed: " . $e . "  " . self::$conn->connect_error);
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
            $results = self::$conn->query($sql);        
        } catch (Exception $e) {
            echo "Error: " . $e . "<br>" . self::$conn->error;
        }        
    }

    public function getSavedScribbles() : array {

        try {
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
        }
    }

    public function removeScribble() {
        // TODO implement this
    }

    public function closeConnection () {
        self::$conn->close();
    }
}

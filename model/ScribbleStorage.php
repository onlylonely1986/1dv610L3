<?php

namespace model;

class ScribbleStorage {

    private static $serverName;
    private static $userName;
    private static $passWord;
    private static $dbName;
    private static $dbTable;
    private static $conn;

    public function __construct($settings) {
        self::$serverName = $settings->dbserverName;
        self::$userName = $settings->dbuserName;
        self::$passWord = $settings->dbpassWord;
        self::$dbName = $settings->dbName;
        self::$dbTable = $settings->dbTableName;
 
        try {
            self::$conn = $this->connect();
        // TODO write more specific exeptions for specific problems
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
        // TODO solve this so I not do an array of different types
        try {
            $sqli = "SELECT * FROM " . self::$dbTable;
            $result = mysqli_query(self::$conn, $sqli);

            $data = array();
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }
            mysqli_close(self::$conn);
            return $data;
        } catch (Exception $e) {
            echo "Problems!! .... $e";
        }
    }

    public function closeConnection () {
        self::$conn->close();
    }
}

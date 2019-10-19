<?php

namespace model;

require_once('model/ScribbleCollection.php');

class ScribbleStorage {

    private static $serverName;
    private static $userName;
    private static $passWord;
    private static $dbName;
    private static $dbTable;
    private static $conn;

    // Create connection
    public function __construct($settings) {
        self::$serverName = $settings->dbserverName;
        self::$userName = $settings->dbuserName;
        self::$passWord = $settings->dbpassWord;
        self::$dbName = $settings->dbName;
        self::$dbTable = $settings->dbTableName;

        self::$conn = $this->connect();
        if (self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
        // TODO: wronghandeling
        // echo "Connected successfully";
    }
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
        
    public function saveScribbles($scribbleItem) {
        $sql = "INSERT INTO `scribbleitem`";
        $sql .= "(";
        $sql .= "`user`, `title`, `text`";
        $sql .= ")";
        $sql .= "VALUES ";
        $sql .= "(";
        $sql .= "'".$scribbleItem->user."', ";
        $sql .= "'".$scribbleItem->title."', ";
        $sql .= "'".$scribbleItem->text."' ";
        $sql .= ");";

        // TODO: wronghandeling
        $results = self::$conn->query($sql);
        if (self::$conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . self::$conn->error;
        }        
    }

    public function getSavedScribbles() : array {
        // TODO validation check connection to db
        try {
        $sqli = "SELECT * FROM " . self::$dbTable;
            if($result = mysqli_query(self::$conn, $sqli)) {
                // echo "worked well";
            }

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

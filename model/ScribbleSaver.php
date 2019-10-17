<?php

namespace model;

require_once('model/ScribbleCollection.php');

class ScribbleSaver {

    // TODO: fixa dessa som säkra environment variables
    private static $servername = 'localhost';
    private static $username = 'user1';
    private static $password = 'SU4toRmJ0PAlEhI2';
    private static $dbName = 'scribbledb';
    private static $conn;

    // Create connection
    public function __construct() {
        self::$conn = mysqli_connect(self::$servername, self::$username, self::$password, self::$dbName);

        // Check connection
        if (self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
        // TODO: wronghandeling
        // echo "Connected successfully";
    }
        
    public function saveScribbles($scribbleItem) {
        $sql = "INSERT INTO scribbleitem (user, title, text)
        VALUES ('$scribbleItem->user', '$scribbleItem->title', '$scribbleItem->text')";

        // TODO: wronghandeling
        if (self::$conn->query($sql) === TRUE) {
            // echo "New record created successfully";
        } else {
            // echo "Error: " . $sql . "<br>" . $conn->error;
        }

        self::$conn->close();
    }

    public function getSavedScribbles() : array {
        // TODO validation check connection to db
        $sqli = "SELECT user, title, text FROM scribbleitem";
        $result = mysqli_query(self::$conn, $sqli);
        $data = array();
        
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            // foreach($data as $d) {
            //     echo $d['user'] . ": ";
            //     echo $d['title'] . " ";
            //    echo $d['text'] . "</br>";
            // }

            // $obj = new ScribbleCollection($data);
        }
        return $data;
        mysqli_close(self::$conn);
    }
}

<?php
    
//Klasse for tilkobling til db wine

class Database {

    private $host = "localhost";
    private $db_name = "wine";
    private $username = "root";
    private $password = "Bruhmoment9000";
    public $conn;

    //Koble til databasen
    public function getConnection(){

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }
        catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>


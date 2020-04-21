<?php

class Bruker {
    //Overordna felter
    private $conn;
    private $table_name = "bruker";

    public $brukernavn;
    public $passord;

    //Konstruktør
    public function __construct($conn) {
        $this->conn = $conn;
    }

    function read () {
        $query = "SELECT * FROM ".$this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function read_single() {
        $query = "SELECT * FROM ".$this->table_name." WHERE brukernavn='".$this->brukernavn."'"; 

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function sign_up() {
        if($this->alreadyExist()){
            return false;
        }

        $query = "INSERT INTO ".$this->table_name." (brukernavn, passord) VALUES ('$this->brukernavn','$this->passord')";
        $stmt = $this->conn->prepare($query);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function sign_in() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE brukernavn='".$this->brukernavn."' AND passord='".$this->passord."'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }


    function alreadyExist(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE brukernavn='".$this->brukernavn."'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}

?>

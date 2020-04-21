<?php
//Klassen entry


    class Entry {
        //Overordna felter
        private $conn;
        private $table_name = "entry";
       
        public $entryId;
        public $varenummer;
        public $brukernavn;
        public $beholdning;
        public $minvurdering;
        public $notater;
        public $dato;
        public $tid;
        
        //Konstruktør
        public function __construct($conn) {
            $this->conn = $conn;
            $this->dato = "dato!";
            $this->tid = "tid.";
            
            
        }
        
        function read() {
            $query = "SELECT * FROM ".$this->table_name. " WHERE brukernavn='".$this->brukernavn."'";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
        }
        
        function read_single() {
            $query = "SELECT * FROM ".$this->table_name." WHERE entryId=".$this->entryId; 
                
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
        }
        
        function delete(){
            $query = "DELETE FROM ".$this->table_name."
                    WHERE entryId='".$this->entryId."'";

            $stmt = $this->conn->prepare($query);

            // Returner true om vellykket 
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    



        
        function create() {
            if($this->alreadyExist()) {
                return false;
            }
            
            $query = "INSERT INTO ".$this->table_name."
                    (varenummer, brukernavn, beholdning, minvurdering, notater, dato, tid) 
                    VALUES
                    ('$this->varenummer', '".addslashes($this->brukernavn)."', '$this->beholdning','".addslashes($this->minvurdering)."','$this->notater','$this->dato','$this->tid')";

            $stmt = $this->conn->prepare($query);

            // Returner true om vellykket 
            if($stmt->execute()){ 
                return true;
            }
            return false;
        }
        
        function update(){
    
            // query to insert record
            $query = "UPDATE ".$this->table_name . " 
                    SET minvurdering='".$this->minvurdering."',notater='".$this->notater."',beholdning='".$this->beholdning."'
                    WHERE entryId='".$this->entryId."'";
            

            // prepare query
            $stmt = $this->conn->prepare($query);
            // execute query
            if($stmt->execute()){
                return true;
            }
            return false;
        }
        
        function alreadyExist(){
            $query = "SELECT * FROM " . $this->table_name . " WHERE varenummer='".$this->varenummer."' AND brukernavn='".$this->brukernavn."'";

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



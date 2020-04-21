<?php
    

//Klassen vin

    class Vin {
        //Overordna felter
        private $conn;
        private $table_name = "vin";
        
       
       
        //Felter henta fra vinmonopolets API
        public $varenummer; 
        public $varenavn; 
        public $aargang;
        public $produsent; 
        public $produsentId; 
        
        public $land; 
        public $landId; 
        public $distrikt; 
        public $distriktId;
        public $underdistrikt; 
        public $underdistriktId; 
        
        public $volum; 
        public $pris; 
        public $alkoholprosent; 
        public $vintype; 
        public $vintypeId;
        public $metode; 
        public $passertil1; 
        public $passertil2; 
        public $passertil3;      
        public $raastoff; 
        public $farge; 
        public $lukt; 
        public $smak; 
        public $fylde; 
        public $friskhet; 
        public $garvestoffer; 
        public $bitterhet; 
        public $sødme; 
        
  
        //Konstruktør
        public function __construct($conn) {
            $this->conn = $conn;
        }
        
        function read() {
            $query = "SELECT * FROM ".$this->table_name;
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
        }
        
        function read_single() {
            $query = "SELECT * FROM ".$this->table_name." WHERE varenummer=".$this->varenummer; 
                
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
        }
        
        function create() {
            
            
            $query = "INSERT INTO ".$this->table_name." "
                    . "(varenummer, varenavn, aargang, produsent, produsentId, land, landId, distrikt, distriktId, underdistrikt,"
                    . " underdistriktId, volum, pris, alkoholprosent, vintype, vintypeId, raastoff, metode, passertil1, passertil2,"
                    . " passertil3, farge, lukt, smak, fylde, friskhet, garvestoffer, bitterhet, sødme) "
                    . "VALUES "
                    . "('$this->varenummer', '".addslashes($this->varenavn)."', '$this->aargang','".addslashes($this->produsent)."',"
                    . "'$this->produsentId','".addslashes($this->land)."','$this->landId','".addslashes($this->distrikt)."',"
                    . "'$this->distriktId','".addslashes($this->underdistrikt)."','$this->underdistriktId','$this->volum',"
                    . "'$this->pris','$this->alkoholprosent','".addslashes($this->vintype)."','$this->vintypeId','$this->raastoff',"
                    . "'$this->metode','$this->passertil1','$this->passertil2','$this->passertil3','$this->farge','$this->lukt',"
                    . "'$this->smak','$this->fylde','$this->friskhet','$this->garvestoffer','$this->bitterhet','$this->sødme')"; //addslashes for å escape evt. tegn
            
             // prepare query statement
            $stmt = $this->conn->prepare($query);
            
            // Returner true om vellykket 
            if($stmt->execute()){ 
                return true;
            }
            return false;
            
        }
        
        function update(){
            $query = "UPDATE ".$this->table_name." 
                    SET beholdning='".$this->beholdning."', notater='".$this->notater."', minvurdering='".$this->minvurdering."'
                    WHERE varenummer='".$this->varenummer."'";

            $stmt = $this->conn->prepare($query);

            // Returner true om vellykket 
            if($stmt->execute()){
                return true;
            }
            return false;
        }
        
        function delete(){
            $query = "DELETE FROM ".$this->table_name."
                    WHERE varenummer= '".$this->varenummer."'";

            $stmt = $this->conn->prepare($query);

            // Returner true om vellykket 
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }

?>

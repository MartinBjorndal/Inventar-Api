<?php
    class Inventory{

        // Tilkobling
        private $conn;

        // Table
        private $db_table = "inventory";

        // Rader
        public $id;         //  Automatisk generert id, kan ikke endres.
        public $uid;        //  Manuelt satt InventarId
        public $name;       //  Navn på inventory
        public $created; //  Automatisk generert tidspunkt databasen mottok forespørsel
        public $location; //  Inventarets location
        public $status;     //  Inventarets status
        public $weight;       //  Inventarets weight
        public $size;  //  Inventarets size
        public $content;    //  Inventarets content
        public $image;      //  Bilde av inventaret
        public $comment;  //  Kommentar til inventaret


        // Database tilkobling
        public function __construct($db){
            $this->conn = $db;
        }


        // Få alt inventory
        public function getInventory(){
            $sqlQuery = "SELECT invId, invUid, invName, invCreated, invLocation, invStatus, invWeight, invSize, invContent, invImage, invComment FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }


        // Opprett inventory
        public function createInventory(){
            $sqlQuery = "INSERT INTO ". $this->db_table ." SET invUid = :uid, invName = :name, invLocation = :location, invWeight = :weight, invSize = :size, invContent = :content, invImage = :image, invComment = :comment";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->uid=htmlspecialchars(strip_tags($this->uid));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->location=htmlspecialchars(strip_tags($this->location));
            $this->weight=htmlspecialchars(strip_tags($this->weight));
            $this->size=htmlspecialchars(strip_tags($this->size));
            $this->content=htmlspecialchars(strip_tags($this->content));
            $this->image=htmlspecialchars(strip_tags($this->image));
            $this->comment=htmlspecialchars(strip_tags($this->comment));
        
            // bind data
            $stmt->bindParam(":uid", $this->uid);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":location", $this->location);
            $stmt->bindParam(":weight", $this->weight);
            $stmt->bindParam(":size", $this->size);
            $stmt->bindParam(":content", $this->content);
            $stmt->bindParam(":image", $this->image);
            $stmt->bindParam(":comment", $this->comment);

            if($stmt->execute()){
               return true;
            }
            return false;
        }


        // Få enkelt inventory
        public function getSingleInventory(){
            $sqlQuery = "SELECT 
                            invId, 
                            invUid, 
                            invName, 
                            invCreated, 
                            invLocation, 
                            invStatus, 
                            invWeight, 
                            invSize, 
                            invContent, 
                            invImage, 
                            invComment 
                        FROM 
                            " . $this->db_table . "
                        WHERE 
                        invId = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['invId'];
            $this->uid = $dataRow['invUid'];
            $this->name = $dataRow['invName'];
            $this->created = $dataRow['invCreated'];
            $this->location = $dataRow['invLocation'];
            $this->status = $dataRow['invStatus'];
            $this->weight = $dataRow['invWeight'];
            $this->size = $dataRow['invSize'];
            $this->content = $dataRow['invContent'];
            $this->image = $dataRow['invImage'];
            $this->comment = $dataRow['invComment'];
        }        

        // Oppdater inventory
        public function updateInventory(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        invUid          =    :uid,
                        invName         =    :name,
                        invLocation     =    :location,
                        invWeight       =    :weight,
                        invStatus       =    :status,
                        invSize         =    :size,
                        invContent      =    :content,
                        invImage        =    :image,
                        invComment      =    :comment
                    WHERE 
                        invId = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->uid=htmlspecialchars(strip_tags($this->uid));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->location=htmlspecialchars(strip_tags($this->location));
            $this->status=htmlspecialchars(strip_tags($this->status));
            $this->weight=htmlspecialchars(strip_tags($this->weight));
            $this->size=htmlspecialchars(strip_tags($this->size));
            $this->content=htmlspecialchars(strip_tags($this->content));
            $this->image=htmlspecialchars(strip_tags($this->image));
            $this->comment=htmlspecialchars(strip_tags($this->comment));
          
        
           // bind data
           $stmt->bindParam(":id", $this->id);
           $stmt->bindParam(":uid", $this->uid);
           $stmt->bindParam(":name", $this->name);
           $stmt->bindParam(":location", $this->location);
           $stmt->bindParam(":status", $this->status);
           $stmt->bindParam(":weight", $this->weight);
           $stmt->bindParam(":size", $this->size);
           $stmt->bindParam(":content", $this->content);
           $stmt->bindParam(":image", $this->image);
           $stmt->bindParam(":comment", $this->comment);

        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // Slett
        function deleteInventory(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE invId = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
<?php
    class User{

        // Tilkobling
        private $conn;

        // Table
        private $db_table = "users";

        // Rader
        public $id;         //  Automatisk generert id, kan ikke endres.
        public $uid;        //  Manuelt satt Brukerid
        public $pin;        //  Pinkode
        public $created;    //  Automatisk generert tidspunkt databasen mottok forespørsel
        public $name;       //  Name

        // Database tilkobling
        public function __construct($db){
            $this->conn = $db;
        }


        // Få alle users
        public function getUsers(){
            $sqlQuery = "SELECT usersId, usersUid, usersPin, usersCreated, usersName FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // Opprett bruker
        public function createUser(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        usersUid = :uid, 
                        usersPin = :pin, 
                        usersName = :name
                        ";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->uid=htmlspecialchars(strip_tags($this->uid));
            $this->pin=htmlspecialchars(strip_tags($this->pin));
            $this->name=htmlspecialchars(strip_tags($this->name));
        
            // bind data
            $stmt->bindParam(":uid", $this->uid);
            $stmt->bindParam(":pin", $this->pin);
            $stmt->bindParam(":name", $this->name);

            if($stmt->execute()){
               return true;
            }
            return false;
        }


        // Få enkelt bruker
        public function getUser(){
            $sqlQuery = "SELECT
                         usersId, 
                         usersUid, 
                         usersPin, 
                         usersCreated, 
                         usersName
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       usersId = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['usersId'];
            $this->uid = $dataRow['usersUid'];
            $this->pin = $dataRow['usersPin'];
            $this->created = $dataRow['usersCreated'];
            $this->name = $dataRow['usersName'];
        }        

        // Oppdater bruker
        public function updateUser(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        usersUid = :uid, 
                        usersPin = :pin, 
                        usersName = :name 
                    WHERE 
                        usersId = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->uid=htmlspecialchars(strip_tags($this->uid));
            $this->pin=htmlspecialchars(strip_tags($this->pin));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":uid", $this->uid);
            $stmt->bindParam(":pin", $this->pin);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // Slett
        function deleteUser(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE usersId = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
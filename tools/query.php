<?php
    class UseAuth{
        // Connection
        private $conn;
        // Table
        private $db_table = "users";
        // Columns
        public $id;
        public $name;
        public $nameUser;
        public $email;
        public $created;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getUser(){
            $sqlQuery = "SELECT id, name, nameUser, email, created FROM " . $this->users . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE
        public function createUser(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        nameUser = :nameUser, 
                        email = :email, 
                        password = :password,
                        created = :created";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->nameUser=htmlspecialchars(strip_tags($this->nameUser));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->created=htmlspecialchars(strip_tags($this->created));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":nameUser", $this->nameUser);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":created", $this->created);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // READ single
        public function getSingleEmployee(){
            $sqlQuery = "SELECT
                        id, 
                        name, 
                        nameUser, 
                        email,
                        created
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->nameUser = $dataRow['nameUser']; 
            $this->email = $dataRow['email'];
            $this->created = $dataRow['created'];
        } 
    }
?>
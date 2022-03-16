<?php
    class UseAuth{
        private $db_table = "users";
        public $id;
        public $name;
        public $nameUser;
        public $email;
        public $created;

        public function __construct($db){
            $this->conn = $db;
        }

        public function createUser(){
            $Query = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        nameUser = :nameUser, 
                        email = :email, 
                        password = :password,
                        created = :created";
        
            $stmt = $this->conn->prepare($Query);

            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->nameUser=htmlspecialchars(strip_tags($this->nameUser));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->created=htmlspecialchars(strip_tags($this->created));

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
    

        public function SignIn(){
            $Query = "SELECT 
            id, 
            name, 
            nameUser, 
            email,
            created
            FROM ". $this->db_table ." 
            WHERE (nameUser = :login OR email = :login) AND password = :password";

            $stmt = $this->conn->prepare($Query);

            $stmt->bindParam(":login", $this->login);
            $stmt->bindParam(":password", $this->password);

            $this->login=htmlspecialchars(strip_tags($this->login));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['id'];
            $this->name = $dataRow['name'];
            $this->nameUser = $dataRow['nameUser'];
            $this->email = $dataRow['email'];
            $this->created = $dataRow['created'];

            return $stmt;
        }

    }
?>
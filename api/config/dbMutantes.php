<?php
class Database{
 
    // specify your own database credentials
    //private $host = "localhost";
    private $host ="database-mutants.cwmqb0ncizfs.sa-east-1.rds.amazonaws.com";
    //private $db_name = "mutantes_db";
    private $db_name = "database-mutants";
    //private $username = "root";
    private $username = "admin";
    private $password = "";
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>

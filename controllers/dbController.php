<?php 

class Database { 
    private $host;
    private $username;
    private $password;
    private $dbName;
    private $conn; 
    public function __construct(){
         $this->establishConnection();
    }

    public function establishConnection(){
        $this->host = 'fdb1030.awardspace.net';
        $this->username = 'sql12721141';
        $this->password = 'JBdRN9A7AP';
        $this->dbName = 'sql12721141';
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbName);
        if(!mysqli_error($this->conn)) { 
            $status = true;
            echo "Connection established successfully";
        }else { 
            $status = false;
            echo " An error occurred";
        }
        return $this->conn;
    }

    public function runQuery($sql,$query){ 
        $result = mysqli_query($sql,$query);
        return $result;
    }
}
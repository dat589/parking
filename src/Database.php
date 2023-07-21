<?php
    
    class Database
    {
        private string $host = "localhost";
        private string $user = "root";
        private string $pass = "";
        private string $dbname = "parking";

        public function __construct()
        {

        }

        public function connection(): mysqli
        {
            $conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

            if($conn->connect_errno){
                die("Connection Failed: ".$conn->connect_error);
            }
            $conn->query("SET names 'utf8'");

            return $conn;
        }
    }
?>
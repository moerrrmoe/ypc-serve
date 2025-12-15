<?php
    class Database{
        private $db_name = 'ypc';
        private $user = 'root';
        private $pass = 'admin';
        private $host = 'localhost';

        public function connect(){
            $conn = new mysqli($this->host,$this->user,$this->pass,$this->db_name);
            return $conn;
        }
    }
?>
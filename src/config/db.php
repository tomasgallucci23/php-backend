<?php 


    class Connection{

        private $dbHost = "localhost";
        private $dbUser = "test"; 
        private $dbPass = "test123";
        private $dbName = "apiRest";

        //connection db

        public function Connect(){

            $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";

            $dbConnection = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);

            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $dbConnection;

        }
        
    }
<?php

trait Connection{
    public $host="localhost";
    public $dbName="expenses";
    public $user="root";
    public $password="";

    public function db(){
        $con=new PDO("mysql:host=$this->host; dbname=$this->dbName", $this->user, $this->password);

        if($con){
            return $con;
        }
        
    }
}
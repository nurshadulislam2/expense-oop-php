<?php
include "Connection.php";
class Database{
    use Connection;
    
    public $con;
    public function __construct(){
        $this->con=$this->db();
    }
}



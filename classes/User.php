<?php

class User{

    public $db;

    public function __construct($db){
        $this->db=$db;
    }
    public function register($fullName, $username, $email, $password){

        $check=$this->userNameExist($username, $email);
        if($check==1){
            $sql="INSERT INTO users (fullName, username, email, password) VALUES (:fullName, :username, :email, :password)";

            $statement=$this->db->con->prepare($sql);
            $statement->execute([
                ':fullName' =>  $fullName,
                ':username' =>  $username,
                ':email'    =>  $email,
                ':password' =>  md5($password)
            ]);

            return 1;
        }
        else{
            return 2;
        }
       
        
    }

    public function userNameExist($username, $email){
        $sql="SELECT * FROM users WHERE username='$username' OR email='$email'";
        $statement=$this->db->con->prepare($sql);
        $statement->execute();
        if($statement->rowCount()>0){
            return 0;
        }
        else{
            return 1;
        }
    }

    public function login($user, $password){
        $pass=md5($password);
        $sql="SELECT * FROM users WHERE (username='$user' OR email='$user') AND password='$pass'";
        $statement=$this->db->con->prepare($sql);
        $statement->execute();
        if($statement->rowCount()>0){
            session_start();
            $res=$statement->fetchAll();
            foreach($res as $value){
                $_SESSION['id']         =   $value['id'];
                $_SESSION['username']   =   $value['username'];
                $_SESSION['userType']   =   $value['userType'];
            }
            
            header("location: admin/dashboard.php");

            
        }
        else{
            return 1;
        }
    }

    public function allUser(){
        $sql    =   "SELECT * FROM users";
        $statement  =   $this->db->con->prepare($sql);
        $statement->execute();

        if($statement->rowCount()>0){
            $res=$statement->fetchAll();
            return $res;
        }
        else{
            return false;
        }
    }

    public function delete($id){
        $sql    =   "DELETE FROM users WHERE id='$id'";
        $statement  =   $this->db->con->prepare($sql);
        $res    =   $statement->execute();
        if($res){
            return true;
        }
    }
}
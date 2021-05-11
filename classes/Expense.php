<?php

class Expense{
    public $db;

    public function __construct($db){
        $this->db=$db;
    }

    public function create($userId, $name){
        $sql    =   "INSERT INTO expenses (user_id, name) VALUES (:userId, :name)";
        $statement=$this->db->con->prepare($sql);
        $res=$statement->execute([
            ':userId'   =>  $userId,
            ':name'     =>  $name
        ]);

        if($res){
            return true;
        }
    }

    public function select($id){
        $sql="SELECT * FROM expenses WHERE user_id='$id'";
        $statement=$this->db->con->prepare($sql);
        $statement->execute();
        

        if($statement->rowCount()>0){
            $res=$statement->fetchAll();
            return $res;
        }
        else{
            return false;
        }
    }

    public function createExpDet($name, $details, $image, $amount, $expId){
        
        if($image['tmp_name']!=''){
            $tmp_file=$image['tmp_name'];
            $image_name=uniqid().'.jpg';
            move_uploaded_file($tmp_file, 'image/'.$image_name);
        }
        else{
            $image_name=null;
        }

        $sql    =   "INSERT INTO exepense_details (expense_id, name, details, image, amount) VALUES (:expId, :name, :details, :image, :amount)";
        $statement=$this->db->con->prepare($sql);
        $res=$statement->execute([
                ':expId'    =>  $expId,
                ':name'     =>  $name,
                ':details'  =>  $details,
                ':image'    =>  $image_name,
                ':amount'   =>  $amount
        ]);
        
        

        if($res){
            return true;
        }
    }

    public function allExpDet($id){
        $sql    =   "SELECT * FROM exepense_details WHERE expense_id =:id";
        $statement  =   $this->db->con->prepare($sql);
        $statement->execute([
            ':id'   =>  $id
        ]);

        if($statement->rowCount()>0){
            $res    =   $statement->fetchAll();
            return $res;
        }
        else{
            return false;
        }

    }

    public function deleteExpDet($id){
        $sql    =   "DELETE FROM exepense_details WHERE id='$id'";
        $statement  =   $this->db->con->prepare($sql);
        $res    =   $statement->execute();

        if($res){
            return true;
        }
        
    }

    
}
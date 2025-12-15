<?php
require_once __DIR__.'/../../configs/db.php';
if($_SERVER['REQUEST_METHOD']==="GET" && isset($_GET['id'])){
    $id = $_GET['id'];
    $conn = (new Database())->connect();
    try{
        $query = "delete from comics where id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        if($stmt->affected_rows>0){
            echo "deleted successfully";
        }else{
            echo "id not found";
        }
    }catch(Exception $e){
        echo "error occured as below <br/>";
        echo $e;
    }
}
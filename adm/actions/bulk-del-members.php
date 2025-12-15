<?php
require __DIR__ . '/../../controller/member-controller.php';

if($_SERVER['REQUEST_METHOD']=="POST"){
    $controller = new memberController();
    try{
        $isRemoved = $controller->bulkRemoveMembers();

        if($isRemoved){
            echo json_encode(["status"=>"success","message"=>"expired members have been removed successfully"]);
        }else{
            echo json_encode(["error"=>"success","message"=>"no expired users found"]);
        }
    }catch(Exception $e){
        echo json_encode(["error"=>"success","message"=>$e->getMessage()]);
    }
}
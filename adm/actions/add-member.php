<?php
require_once __DIR__.'/../../controller/member-controller.php';
$memberController = new memberController();
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id = $_GET['id'];
    $exp = $_GET['exp'];
    if($memberController->addNewMember($id,$exp)){
        echo json_encode(["status"=>"success","message"=>"Member added/updated successfully"]);
    }else{
        echo json_encode(["status"=>"error","message"=>"Failed to add/update member"]);
    }
}
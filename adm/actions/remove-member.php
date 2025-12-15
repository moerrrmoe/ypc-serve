<?php
require_once __DIR__.'/../../controller/member-controller.php';
$memberController = new memberController();
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id = $_GET['id'];
    if($memberController->removeMember($id)){
        echo json_encode(["status"=>"success","message"=>"Member removed successfully"]);
    }else{
        echo json_encode(["status"=>"error","message"=>"Failed to remove member"]);
    }
}
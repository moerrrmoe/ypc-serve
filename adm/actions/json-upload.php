<?php
require __DIR__.'/../../configs/db.php';
require __DIR__.'/../../models/member.php';
if($_SERVER['REQUEST_METHOD']==="POST" && isset($_FILES['json'])){
    $json = $_FILES['json'];
    $raw = file_get_contents($json['tmp_name']);
    $members = json_decode($raw,true);
    $conn = (new Database())->connect();
    $success = 0;
    try{
    foreach($members as $member){
        $id = (int)$member['id'];
        $exp = $member['expdate'];
        $memberObj = new Member($id,$exp);
        $fee = $memberObj->fee;
        $query = "insert ignore into members (id, exp, fee) values(?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('isi',$id,$exp,$fee);
        if (!$stmt->execute()) {
            echo "Error on ID {$id}: " . $stmt->error . "\n";
            exit();
        }
        $success += $stmt->affected_rows;
    }
        echo json_encode(["status"=>"success","message"=>"$success members successfully imported"]);
        exit();
}catch(Exception $e){
    echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
}
}
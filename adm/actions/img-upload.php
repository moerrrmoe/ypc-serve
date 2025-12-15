<?php
if($_SERVER['REQUEST_METHOD']=="POST" && isset($_FILES['img'])){
    $img = $_FILES['img'];
    $path = __DIR__.'/../uploads/';
    if($img['error']== UPLOAD_ERR_OK){
        if(!is_dir($path)){
            mkdir($path,0777,true);
        }

        $fileName = basename($img['name']);
        $target = $path . $fileName;
        if(move_uploaded_file($img['tmp_name'],$target)){
            $url = "/ypc%20server/adm/uploads/".$fileName;
            echo json_encode(["status"=>"success","message"=>"image uploaded successfully","url"=>$url]);
        }else{
            echo json_encode(["status"=>"error","message"=>"an error occured"]);
        }
    }else{
    echo json_encode(["status"=>"error","message"=>"an error occured"]);
}
}
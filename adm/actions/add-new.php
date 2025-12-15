<?php
    include_once __DIR__.'/../../controller/comic-controller.php';
    require_once __DIR__.'/../../models/comic.php';
    require_once __DIR__.'/../../configs/db.php';
    $controller = new comicController();
    $comic = new Comic();
    $conn = (new Database())->connect();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data = json_decode(file_get_contents('php://input'), true);
        $comic->title = $data['title'];
        $comic->poster = $data['poster'];
        $comic->api = $data['api'];
        $comic->status = $data['status'];
        $comic->review = $data['review'];
        $comic->vip_last = $data['vip_last'];
        $comic->free_last = $data['free_last'];

        if(!is_null($comic->title) && count($comic->api) > 0){
            try{
                $query = "INSERT INTO comics (title, poster, status, review, vip_last, free_last) VALUES (?,?,?,?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssssss",$comic->title,$comic->poster,$comic->status,$comic->review,$comic->vip_last,$comic->free_last);
                if($stmt->execute()){
                    $comic_id = $stmt->insert_id;
                    $query = "INSERT INTO apis (c_id, api_url) VALUES (?,?)";
                    $stmt = $conn->prepare($query);
                    foreach($comic->api as $api){
                        $stmt->bind_param("is",$comic_id,$api);
                        $stmt->execute();
                    }
                    echo json_encode(["status"=>"success","message"=>"Comic added successfully"]);
            }
    }catch(Exception $e){
        echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
    }
}}

        
?>
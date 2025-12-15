<?php
    require_once __DIR__.'/../../configs/db.php';
    require_once __DIR__.'/../../models/comic.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $data = json_decode(file_get_contents('php://input'),true);
        if(!$data){
            die("Invalid request");
        }

        $comic = new Comic();
        $comic->id = $data['id'] ?? null;
        $comic->title = $data['title'] ?? null;
        $comic->poster = $data['poster'] ?? null;
        $comic->status = $data['status'] ?? null;
        $comic->review = $data['review'] ?? null;
        $comic->api = $data['api'] ?? [];
        $comic->vip_last = $data['vip_last'] ?? null;
        $comic->free_last = $data['free_last'] ?? null;

        if(!$comic->id){
            die("Comic ID is required");
        }else{
            try{
            $conn = (new Database())->connect();
            $query = "update comics set title = ?, poster = ?, status = ?, review = ?, vip_last = ?, free_last = ? where id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                $comic->title,
                $comic->poster,
                $comic->status,
                $comic->review,
                $comic->vip_last,
                $comic->free_last,
                $comic->id
            ]);
            $query = "delete from apis where c_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$comic->id]);
            $query = "insert into apis (c_id, api_url) values (?, ?)";
            $stmt = $conn->prepare($query);
            foreach($comic->api as $api){
                $stmt->execute([$comic->id, $api]);
            }
            
            if($data['recommend']){
                $query = "insert ignore into recommend (c_id) value (?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('ii',$comic->id,$comic->id);
                $stmt->execute();
            }else{
                $query = "delete from recommend where c_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('i',$comic->id);
                $stmt->execute();
            }
            echo json_encode(["status"=>"success","message"=>"Comic updated successfully"]);
            $conn->close();
        }catch(Exception $e){
            echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
        }
    }
    }
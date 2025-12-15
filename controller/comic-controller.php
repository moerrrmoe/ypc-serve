<?php
require_once __DIR__.'/../configs/db.php';
require_once __DIR__.'/../models/comic.php';
class comicController{
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function getAllComics(){
        $query = "Select * from comics order by id desc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stmt = $stmt->get_result();
        $comics = [];
        while($row = $stmt->fetch_assoc()){
            $comic = new Comic();
            $comic->id = $row['id'];
            $comic->title = $row['title'];
            $comic->poster = "https://vip.yotepyaclub.com".$row['poster'];
            $comic->status = $row['status'];
            $comic->review = $row['review'];
            $comic->api = $this->getApis($comic->id);
            $comic->vip_last = $row['vip_last'];
            $comic->free_last = $row['free_last'];
            array_push($comics,$comic);
        }
        return $comics;
    }

    public function getApis($id){
        $query = "select api_url from apis where c_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        $apis = [];
        $vip_api= null;
        while($row = $stmt->fetch_assoc()){
            if(str_contains($row['api_url'],'vip')){
                $vip_api = $row['api_url'];
            }else{
            array_push($apis,$row['api_url']);
            }
        }
        if($vip_api){
            array_push($apis,$vip_api);
        }
        return $apis;
    }

    public function getRecommend(){
        $query = "select c_id from recommend";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stmt = $stmt->get_result();
        $rc = [];
        while($row = $stmt->fetch_assoc()){
            array_push($rc,$row['c_id']);
        }
        return $rc;
    }

    public function getComicById($id){
        $query = "Select * from comics where id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($row = $stmt->fetch_assoc()){
            $comic = new Comic();
            $comic->id = $row['id'];
            $comic->title = $row['title'];
            $comic->poster = "https://vip.yotepyaclub.com".$row['poster'];
            $comic->status = $row['status'];
            $comic->review = $row['review'];
            $comic->api = $this->getApis($comic->id);
            $comic->vip_last = $row['vip_last'];
            $comic->free_last = $row['free_last'];
            return $comic;
        }
        return null;
    }
}
?>
<?php
require_once __DIR__.'/./../models/member.php';
require_once __DIR__.'/./../configs/db.php';
class memberController{
    private $conn;
    public function __construct(){
        $this->conn = (new Database())->connect();
    }

    public function getMemberById($id){
        $query = "select * from members where id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            return new Member($row['id'],$row['exp']);
        }else{
            return null;
        }
    }

    public function getAllMembers(){
        $query = "select * from members";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $list = [];
        while($row = $result->fetch_assoc()){
            array_push($list,$row);
        }
        return $list;
    }

    public function addNewMember($id,$exp){
        if(is_null($this->getMemberById($id))){
            $member = new Member($id,$exp);
            $query = "insert into members (id,exp,fee) values (?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("isi",$member->id,$member->exp,$member->fee);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                return true;
            }
        }else{
            $member = new Member($id,$exp);
            $query = "update members set exp = ?, fee = ? where id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sii",$member->exp,$member->fee,$member->id);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                return true;
            }
        }
        return false;
    }

    public function removeMember($id){
        $query = "delete from members where id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            return true;
        }
        return false;
    }

    public function updateMemberExp($id,$exp){
        $query = "update members set exp = ? where id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si",$exp,$id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            return true;
        }
        return false;
    }

    public function bulkRemoveMembers(){
        $query = "delete from members where exp < NOW()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            return true;
        }
        return false;
    }

    public function memberCount(){
        $query = "select count(id) as count from members";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $count=0;
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            $count = $row['count'];
        }
        return $count;
    }

    public function sumRevenue(){
        $query = "select sum(fee) as sum from members";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $sum=0;
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            $sum = $row['sum'];
        }
        return $sum;
    }
}
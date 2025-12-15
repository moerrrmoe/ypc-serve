<?php
    class Member{
        public $id;
        public $exp;
        public $fee;
        private $rate = [0,3900,3900,10000,10000,10000,18000];
        
        function __construct($id, $exp){
            $this->id = $id;
            $this->exp = $exp;
            $this->fee = $this->getFee();
        }

        public function getFee(){
            $now = new DateTime();
            $exp = new DateTime($this->exp);
            $diff = $now->diff($exp);
            $months = ($diff->y * 12) + $diff->m + ($diff->d > 0 ? 1 : 0);
            if($months < 1) $months = 1;
            if($months > 6) $months = 6;
            $this->fee = $this->rate[$months];
            return $this->fee;
        }
    }
?>
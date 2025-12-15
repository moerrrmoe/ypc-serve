<?php

class Card{
    public $id;
    public $title;
    public $img;

    function __construct($id, $title, $img)
    {
        $this->id = $id;
        $this->title = $title;
        $this->img = $img;
    }

    public function renderCard(){
        echo(
            "
            <div onclick=\"location.href='/ypc%20server/ypcbk/".$this->id."'\" class='col'>
            <div class='card'>
                <img src='".$this->img."' class='card-img-top' alt='comic poster'>
                <div class='card-body'>
                    <p class='fs-4'>".$this->title."</p>
                </div>
            </div>
            </div>
            "
        );
    }
}
<?php
namespace components;

class InsideCall{
    public $floor;
    public $fromFloor;

    public function __construct($floor, $fromFloor){
        $this->floor=$floor;
        $this->fromFloor=$fromFloor;
    }
}
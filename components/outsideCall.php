<?php
namespace components;

class OutsideCall{
    public $floor;
    public $direction;
    public $toFloor;

    public function __construct($floor, $direction, $toFloor){
        $this->floor=$floor;
        $this->direction=$direction;
        $this->toFloor=$toFloor;
    }
}
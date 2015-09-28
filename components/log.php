<?php
namespace components;

class Log
{
    static function message($message)
    {
        $file = 'log.txt';
        $message .= "\n";
        file_put_contents($file, $message, FILE_APPEND | LOCK_EX);
    }

    static function addPerson($call){
        static::message('Floor '.$call->floor.' add person go '.$call->direction.' to '.$call->toFloor);
    }

    static function removePerson($car){
        static::message('Floor '.$car->floor.' remove person from floor '.$car->fromFloor);
    }

    static function elevatorMoving($direction, $fromFloor, $toFloor){
        static::message('Elevator from floor '.$fromFloor.' '.$direction.' to floor '.$toFloor);
        static::message('Doors alarm');
    }

    static function doorMessage(){
        static::message('Doors open');
        static::message('Doors close');
    }

    static function maintenance($floor){
        Log::message('Floor '.$floor.' is maintenance');
    }
}
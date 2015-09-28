<?php
namespace components;

/**
 * Floor
 */
class Floor{

    /**
     * Check floor status
     * @param $floor
     * @return string enum(maintenance, operatinal)
     */
    static function checkFloorStatus($floor){
        if(in_array($floor, [2,4])){
            //log maintenance
            Log::maintenance($floor);
            return "maintenance";
        }else{
            return "operatinal";
        }
    }

}
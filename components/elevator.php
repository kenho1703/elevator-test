<?php

namespace components;

/**
 * Elevator
 */
class Elevator
{
    //const direction
    const DIRECTION_UP = 'up';
    const DIRECTION_DOWN = 'down';

    private $_currentDirection = 'up';
    private $_currentFloor = 1;
    //call list of Passenger press from the outside elevator
    private $_outsideCallList = [];
    //call list of Passenger press from the inside elevator
    private $_insideCallList = [];

    /**
     * Construct
     * @param $floor Current floor of elevator
     */
    public function __construct($floor)
    {
        if (isset($floor)) {
            $this->_currentFloor = $floor;
        }
    }

    /**
     * Passenger press call button from the outside elevator
     * @param $floor This value is floor press outside elevator
     * @param $direction This value is direction press outside elevator
     * @param $toFloor This value is floor press inside elevator
     */
    public function addCall($floor, $direction, $toFloor)
    {
        $this->_outsideCallList[] = new OutsideCall($floor, $direction, $toFloor);
    }

    /**
     * Moving
     */
    public function moving()
    {
        if (count($this->_outsideCallList) > 0 || count($this->_insideCallList) > 0) {

            $this->_removePressCallToCurrentFloor();

            $nextFloor = $this->_findNextFloor();
            if ($nextFloor) {
                $this->_setNextFloor($nextFloor);
            } else {
                if ($this->_currentDirection == static::DIRECTION_UP) {
                    $this->_currentDirection = static::DIRECTION_DOWN;
                } else {
                    $this->_currentDirection = static::DIRECTION_UP;
                }
            }
            //move to next floor
            $this->moving();
        }
    }

    /**
     * Remove press call to current floor
     * Remove call from the outside elevator of current floor
     * Remove call from the inside elevator to current floor
     */
    private function _removePressCallToCurrentFloor()
    {
        foreach ($this->_outsideCallList as $key => $call) {
            if ($this->_currentDirection == $call->direction && $this->_currentFloor == $call->floor) {
//                Log::addPerson($call);
                $this->_insideCallList[] = new InsideCall($call->toFloor, $call->floor);
                unset($this->_outsideCallList[$key]);
            }
        }
        foreach ($this->_insideCallList as $key => $car) {
            if ($this->_currentFloor == $car->floor) {
//                Log::removePerson($car);
                unset($this->_insideCallList[$key]);
            }
        }
    }

    /**
     * Find Next Floor
     * @return int Number floor of next floor
     */
    private function _findNextFloor()
    {
        $nextFloor = 0;
        if ($this->_currentDirection == static::DIRECTION_UP) {
            foreach ($this->_outsideCallList as $call) {
                if ($call->direction == $this->_currentDirection && $call->floor > $this->_currentFloor && (!$nextFloor || $nextFloor > $call->floor)) {
                    $nextFloor = $call->floor;
                }
            }
            foreach ($this->_insideCallList as $car) {
                if ($car->floor > $this->_currentFloor && (!$nextFloor || $nextFloor > $car->floor)) {
                    $nextFloor = $car->floor;
                }
            }
        } else {
            foreach ($this->_outsideCallList as $call) {
                if ($call->direction == $this->_currentDirection && $call->floor < $this->_currentFloor && (!$nextFloor || $nextFloor < $call->floor)) {
                    $nextFloor = $call->floor;
                }
            }
            foreach ($this->_insideCallList as $car) {
                if ($car->floor < $this->_currentFloor && (!$nextFloor || $nextFloor < $car->floor)) {
                    $nextFloor = $car->floor;
                }
            }
        }
        return $nextFloor;
    }

    /**
     * Moving to next Floor
     * @param $nextFloor
     */
    private function _setNextFloor($nextFloor)
    {
        Log::elevatorMoving($this->_currentDirection, $this->_currentFloor, $nextFloor);
        if (Floor::checkFloorStatus($nextFloor)=='operatinal') {
            Log::doorMessage();
        }
        $this->_currentFloor = $nextFloor;
    }
}
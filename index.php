<?php
$files = glob(__DIR__.'/components/*.php');
foreach ($files as $file) {
    require($file);
}

$down=\components\Elevator::DIRECTION_DOWN;
$up=\components\Elevator::DIRECTION_UP;


/**
 * Elevator standing in first floor
 * Request from 6th floor go down to ground(first floor).
 * Request from 5th floor go up to 7th floor
 * Request from 3rd floor go down to ground
 * Request from ground go up to 7th floor.
 * Floor 2 and 4 are in maintenance.
 */
$ele= new \components\Elevator();
//passenger form the 6th floor will press DOWN button from the outside,
//when he goes in the elevator he will press 1 to go down to ground floor
$ele->addCall(6, $down, 1);
$ele->addCall(5, $up, 7);
$ele->addCall(3, $down, 1);
$ele->addCall(1, $up, 7);
$ele->addCall(2, $down);
$ele->addCall(4, $up);

#start moving
$ele->moving();

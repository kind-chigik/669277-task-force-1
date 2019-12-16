<?php
namespace TaskForce\Actions;
use TaskForce\TaskStrategy;

abstract class AbstractActions 
{
    abstract public function getNameAction();
    abstract public function getInsideName();
    abstract public static function checkRightUser(TaskStrategy $obj, $status);
}
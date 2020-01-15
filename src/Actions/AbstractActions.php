<?php
namespace TaskForce\Actions;

abstract class AbstractActions 
{
    abstract public function getNameAction();
    abstract public static function getInsideName();
    abstract public static function checkRightUser($idCustomer, $idExecutor, $idCurrentUser, $status);
}
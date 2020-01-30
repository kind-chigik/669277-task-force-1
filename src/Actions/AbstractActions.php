<?php
namespace TaskForce\Actions;

abstract class AbstractActions 
{
    abstract public function getNameAction() : string;
    abstract public static function getInsideName() : string;
    abstract public static function checkRightUser(int $idCustomer, int $idExecutor, int $idCurrentUser, string $status) : bool;
}
<?php
namespace TaskForce\Actions;

abstract class AbstractActions 
{
    abstract public function getNameAction();
    abstract public function getInsideName();
    abstract public static function checkRightUser($idUser, $idCurrentUser, $status);
}
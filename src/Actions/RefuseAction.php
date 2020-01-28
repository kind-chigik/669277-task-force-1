<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class RefuseAction extends AbstractActions 
{
    public function getNameAction() : string
    {
        return 'Отказаться';
    }

    public static function getInsideName() : string 
    {
        return 'refuse';
    }
    public static function checkRightUser(int $idCustomer, int $idExecutor, int $idCurrentUser, string $currentStatus) : bool
    {
        if (($idCurrentUser === $idExecutor) && ($currentStatus === TaskStrategy::STATUS['in_work'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
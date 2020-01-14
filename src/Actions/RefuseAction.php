<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class RefuseAction extends AbstractActions 
{
    public function getNameAction()
    {
        return 'Отказаться';
    }

    public static function getInsideName() 
    {
        return 'refuse';
    }
    public static function checkRightUser($idCustomer, $idExecutor, $idCurrentUser, $currentStatus)
    {
        if (($idCurrentUser === $idExecutor) && ($currentStatus === TaskStrategy::STATUS['in_work'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
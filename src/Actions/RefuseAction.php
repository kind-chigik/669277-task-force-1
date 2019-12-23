<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class RefuseAction extends AbstractActions 
{
    public function getNameAction()
    {
        return 'Отказаться';
    }

    public function getInsideName() 
    {
        return 'refuse';
    }
    public static function checkRightUser($idExecutor, $idCurrentUser, $currentStatus)
    {
        if (($idCurrentUser === $idExecutor) && ($currentStatus === TaskStrategy::STATUS['in_work'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
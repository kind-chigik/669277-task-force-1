<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class CompleteAction extends AbstractActions 
{
    public function getNameAction()
    {
        return 'Завершить';
    }

    public static function getInsideName() 
    {
        return 'complete';
    }

    public static function checkRightUser($idCustomer, $idExecutor, $idCurrentUser, $currentStatus)
    {
        if (($idCurrentUser === $idCustomer) && ($currentStatus === TaskStrategy::STATUS['in_work'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}


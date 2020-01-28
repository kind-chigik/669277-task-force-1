<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class CompleteAction extends AbstractActions 
{
    public function getNameAction() : string
    {
        return 'Завершить';
    }

    public static function getInsideName() : string
    {
        return 'complete';
    }

    public static function checkRightUser(int $idCustomer, int $idExecutor, int $idCurrentUser, string $currentStatus) : bool
    {
        if (($idCurrentUser === $idCustomer) && ($currentStatus === TaskStrategy::STATUS['in_work'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}


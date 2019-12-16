<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class CompleteAction extends AbstractActions 
{
    public function getNameAction()
    {
        return 'Завершить';
    }

    public function getInsideName() 
    {
        return 'complete';
    }

    public static function checkRightUser(TaskStrategy $obj, $status)
    {
        if (($obj->idCurrentUser === $obj->idCustomer) && ($status === TaskStrategy::STATUS['in_work'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}


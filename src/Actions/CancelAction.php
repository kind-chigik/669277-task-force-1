<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class CancelAction extends AbstractActions 
{
    public function getNameAction()
    {
        return 'Отменить';
    }

    public static function getInsideName() 
    {
        return 'cancel';
    }

    public static function checkRightUser($idCustomer, $idExecutor, $idCurrentUser, $currentStatus)
    {
        if (($idCurrentUser === $idCustomer) && ($currentStatus === TaskStrategy::STATUS['new'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
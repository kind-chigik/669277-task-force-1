<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class CancelAction extends AbstractActions 
{
    public function getNameAction()
    {
        return 'Отменить';
    }

    public function getInsideName() 
    {
        return 'cancel';
    }

    public static function checkRightUser($idCustomer, $idCurrentUser, $currentStatus)
    {
        if (($idCurrentUser === $idCustomer) && ($currentStatus === TaskStrategy::STATUS['new'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
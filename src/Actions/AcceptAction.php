<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class AcceptAction extends AbstractActions 
{
    public function getNameAction()
    {
        return 'Принять';
    }

    public static function getInsideName() 
    {
        return 'accept';
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
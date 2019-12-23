<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class AcceptAction extends AbstractActions 
{
    public function getNameAction()
    {
        return 'Принять';
    }

    public function getInsideName() 
    {
        return 'accept';
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
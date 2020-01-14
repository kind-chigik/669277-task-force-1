<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class RespondAction extends AbstractActions 
{
    public function getNameAction()
    {
        return 'Откликнуться';
    }

    public static function getInsideName() 
    {
        return 'respond';
    }

    public static function checkRightUser($idCustomer, $idExecutor, $idCurrentUser, $currentStatus)
    {
        if (($idCurrentUser === $idExecutor) && ($currentStatus === TaskStrategy::STATUS['new'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
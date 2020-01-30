<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class AcceptAction extends AbstractActions 
{
    public function getNameAction() : string
    {
        return 'Принять';
    }

    public static function getInsideName() : string 
    {
        return 'accept';
    }

    public static function checkRightUser(int $idCustomer, int $idExecutor, int $idCurrentUser, string $currentStatus) : bool
    {
        if (($idCurrentUser === $idCustomer) && ($currentStatus === TaskStrategy::STATUS['new'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
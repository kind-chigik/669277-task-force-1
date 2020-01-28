<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class RespondAction extends AbstractActions 
{
    public function getNameAction() : string
    {
        return 'Откликнуться';
    }

    public static function getInsideName() : string
    {
        return 'respond';
    }

    public static function checkRightUser(int $idCustomer, int $idExecutor, int $idCurrentUser, string $currentStatus) : bool
    {
        if (($idCurrentUser === $idExecutor) && ($currentStatus === TaskStrategy::STATUS['new'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
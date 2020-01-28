<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class CancelAction extends AbstractActions 
{
    public function getNameAction() : string
    {
        return 'Отменить';
    }

    public static function getInsideName() : string
    {
        return 'cancel';
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
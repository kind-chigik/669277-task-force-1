<?php
namespace TaskForce\Actions;

use TaskForce\TaskStrategy;

class RespondAction extends AbstractActions 
{
    public function getNameAction()
    {
        return 'Откликнуться';
    }

    public function getInsideName() 
    {
        return 'respond';
    }

    public static function checkRightUser($idExecutor, $idCurrentUser, $status)
    {
        if (($TaskStrategy->idCurrentUser === $TaskStrategy->idExecutor) && ($status === TaskStrategy::STATUS['new'])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
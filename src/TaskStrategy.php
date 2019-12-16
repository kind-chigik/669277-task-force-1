<?php

namespace TaskForce;

use TaskForce\Actions\CancelAction;
use TaskForce\Actions\CompleteAction;
use TaskForce\Actions\RefuseAction;
use TaskForce\Actions\RespondAction;

class TaskStrategy {
    const ROLE = [
        'customer' => 'Заказчик',
        'executor' => 'Исполнитель',
        'unknown' => 'Анонимный'
    ];
    const ACTION = [
        'cancel' => CancelAction::class,
        'complete' => CompleteAction::class,
        'refuse' => RefuseAction::class,
        'respond' => RespondAction::class
    ];
    const STATUS = [
        'new' => 'Новое',
        'cancelled' => 'Отменено',
        'in_work' => 'В работе',
        'completed' => 'Выполнено',
        'failed' => 'Провалено'
    ];

    public $idCustomer;
    public $idExecutor;
    public $idCurrentUser;
    public $timeEnd;
    public $statusActive;
 
    public function __construct($idUser, $timeEnd, $statusActive)
    {
        $this->idCustomer = $idUser['idCustomer'];
        $this->idExecutor = $idUser['idExecutor'];
        $this->idCurrentUser = $idUser['idCurrentUser'];
        $this->timeEnd = $timeEnd;
        $this->statusActive = $statusActive;
    }

    public function getActionList()
    {
        $actionList = self::ACTION;
        return $actionList;
    }

    public function getStatusList()
    {
        $statusList = self::STATUS;
        return $statusList;
    }

    public function getNextStatus($action)
    {
        if ($action === self::ACTION['cancel']) {
            return self::STATUS['cancelled'];
        }

        if ($action === self::ACTION['accept']) {
            return self::STATUS['in_work'];
        }

        if ($action === self::ACTION['complete']) {
            return self::STATUS['completed'];
        }

        if ($action === self::ACTION['refuse']) {
            return self::STATUS['failed'];
        }
        return null;
    }

    public function getAvailableActions(TaskStrategy $obj, $status)
    {
        $availableActions = [];
        if ($status === TaskStrategy::STATUS['new']) {
            $checkRightsCancel = CancelAction::checkRightUser($obj, $status);
            if ($checkRightsCancel === true)
            {
                $availableActions[$status] = new CancelAction;
            }

            $checkRightsRespond = RespondAction::checkRightUser($obj, $status);
            if ($checkRightsRespond === true)
            {
                $availableActions[$status] = new RespondAction;
            }
        }

        if ($status === TaskStrategy::STATUS['in_work']) {
            $checkRightsComplete = CompleteAction::checkRightUser($obj, $status);
            if ($checkRightsComplete === true)
            {
                $availableActions[$status] = new CompleteAction;
            }

            $checkRightsRefuse = RefuseAction::checkRightUser($obj, $status);
            if ($checkRightsRefuse === true)
            {
                $availableActions[$status] = new RefuseAction;
            }
        }
        return $availableActions;
    }
}


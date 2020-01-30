<?php
declare(strict_types=1);

namespace TaskForce;

use TaskForce\Actions\CancelAction;
use TaskForce\Actions\CompleteAction;
use TaskForce\Actions\RefuseAction;
use TaskForce\Actions\RespondAction;
use TaskForce\Actions\AcceptAction;
use TaskForce\Exceptions\FakeStatusException;
use TaskForce\Exceptions\FakeActionException;

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
        'respond' => RespondAction::class,
        'accept' => AcceptAction::class,
    ];
    const STATUS = [
        'new' => 'Новое',
        'cancelled' => 'Отменено',
        'in_work' => 'В работе',
        'completed' => 'Выполнено',
        'failed' => 'Провалено'
    ];

    private $idCustomer;
    private $idExecutor;
    private $timeEnd;
    private $currentStatus;
 
    public function __construct(int $idCustomer, int $idExecutor, string $timeEnd, string $currentStatus)
    {
        $this->idCustomer = $idCustomer;
        $this->idExecutor = $idExecutor;
        $this->timeEnd = $timeEnd;
        if (!in_array($currentStatus, self::STATUS)) 
        {
            throw new FakeStatusException('Передан несуществующий статус');
        }
        $this->currentStatus = $currentStatus;

    }

    public function getActionList(): array
    {
        $actionList = self::ACTION;
        return $actionList;
    }

    public function getStatusList(): array
    {
        $statusList = self::STATUS;
        return $statusList;
    }

    public function getNextStatus(string $action) : ?string
    {
        if (!in_array($action, self::ACTION))
        {
            throw new FakeActionException('Передано несуществующее действие');
        }

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

    public function getAvailableActions(int $idCurrentUser) : array
    {
        $idCustomer = $this->idCustomer;
        $idExecutor = $this->idExecutor;
        $currentStatus = $this->currentStatus;
        $actions = self::ACTION;
        $availableActions = [];

        foreach ($actions as $action) {
            $checkRights = $action::checkRightUser($idCustomer, $idExecutor, $idCurrentUser, $currentStatus);
            if ($checkRights === true)
            {
                $availableActions[] = new $action;
            }
        }
                    
        return $availableActions; 
    }
}
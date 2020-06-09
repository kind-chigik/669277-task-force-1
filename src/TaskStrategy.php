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

    /**
     * Получает список всех возможных действий на сайте
     * 
     * @return array Массив с полными именами классов действий
     */
    public function getActionList(): array
    {
        $actionList = self::ACTION;
        return $actionList;
    }

    /**
     * Получает список всех возможных статусов на сайте
     * 
     * @return array Массив со статусами
     */
    public function getStatusList(): array
    {
        $statusList = self::STATUS;
        return $statusList;
    }

    /**
     * Определяет статус в зависимости от действия
     * 
     * @param string $action Действие
     * 
     * @return null|string Пустое значение или Статус
     */
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

    /**
     * Получает список доступных пользователю действий
     * 
     * @param int $idCurrentUser id текущего пользователя
     * 
     * @return array Массив с объектами действий
     */

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
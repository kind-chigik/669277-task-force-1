<?php

namespace TaskForce;

class Task {
    const ROLE = [
        'customer' => 'Заказчик',
        'executor' => 'Исполнитель',
        'unknown' => 'Анонимный'
    ];
    const ACTION = [
        'publish' => 'Опубликовать',
        'cancel' => 'Отменить',
        'accept' => 'Принять',
        'complete' => 'Завершить',
        'refuse' => 'Отказаться',
        'respond' => 'Откликнуться'
    ];
    const STATUS = [
        'new' => 'Новое',
        'cancellation' => 'Отменено',
        'in_work' => 'В работе',
        'completed' => 'Выполнено',
        'failed' => 'Провалено'
    ];

    public $idCustomer;
    public $idExecutor;
    public $timeEnd;
    public $statusActive;

    public function __construct($idCustomer, $idExecutor, $timeEnd, $statusActive)
    {
        $this->idCustomer = $idCustomer;
        $this->idExecutor = $idExecutor;
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

    public function getStatus($action)
    {
        if ($action === self::ACTION['cancel']) {
            return self::STATUS['cancellation'];
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
}
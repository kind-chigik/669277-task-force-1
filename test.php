<?php
require_once('vendor/autoload.php');
use TaskForce\TaskStrategy;

$idUser = [
    'idCustomer' => '128.0.0.6',
    'idExecutor' => '128.0.0.7',
    'idCurrentUser' => '128.0.0.7'
];
$timeEnd = '21.12.2019';
$statusActive = 'Новое';

$task = new TaskStrategy ($idUser, $timeEnd, $statusActive);

$action = TaskStrategy::ACTION['cancel'];
$status = $task->getNextStatus($action);
if ($status !== TaskStrategy::STATUS['cancelled']) {
    print 'Cтатус должен быть "Отменено"';
} else {
    print 'Проверка прошла успешно ';
}

$action = TaskStrategy::ACTION['accept'];
$status = $task->getNextStatus($action);
if ($status !== TaskStrategy::STATUS['in_work']) {
    print 'Статус должен быть "В работе"';
} else {
    print 'Проверка прошла успешно ';
}

$action = TaskStrategy::ACTION['complete'];
$status = $task->getNextStatus($action);
if ($status !== TaskStrategy::STATUS['completed']) {
    print 'Статус должен быть "Выполнено"';
} else {
    print 'Проверка прошла успешно ';
}

$action = TaskStrategy::ACTION['refuse'];
$status = $task->getNextStatus($action);
if ($status !== TaskStrategy::STATUS['failed']) {
    print 'Статус должен быть "Провалено"';
} else {
    print 'Проверка прошла успешно ';
}

$statusNew = TaskStrategy::STATUS['new'];                    //Если статус "Новое"
if ($idUser['idCurrentUser'] === $idUser['idExecutor']) {    //Пользователь = Исполнитель
    $objAction = $task->getAvailableActions($statusNew);
    var_dump($objAction);
    $nameAction = get_class($objAction[$statusNew]);
    if ($nameAction === TaskStrategy::ACTION['respond']) {   //Ему должно быть доступно только действие "Откликнуться"
        print 'Объект создан верно';
    } else {
        print 'Объект создан неверно';
    }
}

if ($idUser['idCurrentUser'] === $idUser['idCustomer']) {    //Пользователь = Заказчик
    $objAction = $task->getAvailableActions($statusNew);
    var_dump($objAction);
    $nameAction = get_class($objAction[$statusNew]);
    if ($nameAction === TaskStrategy::ACTION['cancel'])      {//Ему должно быть доступно действие "Отменить"
        print 'Объект создан верно';
    } else {
        print 'Объект создан неверно';
    }
}

$statusInWork = TaskStrategy::STATUS['in_work'];
if ($idUser['idCurrentUser'] === $idUser['idExecutor']) {
    $objAction = $task->getAvailableActions($statusInWork);
    var_dump($objAction);
    $nameAction = get_class($objAction[$statusInWork]);
    if ($nameAction === TaskStrategy::ACTION['refuse']) {
        print 'Объект создан верно';
    } else {
        print 'Объект создан неверно';
    }
}

if ($idUser['idCurrentUser'] === $idUser['idCustomer']) {
    $objAction = $task->getAvailableActions($statusInWork);
    var_dump($objAction);
    $nameAction = get_class($objAction[$statusInWork]);
    if ($nameAction === TaskStrategy::ACTION['complete']) {
        print 'Объект создан верно';
    } else {
        print 'Объект создан неверно';
    }
}
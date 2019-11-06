<?php
require_once('vendor/autoload.php');
use TaskForce\TaskStrategy;

$idCustomer = '128.0.0.6';
$idExecutor = '128.0.0.7';
$timeEnd = '21.12.2019';
$statusActive = 'Новое';

$task = new TaskStrategy ($idCustomer, $idExecutor, $timeEnd, $statusActive);

$action = TaskStrategy::ACTION['cancel'];
$status = $task->getNextStatus($action);
if ($status !== TaskStrategy::STATUS['cancellation']) {
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

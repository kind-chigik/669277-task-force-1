<?php
require_once('vendor/autoload.php');
use TaskForce\Task;

$idCustomer = '128.0.0.6';
$idExecutor = '128.0.0.7';
$timeEnd = '21.12.2019';
$statusActive = 'Новое';

$task = new Task ($idCustomer, $idExecutor, $timeEnd, $statusActive);

$action = Task::ACTION['cancel'];
$status = $task->getStatus($action);
if ($status !== Task::STATUS['cancellation']) {
    print 'Cтатус должен быть "Отменено"';
} else {
    print 'Проверка прошла успешно ';
}

$action = Task::ACTION['accept'];
$status = $task->getStatus($action);
if ($status !== Task::STATUS['in_work']) {
    print 'Статус должен быть "В работе"';
} else {
    print 'Проверка прошла успешно ';
}

$action = Task::ACTION['complete'];
$status = $task->getStatus($action);
if ($status !== Task::STATUS['completed']) {
    print 'Статус должен быть "Выполнено"';
} else {
    print 'Проверка прошла успешно ';
}

$action = Task::ACTION['refuse'];
$status = $task->getStatus($action);
if ($status !== Task::STATUS['failed']) {
    print 'Статус должен быть "Провалено"';
} else {
    print 'Проверка прошла успешно ';
}

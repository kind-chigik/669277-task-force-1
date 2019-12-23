<?php
require_once('vendor/autoload.php');
use TaskForce\TaskStrategy;
use TaskForce\Actions\CancelAction;
use TaskForce\Actions\CompleteAction;
use TaskForce\Actions\RefuseAction;
use TaskForce\Actions\RespondAction;
use TaskForce\Actions\AcceptAction;

$idCustomer = 128;
$idExecutor = 127;
$idCurrentUser = 128;
$timeEnd = '21.12.2019';
$currentStatus = 'Новое';

$task = new TaskStrategy ($idCustomer, $idExecutor, $timeEnd, $currentStatus);

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


$caseNewExecutor = [                                    // Связка [Статус - Новое, Пользователь - Исполнитель]
    'currentStatus' => TaskStrategy::STATUS['new'],
    'idCurrentUser' => 127,
    'expected' => [new RespondAction]
];

$caseNewCustomer = [                                    // Связка [Статус - Новое, Пользователь - Заказчик]
    'currentStatus' => TaskStrategy::STATUS['new'],
    'idCurrentUser' => 128,
    'expected' => [new CancelAction, new AcceptAction]
];

$caseNewUnauthorized = [                                // Связка [Статус - Новое, Пользователь - Неавторизованный]
    'currentStatus' => TaskStrategy::STATUS['new'],
    'idCurrentUser' => 129,
    'expected' => [null]
];

$caseInWorkExecutor = [                                // Связка [Статус - В работе, Пользователь - Исполнитель]
    'currentStatus' => TaskStrategy::STATUS['in_work'],
    'idCurrentUser' => 127,
    'expected' => [new RefuseAction]
];

$caseInWorkCustomer = [                                // Связка [Статус - В работе, Пользователь - Заказчик]
    'currentStatus' => TaskStrategy::STATUS['in_work'],
    'idCurrentUser' => 128,
    'expected' => [new CompleteAction]
];

print ('<br>' . 'Проверяем связку [Статус - Новое, Пользователь - Исполнитель]' . '<br>');
$taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $timeEnd, $caseNewExecutor['currentStatus']);
$currentActions = $taskStrategy->getAvailableActions($caseNewExecutor['idCurrentUser']);  //Создали объекты действий для проверяемой связки
$success = areArrayEqual($currentActions, $caseNewExecutor);
if ($success === true) {
    print 'Проверка прошла успешно' . '<br><br>';
} else {
    print 'Проверка для связки (Статус - Новое, Пользователь - Исполнитель) провалена' . '<br>';
}

print ('Проверяем связку [Статус - Новое, Пользователь - Заказчик]' . '<br>');
$taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $timeEnd, $caseNewCustomer['currentStatus']);
$currentActions = $taskStrategy->getAvailableActions($caseNewCustomer['idCurrentUser']);
$success = areArrayEqual($currentActions, $caseNewCustomer);
if ($success === true) {
    print 'Проверка прошла успешно' . '<br><br>';
} else {
    print 'Проверка для связки (Статус - Новое, Пользователь - Заказчик) провалена' . '<br>';
}

print ('Проверяем связку [Статус - Новое, Пользователь - Неавторизованный]' . '<br>');
$taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $timeEnd, $caseNewUnauthorized['currentStatus']);
$currentActions = $taskStrategy->getAvailableActions($caseNewUnauthorized['idCurrentUser']);
$success = areArrayEqual($currentActions, $caseNewUnauthorized);
if ($success === null) {
    print 'Проверка прошла успешно' . '<br><br>';
} else {
    print 'Проверка для связки (Статус - Новое, Пользователь - Неавторизованный) провалена' . '<br>';
}

print ('Проверяем связку [Статус - В работе, Пользователь - Исполнитель]' . '<br>');
$taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $timeEnd, $caseInWorkExecutor['currentStatus']);
$currentActions = $taskStrategy->getAvailableActions($caseInWorkExecutor['idCurrentUser']);
$success = areArrayEqual($currentActions, $caseInWorkExecutor);
if ($success === true) {
    print 'Проверка прошла успешно' . '<br><br>';
} else {
    print 'Проверка для связки (Статус - Новое, Пользователь - Исполнитель) провалена' . '<br>';
}

print ('Проверяем связку [Статус - В работе, Пользователь - Заказчик]' . '<br>');
$taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $timeEnd, $caseInWorkCustomer['currentStatus']);
$currentActions = $taskStrategy->getAvailableActions($caseInWorkCustomer['idCurrentUser']);
$success = areArrayEqual($currentActions, $caseInWorkCustomer);
if ($success === true) {
    print 'Проверка прошла успешно' . '<br><br>';
} else {
    print 'Проверка для связки (Статус - Новое, Пользователь - Заказчик) провалена' . '<br>';
}


/**
 * Проверяет наличие значений одного массива в другом массиве
 *
 * @param array $currentActions Массив с проверяемыми значениями
 * @param array $сase Массив, в котором должны содержаться искомые значения
 * @return bool true если искомое значение есть в массиве, в котором происходит поиск, иначе false и выход из цикла
 */

function areArrayEqual($currentActions, $сase) {
    foreach ($currentActions as $action) {
        if (in_array($action, $сase['expected'])) {
            $result = true;
        } else {
            $result = false;
        break;
        }
    }
    return $result;
}
<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('vendor/autoload.php');
use TaskForce\TaskStrategy;
use TaskForce\Actions\CancelAction;
use TaskForce\Actions\CompleteAction;
use TaskForce\Actions\RefuseAction;
use TaskForce\Actions\RespondAction;
use TaskForce\Actions\AcceptAction;
use TaskForce\Exceptions\FakeStatusException;
use TaskForce\Exceptions\FakeActionException;

$idCustomer = 128;
$idExecutor = 127;
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

// Тест метода getAvailableActions

$caseNewExecutor = [                                    // Связка [Статус - Новое, Пользователь - Исполнитель]
    'currentStatus' => TaskStrategy::STATUS['new'],
    'idCurrentUser' => 127,
    'expected' => ['respond']
];

$caseNewCustomer = [                                    // Связка [Статус - Новое, Пользователь - Заказчик]
    'currentStatus' => TaskStrategy::STATUS['new'],
    'idCurrentUser' => 128,
    'expected' => ['cancel', 'accept']
];

$caseNewUnknown = [                                // Связка [Статус - Новое, Пользователь - Неизвестный]
    'currentStatus' => TaskStrategy::STATUS['new'],
    'idCurrentUser' => 129,
    'expected' => []
];

$caseInWorkExecutor = [                                // Связка [Статус - В работе, Пользователь - Исполнитель]
    'currentStatus' => TaskStrategy::STATUS['in_work'],
    'idCurrentUser' => 127,
    'expected' => ['refuse']
];

$caseInWorkCustomer = [                                // Связка [Статус - В работе, Пользователь - Заказчик]
    'currentStatus' => TaskStrategy::STATUS['in_work'],
    'idCurrentUser' => 128,
    'expected' => ['complete']
];

print ('<br>' . 'Проверяем связку [Статус - Новое, Пользователь - Исполнитель]' . '<br>');
$taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $timeEnd, $caseNewExecutor['currentStatus']);
$currentActions = $taskStrategy->getAvailableActions($caseNewExecutor['idCurrentUser']);
$testResult = areArraysEqual($currentActions, $caseNewExecutor['expected']);

print ('Проверяем связку [Статус - Новое, Пользователь - Заказчик]' . '<br>');
$taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $timeEnd, $caseNewCustomer['currentStatus']);
$currentActions = $taskStrategy->getAvailableActions($caseNewCustomer['idCurrentUser']);
$testResult = areArraysEqual($currentActions, $caseNewCustomer['expected']);

print ('Проверяем связку [Статус - Новое, Пользователь - Неизвестный]' . '<br>');
$taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $timeEnd, $caseNewUnknown['currentStatus']);
$currentActions = $taskStrategy->getAvailableActions($caseNewUnknown['idCurrentUser']);
$testResult = areArraysEqual($currentActions, $caseNewUnknown['expected']);

print ('Проверяем связку [Статус - В работе, Пользователь - Исполнитель]' . '<br>');
$taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $timeEnd, $caseInWorkExecutor['currentStatus']);
$currentActions = $taskStrategy->getAvailableActions($caseInWorkExecutor['idCurrentUser']);
$testResult = areArraysEqual($currentActions, $caseInWorkExecutor['expected']);

print ('Проверяем связку [Статус - В работе, Пользователь - Заказчик]' . '<br>');
$taskStrategy = new TaskStrategy($idCustomer, $idExecutor, $timeEnd, $caseInWorkCustomer['currentStatus']);
$currentActions = $taskStrategy->getAvailableActions($caseInWorkCustomer['idCurrentUser']);
$testResult = areArraysEqual($currentActions, $caseInWorkCustomer['expected']);

try {
    $task = new TaskStrategy ($idCustomer, $idExecutor, $timeEnd, 'Старое');
}
catch (FakeStatusException $s) {
    print 'Проверка для исключения: ' . $s->getMessage() . ' - прошла успешно' . '<br>';
}

try {
    $action = 'Удалить';
    $task->getNextStatus($action);
}
catch (FakeActionException $a) {
    print 'Проверка для исключения: ' . $a->getMessage() . ' - прошла успешно' . '<br>';
}

/**
 * Проверяет наличие значений одного массива в другом массиве и выводит сообщение о результате проверки
 * 
 * @param $array1 array Массив с объектами, который должны содержаться в другом массиве
 * @param $array2 array Массив с объектами, в котором должны содержаться искомые значения
 * 
 * @return void
 */
function areArraysEqual(array $array1, array $array2 = array('expected')) : void
{
    $nameObject = [];
    foreach ($array1 as $key) {
        $nameObject[] = $key::getInsideName();
    }
    $diff = array_diff($nameObject, $array2);
    if ((empty($diff)) && (count($nameObject) === count($array2))) 
    {
    print 'Проверка прошла успешно' . '<br><br>';
    } else {
    print 'Проверка провалена' . '<br>';
    }
    return;
}

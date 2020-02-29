<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('vendor/autoload.php');

use TaskForce\DataConverter;

$files = [
    'categories' => __DIR__."/data/categories.csv", 
    'cities' => __DIR__."/data/cities.csv", 
    'tasks' => __DIR__."/data/tasks.csv",
    'replies' => __DIR__."/data/replies.csv",
    'users' => __DIR__."/data/users.csv"
];

foreach ($files as $tableName => $filePath) {
    $file = new DataConverter($filePath, $tableName);
    $sqlFilePath = __DIR__ .'/sql/'. $tableName . '.sql';
    $sqlFile = $file->createSqlFile($sqlFilePath);
}

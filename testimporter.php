<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('vendor/autoload.php');

use TaskForce\DataImporter;

$files = [
    'categories' => __DIR__."/data/categories.csv", 
    'specializations' => __DIR__."/data/specializations.csv",
    'cities' => __DIR__."/data/cities.csv", 
    'tasks' => __DIR__."/data/tasks.csv",
    'replies' => __DIR__."/data/replies.csv",
    'users' => __DIR__."/data/users.csv"
];

foreach ($files as $fileName => $filePath) {
    $file = new DataImporter($filePath, $fileName);
    $titlesFields = $file->getTitlesFilds();
    $data = $file->getData();
    $query = $file->convertDataToSql($data, $titlesFields);
    print $query . '<br>';
    $sqlFilePath = __DIR__ .'/sql/'. $fileName . '.sql';
    $sqlFile = $file->createSqlFile($sqlFilePath, $query);
}

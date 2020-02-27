<?php

namespace TaskForce;

class DataConverter {
    private $file;
    private $tableName;
    private $data;
    private $titlesFields;
    private $query;

    public function __construct(string $filePath, string $tableName)
    {
        $this->file = new \SplFileObject($filePath);
        $this->tableName = $tableName;
        $this->titlesFields = $this->getCsvHeaders();
        $this->data = $this->getData();
        $this->query = $this->convertDataToSql();
    }
    
    private function getData() : array
    {
        $this->file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::READ_AHEAD);
        foreach ($this->file as $row) {
            $result[] = $row;
        }
        return $result;
    }

    private function getCsvHeaders() : array {
        $this->file->rewind();
        $titlesFields = $this->file->fgetcsv();
        return $titlesFields;
    }

    private function convertDataToSql() : string
    {
        $counter = 0;
        $sliceData = array_slice($this->data, 1);
        $query = "INSERT INTO $this->tableName (";
        foreach ($this->titlesFields as $value) {
            $counter = $counter + 1;
            if ($counter !== count($this->titlesFields)) {
                $query .= $value . ', ';
            } else {
                $query .= $value . ')';
            }
        }
        $query .= ' VALUES ';
        $counter = 0;
            foreach ($sliceData as $keys => $values) {
            $counter = $counter + 1;
            $innerCounter = 0;
                foreach ($values as $value) {
                    $innerCounter = $innerCounter + 1;
                    if (count($values) === 1) {
                        $query .= '("' . $value . '")';
                    break;
                    }
                    if ($innerCounter === 1) {
                        $query .= '("' . $value . '"' . ','; 
                    } elseif ($innerCounter === count($values)) {
                        $query .= '"' . $value . '")';
                    } else {
                        $query .= '"' . $value . '"' . ',';
                    }
                }
                if ($counter !== count($sliceData)) {
                    $query .= ',';
                } else {
                    $query .= ';';
                }
        }
        return $query;
    }

    public function createSqlFile(string $sqlFilePath) 
    {
        $sqlFile = new \SplFileObject($sqlFilePath, 'w+');
        $sqlFile->fwrite($this->query);
        return;
    }
}

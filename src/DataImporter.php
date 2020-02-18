<?php

namespace TaskForce;

class DataImporter {
    private $file;
    private $fileName;

    public function __construct(string $filePath, string $fileName)
    {
        $this->file = new \SplFileObject($filePath);
        $this->fileName = $fileName;
    }
    
    public function getData() : array
    {
        $this->file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::READ_AHEAD);
        foreach ($this->file as $row) {
            $result[] = $row;
        }
        return $result;
    }

    public function getTitlesFilds() {
        $this->file->rewind();
        $titlesFields = $this->file->fgetcsv();
        return $titlesFields;
    }

    public function convertDataToSql(array $data, array $titlesFields) : string
    {
        $counter = 0;
        $sliceData = array_slice($data, 1);
        $query = "INSERT INTO $this->fileName (";
        foreach ($titlesFields as $value) {
            $counter = $counter + 1;
            if ($counter !== count($titlesFields)) {
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

    public function createSqlFile(string $sqlFilePath, string $query) 
    {
        $sqlFile = new \SplFileObject($sqlFilePath, 'w+');
        $sqlFile->fwrite($query);
        return;
    }
}

<?php
 namespace App\Core\Abstract;
use App\Core\App;



abstract class AbstractRepository
{
    protected \PDO $pdo;
    
     protected string $table;

    public function __construct()
    {
        $this->pdo = App::getDependency('database');
    }

    abstract public function selectAll();
    abstract public function insert($entity);
    abstract public function update($entity);
    abstract public function delete();



    

}
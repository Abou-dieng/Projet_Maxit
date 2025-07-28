<?php
namespace App\Migration;

use App\Core\App;
use Exception;
use PDO;
use PDOException;

class Migration{
    private PDO $pdo;
    private string $driver;
    public function __construct(PDO $pdo)
    {
        
        $this->pdo=$pdo;
        $this->driver=$pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    }
     public  function run(){
        $this->createDatabase();
        $this->createTables();
        echo "Migration de la base de données réussie";
     }
      private function createDatabase(){
        if($this->driver==="mysql"){
            $this->pdo->exec("CREATE DATABASE IF NOT EXIST " . DB_NAME);
             $this->pdo->exec("USE ". DB_NAME);

        }elseif($this->driver==="pgsql") {

            try{
                $pdo= new PDO("pgsql:host=". DB_HOST . ";port=" . DB_PORT . ";dbname=postgres",DB_USER,DB_PASSWORD,[
                    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
                ]);
               $stmt = $pdo->prepare("SELECT 1 FROM pg_database WHERE datname = :dbname");
                $stmt->execute([':dbname' => DB_NAME]);

                  if ($stmt->fetch()) {
                   echo "La base de données ". DB_NAME ." existe déjà.\n";
                  } else {
                 // Création de la base
                  $pdo->exec("CREATE DATABASE ". DB_NAME ."") ;
                  echo "Base de données  ". DB_NAME ." créée avec succès.\n";
                    }
                    $this->pdo = new PDO("pgsql:host=" . DB_HOST . ";port=". DB_PORT . ";dbname=" . DB_NAME,DB_USER,DB_PASSWORD,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $this->driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
                  }
                
            catch(PDOException $e){
                throw $e;

            }

        }
    
        
      }
      private function createTables(){
        
        $sql= match($this->driver){
            'mysql'=>file_get_contents(__DIR__. '/../database/script_mysql.sql'),
            'pgsql'=>file_get_contents(__DIR__. '/../database/script_postgres.sql'),
            default =>throw new Exception('driver non supporter '. $this->driver )


        };
        
        $this->pdo->exec($sql);


      }
}
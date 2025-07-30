<?php

class Seeder
{
    private PDO $pdo;
    private string $driver;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    }

    public function run()
    {
        try {
            $this->seedDatabase(); // $this->insertIntoDB();
            echo "Seed de la base de données réussie.\n";

        } catch (PDOException $e) {
            die("Erreur de seed: " . $e->getMessage());
        }
    }

    private function seedDatabase()
    {
        $sql = match ($this->driver) { 
            'mysql' => file_get_contents(__DIR__ . '/../database/insert_mysql.sql'),
            'pgsql' => file_get_contents(__DIR__ . '/../database/insert_postgres.sql'),
            default => throw new Exception("Driver non supporté: " . $this->driver),
        };
        $this->pdo->exec($sql);
    }

}
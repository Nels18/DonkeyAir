<?php

require_once '_connect.php';

class Database
{
    private static ?Database $instance = null;

    private PDO $pdo;

    private function __construct()
    {
        $this->pdo = new PDO("mysql:host=".DATABASE_HOST.";dbname=".DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASS);
    }

    public static function getInstance(): Database
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    public function query(string $sql, array $params = []): array
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function list(string $tableName): array
    {
        return $this->query('SELECT * FROM '.$tableName);
    }

    public function importMigration(string $name)
    {
        // $this->query("SOURCE ../data/sql/$name;");
        $pass = "";

        if (DATABASE_PASS != '') {
            $pass = '-p'.DATABASE_PASS;
        }

        echo "mysql -h".DATABASE_HOST." -u".DATABASE_USERNAME." $pass ".DATABASE_NAME." < ../data/sql/".$name;
    }
}
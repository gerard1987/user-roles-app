<?php 

class DataProvider
{
    private static $instance = null;

    // Database connection parameters
    private $host = 'localhost';
    private $dbName = 'user-roles-app';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8';
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    private $dbInstance;

    private function __construct()
    {
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbName.';charset='.$this->charset.'';
        $this->dbInstance = new PDO($dsn, $this->user, $this->pass, $this->options);

        $this->initialize();
    }
    
    public static function getInstance() 
    {
        if (self::$instance === null) {
            self::$instance = new DataProvider();
        }
        return self::$instance;
    }

    public function getDbInstance()
    {
        return $this->dbInstance;
    }

    private function initialize()
    {
        $this->createDatabaseIfNotExists();
        $this->createUserTableIfNotExists();
        $this->createAdminIfNotExists();
    }

    private function createDatabaseIfNotExists() 
    {
        try
        {
            // Check if the database exists by executing a simple SQL query
            $stmt = $this->dbInstance->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$this->dbName}'");

            if ($stmt->rowCount() == 0) 
            {
                // Database does not exist, create it
                $sql = "CREATE DATABASE {$this->dbName} CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
                $this->dbInstance->exec($sql);
            }
        } 
        catch (PDOException $e) 
        {
            echo "Error checking/creating database: " . $e->getMessage();
        }
    }

    private function createUserTableIfNotExists()
    {
        try 
        {
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT NOT NULL AUTO_INCREMENT,
                username VARCHAR(50) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(50) NOT NULL,
                PRIMARY KEY (id)
            );";
            
            $this->dbInstance->exec($sql);
        } 
        catch (PDOException $e) {
            echo "Error creating table: " . $e->getMessage();
        }
    }

    private function createAdminIfNotExists()
    {
        try 
        {
            $sql = "INSERT IGNORE INTO users (username, password, role) VALUES ('admin', 'password123', 'admin');";

            $this->dbInstance->exec($sql);
        } 
        catch (PDOException $e) {
            echo "Error inserting admin user : " . $e->getMessage();
        }
    }
}

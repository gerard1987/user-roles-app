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
        // First initialize connection to host
        $dsn = 'mysql:host=' . $this->host . ';charset=' . $this->charset;
        $this->dbInstance = new PDO($dsn, $this->user, $this->pass, $this->options);

        $this->createDatabaseIfNotExists();

        // Now we can operate on the db
        $dsnWithDb = 'mysql:host='.$this->host.';dbname='.$this->dbName.';charset='.$this->charset.'';
        $this->dbInstance = new PDO($dsnWithDb, $this->user, $this->pass, $this->options);

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
        $this->createUserTableIfNotExists();
        $this->createAdminIfNotExists();
        $this->seedUsersIfNotExists();
    }

    private function createDatabaseIfNotExists() 
    {
        try
        {
            $sql = "CREATE DATABASE IF NOT EXISTS `{$this->dbName}`";
            $this->dbInstance->exec($sql);
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

    private function seedUsersIfNotExists()
    {  
        try 
        {
            $sql = "INSERT IGNORE INTO `users` (`username`, `password`, `role`) VALUES
            ('Emily', 'password', 'user'),
            ('Michael', 'mypassword', 'user'),
            ('Sarah', '123456', 'user'),
            ('David', 'qwerty', 'user'),
            ('Laura', 'letmein', 'user'),
            ('James', 'abc123', 'user'),
            ('Jessica', 'password1', 'user'),
            ('Daniel', 'welcome', 'user'),
            ('Rachel', 'pass1234', 'user'),
            ('John', 'secret', 'user');";

            $this->dbInstance->exec($sql);
        } 
        catch (PDOException $e) {
            echo "Error inserting admin user : " . $e->getMessage();
        }
    }
}

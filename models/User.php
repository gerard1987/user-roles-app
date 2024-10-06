<?php

class User 
{
    public $name;
    public $price;

    public function __construct($name, $price) {
        $this->name = $name;
        $this->price = $price;
    }

    public static function create($data) 
    {
        $db = DataProvider::getInstance()->getDbInstance();

        // Prepare the values
        $username = $data['username'];
        $password = $data['password'];
        $role = 'user';

        // Prepare the SQL INSERT statement
        $stmt = $db->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');

        // Bind the parameters
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        // Execute the statement
        return $stmt->execute();
    }   

    public static function all() 
    {
        $db = DataProvider::getInstance()->getDbInstance();
       
        $req = $db->query('SELECT * FROM users');
        return $req->fetchAll(PDO::FETCH_OBJ) ?? null;
    }

    public static function getUser($data) 
    {
        $db = DataProvider::getInstance()->getDbInstance();

        // Prepare the values
        $username = $data['username'];
        $password = $data['password'];
        
        // Prepare query
        $stmt = $db->prepare('SELECT * FROM users WHERE username = :username AND password = :password');

        // Bind parameters
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute(); 
    
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        return $user;
    }    

    public static function edit($data) 
    {
        $db = DataProvider::getInstance()->getDbInstance();
    
        // Prepare the values
        $id = intval($data->id);
        $username = $data->username;
        $password = $data->password;
        $role = $data->role;
    
        // Prepare query
        $stmt = $db->prepare('UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id');
        
        // Bind the parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    
        $succes = $stmt->execute();
        if (!$succes){
            throw new Exception("Couldnt update user");
        }

        return true;
    }
    
    public static function delete(int $id) 
    {
        $db = DataProvider::getInstance()->getDbInstance();
        
        // Prepare query
        $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }    
    
}
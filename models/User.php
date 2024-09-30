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
        $db = new PDO('mysql:host=localhost;dbname=article-app;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the values
        $name = $data['name'];
        $price = floatval($data['price']);

        // Prepare the SQL INSERT statement
        $stmt = $db->prepare('INSERT INTO User (name, price) VALUES (:name, :price)');

        // Bind the parameters
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR); // Use PARAM_STR for floats as well

        // Execute the statement
        return $stmt->execute();
    }   

    public static function all() 
    {
        $db = new PDO('mysql:host=localhost;dbname=article-app;charset=utf8', 'root', '');
       
        $req = $db->query('SELECT * FROM User');
        $User = $req->fetchAll(PDO::FETCH_OBJ);

        return $User;
    }

    public static function getById($id) 
    {
        $db = new PDO('mysql:host=localhost;dbname=article-app;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare query
        $stmt = $db->prepare('SELECT * FROM User WHERE id = :id');

        // Bind parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute(); 
    
        $article = $stmt->fetch(PDO::FETCH_OBJ);

        return $article;
    }    

    public static function edit($data) 
    {
        $db = new PDO('mysql:host=localhost;dbname=article-app;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $id = intval($data['id']);
        $name = $data['name'];
        $price = floatval($data['price']);
    
        // Prepare query
        $stmt = $db->prepare('UPDATE User SET name = :name, price = :price WHERE id = :id');
        
        // Bind parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR); // Bind name
        $stmt->bindParam(':price', $price, PDO::PARAM_STR); // Bind price
    
        $succes = $stmt->execute();
        if (!$succes){
            throw new Exception("Couldnt update article");
        }

        return self::getById($id) ?? null;
    }
    
    public static function delete(int $id) 
    {
        $db = new PDO('mysql:host=localhost;dbname=article-app;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare query
        $stmt = $db->prepare('DELETE FROM User WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }    
    
}
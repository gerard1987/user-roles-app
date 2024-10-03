<?php 

class Session
{
    public static function setsession($data) 
    {
        if (!is_array($data)) {
            throw new InvalidArgumentException('Session data must be an associative array.');
        }

        // Set each session key-value pair
        foreach ($data as $key => $value) 
        {
            $_SESSION[$key] = $value;
        }
    }
    
    public static function getsession($key) 
    {
        return $_SESSION[$key] ?? null;
    }

    public static function clearsession($key) 
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroysession() 
    {
        session_unset();
        session_destroy();
    }
}

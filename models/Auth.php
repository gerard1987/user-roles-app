<?php

class Auth 
{
    public static function isAdmin()
    {
        $user = Session::getsession('Auth')['User'] ?? null;
        return $user?->role == 'admin' ?? false;
    }

    public static function getLoggedInUser()
    {
        return Session::getsession('Auth')['User'] ?? null;
    }
}
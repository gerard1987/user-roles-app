<?php

class Auth 
{
    public static function isAdmin()
    {
        return Session::getsession('Auth')['User']?->role == 'admin' ?? null;
    }

    public static function getLoggedInUser()
    {
        return Session::getsession('Auth')['User'] ?? null;
    }
}
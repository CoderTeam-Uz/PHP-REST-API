<?php

class Database
{
    private static $host = 'host';
    private static $username = 'username';
    private static $password = 'password';
    private static $db_name = 'database';

    static function connect()
    {
        return new PDO("mysql:host=" . Database::$host . ";dbname=" . Database::$db_name, Database::$username, Database::$password);
    }
}
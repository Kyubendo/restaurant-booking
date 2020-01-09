<?php


class DB
{
    public static function getConnection()
    {
        $host = 'localhost';
        $dbname = 'myshema';
        $user = 'root';
        $password = '';
        $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $db;
    }

}
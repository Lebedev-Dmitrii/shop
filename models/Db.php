<?php

//класс для подключения к бд
class Db
{
    
    //устанавливает соединение с бд, возвращает его в виде PDO
    public static function getConnection()
    {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
        

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);
        $db->exec("set names utf8");
        
        return $db;
    }

}

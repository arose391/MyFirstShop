<?php

class Db
{
    //Возвращает PDO statement с установленым соединением БД
    public static function getConnection()
    {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
        $opt = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password'], $opt);

        $db->exec("set names utf8");

        return $db;
    }

}

<?php

//Если класс не был подключен, 
function __autoload($class_name)
{
    //искать в следующих папках проекта
    $array_paths = array(
        '/models/',
        '/components/',
        '/controllers/',
    );

   
    foreach ($array_paths as $path) {

       
        $path = ROOT . $path . $class_name . '.php';

       
        if (is_file($path)) {
            include_once $path;
        }
    }
}

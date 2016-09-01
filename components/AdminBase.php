<?php

//Класс-родитель для АдминКонтроллеров
abstract class AdminBase
{

  //Проверка прав доступа
    public static function checkAdmin()
    {
      
        $userId = User::checkLogged();

        
        $user = User::getUserById($userId);

        
        if ($user['status'] == 'admin') {
            return true;
        }

        
        die('Access denied');
    }

}

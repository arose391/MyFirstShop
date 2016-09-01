<?php

//Управление кабинетом пользователя
class CabinetController
{

  //Страница личного кабинета
    public function actionIndex()
    {
        $userId = User::checkLogged();

        $user = User::getUserById($userId);

        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }

//Обновление персональных данных
    public function actionEdit()
    {
        $userId = User::checkLogged();

        //Сначала получаем данные и вписываем их в формы
        $user = User::getUserById($userId);

        $name = $user['name'];
        $password = $user['password'];

        
        $result = false;

        //Затем переписываем новые
        if (isset($_POST['submit'])) {
            
            $name = $_POST['name'];
            $password = $_POST['password'];
            
            //Флаг ошибок для валидации
            $errors = false;

            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            if ($errors == false) {
                $result = User::edit($userId, $name, $password);
            }
        }

        require_once(ROOT . '/views/cabinet/edit.php');
        return true;
    }

}

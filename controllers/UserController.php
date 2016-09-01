<?php


class UserController
{
    //Вид на форму регистрации
    public function actionRegister()
    {
        
        $name = false;
        $email = false;
        $password = false;
        $result = false;

      
        if (isset($_POST['submit'])) {
        
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

           //Валидация
            $errors = false;

            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }
            
            if ($errors == false) {
               //Создание нового пользователя
                $result = User::register($name, $email, $password);
            }
        }

       
        require_once(ROOT . '/views/user/register.php');
        return true;
    }
    
 //Страница входа в личный кабинет
    public function actionLogin()
    {
       
        $email = false;
        $password = false;
        
        
        if (isset($_POST['submit'])) {
            
            $email = $_POST['email'];
            $password = $_POST['password'];

           //Валидация
            $errors = false;

            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            
            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
              
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                //Записываем ИД пользователя в сессию
                User::auth($userId);

               //Перенаправляем на страницу кабинета
                header("Location: /cabinet");
            }
        }

       
        require_once(ROOT . '/views/user/login.php');
        return true;
    }

    //Выход из аккаунта
    public function actionLogout()
    {
       
        session_start();
        
       
        unset($_SESSION["user"]);
        
      
        header("Location: /");
    }

}

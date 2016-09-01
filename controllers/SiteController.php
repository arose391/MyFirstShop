<?php

//Главная
class SiteController
{

    //Главная вид
    public function actionIndex()
    {
        $categories = Category::getCategoriesList();

        $latestProducts = Product::getLatestProducts(6);

        $sliderProducts = Product::getRecommendedProducts();

        require_once(ROOT . '/views/site/index.php');
        return true;
    }

    //Контакти
    public function actionContact()
    {

        $userEmail = false;
        $userText = false;
        $result = false;

        
        if (isset($_POST['submit'])) {
        
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            $errors = false;

            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Неправильный email';
            }

            if ($errors == false) {
                $adminEmail = 'molodecpal@yandex.ru';
                $message = "Текст: {$userText}. От {$userEmail}";
                $subject = 'Тема письма';
                //$result = mail($adminEmail, $subject, $message);
                $result = true;
            }
        }

        require_once(ROOT . '/views/site/contact.php');
        return true;
    }
    
  
     //Страница "О нас"
    public function actionAbout()
    {
        require_once(ROOT . '/views/site/about.php');
        return true;
    }

}

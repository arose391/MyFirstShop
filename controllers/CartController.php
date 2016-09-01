<?php

//Класс управления корзиной
class CartController {

    //Добавление товаров
    //  public function actionAdd($id)
//    {
//        Cart::addProduct($id);
//
//        $referrer = $_SERVER['HTTP_REFERER'];
//        header("Location: $referrer");
//    }
    //Добавление товаров в корзину с помощью асинхонного запроса
    public function actionAddAjax($id) {
        //Выводит количество товаров в документ асинхронного запроса
        //А с этого документа передаеться в дужки возле иконки корзины
        echo Cart::addProduct($id);
        return true;
    }

    //Удаляет нежелательный продукт с корзины
    public function actionDelete($id) {
        Cart::deleteProduct($id);

        header("Location: /cart");
    }

    //Вид страницы корзины со списком добавленых товаров
    public function actionIndex() {
        //Список категорий
        $categories = Category::getCategoriesList();

        //ИД и количество продуктов
        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            //Получаем информацию по каждом продукто по ИД
            $productsIds = array_keys($productsInCart);


            $products = Product::getProdustsByIds($productsIds);

            //Общая стоимость
            $totalPrice = Cart::getTotalPrice($products);
        }

        require_once(ROOT . '/views/cart/index.php');
        return true;
    }

    //Обормление заказа
    public function actionCheckout() {

        $productsInCart = Cart::getProducts();

        //Если корзина пуста, перенаправляем на главную
        if ($productsInCart == false) {
            header("Location: /");
        }
        //Получение списка категорий
        $categories = Category::getCategoriesList();

        //Вывод общих данных о заказе(цена, количество)
        $productsIds = array_keys($productsInCart);
        $products = Product::getProdustsByIds($productsIds);
        $totalPrice = Cart::getTotalPrice($products);

        $totalQuantity = Cart::countItems();

        //Перемееные для полей о пользователе
        $userName = false;
        $userPhone = false;
        $userComment = false;

        //Флаг успеха операции
        $result = false;

        //Если пользователь зарегистрирован, то поле именни будет заполнено
        if (!User::isGuest()) {

            $userId = User::checkLogged();
            $user = User::getUserById($userId);
            $userName = $user['name'];
        } else {

            $userId = false;
        }


        if (isset($_POST['submit'])) {

            //Получение данных о пользователе
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            //Валидация
            $errors = false;


            if (!User::checkName($userName)) {
                $errors[] = 'Неправильное имя';
            }
            if (!User::checkPhone($userPhone)) {
                $errors[] = 'Неправильный телефон';
            }


            if ($errors == false) {

                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                //Если все ОК, отправляем Email админу, очищаем корзину
                if ($result) {

//                    $adminEmail = 'molodecpal@yandex.ru';
//                    $message = '<a href="">Список заказов</a>';
//                    $subject = 'Новый заказ!';
//                    mail($adminEmail, $subject, $message);


                    Cart::clear();
                }
            }
        }


        require_once(ROOT . '/views/cart/checkout.php');
        return true;
    }

}

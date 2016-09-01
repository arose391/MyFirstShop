<?php


class Cart
{

   //Добавляет продукты в корзину, записывая их в сессию,
    //Если продукт уже есть в корзине, увеличивает на +1.
    //Возвращает количиство товаров в корзине
    public static function addProduct($id)
    {
       
        $id = intval($id);

        
        $productsInCart = array();

        if (isset($_SESSION['products'])) {
        
            $productsInCart = $_SESSION['products'];
        }

  
        if (array_key_exists($id, $productsInCart)) {
          
            $productsInCart[$id] ++;
        } else {
           
            $productsInCart[$id] = 1;
        }

       
        $_SESSION['products'] = $productsInCart;

   
        return self::countItems();
    }

    
    //Считает продукты в корзине(для вывода возле иконки корзины)
    public static function countItems()
    {
        
        if (isset($_SESSION['products'])) {
            
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            
            return 0;
        }
    }

    //Для отображения таблицы продуктов на странице корзины
    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

   //Общая стоимость покупок
    public static function getTotalPrice($products)
    {
       
        $productsInCart = self::getProducts();

        
        $total = 0;
        if ($productsInCart) {
          
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }

        return $total;
    }

    //Очищает корзину.
    public static function clear()
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

  //Удаляет нежелательный продукт с корзины
    public static function deleteProduct($id)
    {
        
        $productsInCart = self::getProducts();

        unset($productsInCart[$id]);

        $_SESSION['products'] = $productsInCart;
    }

}

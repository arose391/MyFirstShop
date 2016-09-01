<?php

//Просмотр страницы о отдельном продукте
class ProductController
{

    
    public function actionView($productId)
    {
        $categories = Category::getCategoriesList();

        $product = Product::getProductById($productId);

        require_once(ROOT . '/views/product/view.php');
        return true;
    }

}

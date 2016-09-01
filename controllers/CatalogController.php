<?php


class CatalogController
{

   //Страница каталога
    public function actionIndex()
    {
        //Лист категорий
        $categories = Category::getCategoriesList();

        //Последние 12 продуктов
        $latestProducts = Product::getLatestProducts(12);

        require_once(ROOT . '/views/catalog/index.php');
        return true;
    }

    //Страница отдельной катогории
    public function actionCategory($categoryId, $page = 1)
    {
        
        //Лист категорий
        $categories = Category::getCategoriesList();

        //Получение продуктов из категории
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        //Из общее количество 
        $total = Product::getTotalProductsInCategory($categoryId);

        //Класс пейджера
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        require_once(ROOT . '/views/catalog/category.php');
        return true;
    }

}

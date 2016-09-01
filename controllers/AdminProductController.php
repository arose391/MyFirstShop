<?php

//КРУД продуктов
class AdminProductController extends AdminBase
{

   //Список всех продуктов
    public function actionIndex()
    {
        self::checkAdmin();

        $productsList = Product::getProductsList();

        require_once(ROOT . '/views/admin_product/index.php');
        return true;
    }

    
    public function actionCreate()
    {
        self::checkAdmin();

        $categoriesList = Category::getCategoriesListAdmin();

        if (isset($_POST['submit'])) {
         
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            //Флаг ошибок
            $errors = false;
           
            //Валидация формы по имени
            if (!isset($options['name']) || empty($options['name'])) {
                $errors[] = 'Заполните поля';
            }

            if ($errors == false) {
              
                $id = Product::createProduct($options);

                if ($id) {
                    //Если был передан файл изображения, из временного хранилища переносим его в постоянное
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$id}.jpg");
                    }
                };

              //Если продукт был успешно добавлен, возвращаем пользователя назад
               if ($id) { header("Location: /admin/product");}
            }
        }

        require_once(ROOT . '/views/admin_product/create.php');
        return true;
    }

   //То же что и создание продукта, только поля уже заполнены данными
    public function actionUpdate($id)
    {
        self::checkAdmin();

        $categoriesList = Category::getCategoriesListAdmin();

        $product = Product::getProductById($id);

        if (isset($_POST['submit'])) {
            
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            if ($res = Product::updateProductById($id, $options)) {


                
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

                  
                   move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$id}.jpg");
                }
            }

            
           if ($res) {  header("Location: /admin/product");}
        }

       
        require_once(ROOT . '/views/admin_product/update.php');
        return true;
    }

   
    public function actionDelete($id)
    {
        self::checkAdmin();

        if (isset($_POST['submit'])) {
            
            Product::deleteProductById($id);

          
            header("Location: /admin/product");
        }

        
        require_once(ROOT . '/views/admin_product/delete.php');
        return true;
    }

}

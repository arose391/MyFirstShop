<?php

//Класс управления категориями
class AdminCategoryController extends AdminBase
{

    //Вид на все категории и КРУД действия
    public function actionIndex()
    {
       
        self::checkAdmin();

        $categoriesList = Category::getCategoriesListAdmin();

        require_once(ROOT . '/views/admin_category/index.php');
        return true;
    }

    //Создаем категорию
    public function actionCreate()
    {
        self::checkAdmin();

        if (isset($_POST['submit'])) {
           
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

           
            $errors = false;

           
            if (!isset($name) || empty($name)) {
                $errors[] = 'Заполните поля';
            }


            if ($errors == false) {
               
                Category::createCategory($name, $sortOrder, $status);

                
                header("Location: /admin/category");
            }
        }

        require_once(ROOT . '/views/admin_category/create.php');
        return true;
    }

    //Обновление категории(поля уже заполнены старыми данными)
    public function actionUpdate($id)
    {
        self::checkAdmin();

        $category = Category::getCategoryById($id);

        if (isset($_POST['submit'])) {
           
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            
            Category::updateCategoryById($id, $name, $sortOrder, $status);

         
            header("Location: /admin/category");
        }

       
        require_once(ROOT . '/views/admin_category/update.php');
        return true;
    }

   //Удаление
    public function actionDelete($id)
    {
        
        self::checkAdmin();

      
        if (isset($_POST['submit'])) {
            
            Category::deleteCategoryById($id);

            
            header("Location: /admin/category");
        }

        require_once(ROOT . '/views/admin_category/delete.php');
        return true;
    }

}

<?php


class Router
{

    
    private $routes;

   //Подключаем файл путей юри=>контроллер/экшн
    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';

        $this->routes = include($routesPath);
    }

   //Получаем ЮРИ
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

  
    public function run()
    {
        $uri = $this->getURI();

        //Ищем в URI паттерн из роутов
        foreach ($this->routes as $uriPattern => $path) {

            //если есть совпадения
            if (preg_match("~$uriPattern~", $uri)) {

                //Делаем ЧПУ
                //Ищем $uriPattern в $uri, если есть подмаски, подставляем их в $path                
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);


                //Первые два параметра определяют контроллер и экшн, дальше идут параметры.
                $segments = explode('/', $internalRoute);
                
                //Формируем имя контроллера и экшна.
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));

                $parameters = $segments;

                $controllerFile = ROOT . '/controllers/' .
                        $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                $controllerObject = new $controllerName;

               //Вызываем метод $actionName обьекта $controllerObjectб с параметрами $parameters.
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) {
                    break;
                }
            }
        }
    }

}

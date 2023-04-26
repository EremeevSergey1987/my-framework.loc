<?php
 namespace wfm;

 class Router
 {
     protected static array $routes = [];
     protected static array $route = [];

     public static function add($regxp, $route = [])
     {
         self::$routes[$regxp] = $route;
     }

     public static function getRoutes(): array
     {
         return self::$routes;
     }

     public static function getRoute(): array
     {
         return self::$route;
     }

     protected static function removeQueryString($url)
     {
         if($url){
             $params = explode('&', $url, 2);
             if (false === str_contains($params[0], '=')){
                  return rtrim($params[0], '/');
             }
         }
         return '';
     }

     public static function dispatch($url)
     {
         $url = self::removeQueryString($url);
         if (self::matchRoute($url)) {
             echo $controller = 'app\controllers\\' . self::$route['admin_prefix'] . self::$route['controller'] . 'Controller';
             if(class_exists($controller)){
                 $controllerObject = new $controller(self::$route);
                 $action = self::loverCamelCase(self::$route['action'] . 'Action');
                 if(method_exists($controllerObject, $action)){
                     $controllerObject->$action();

                 } else {
                     throw new \Exception("Метод {$controller}::{$action} не найден", 404);
                 }

             } else {
                 throw new \Exception("Контроллер {$controller} не найден", 404);
             }
         } else {
             throw new \Exception("Страница не найдена", 404);
         }
     }

     public static function matchRoute($url): bool
     {
         foreach (self::$routes as $pattern => $route ){


             if (preg_match("#{$pattern}#", $url, $matches)) {
                 print_r($matches);
                 foreach ($matches as $k => $v){
                     if (is_string($k)){
                         $route[$k] = $v;
                     }
                 }
                 if(empty($route['action'])){
                     $route['action'] = 'index';
                 }
                 if(!isset($route['admin_prefix'])){
                     $route['admin_prefix'] = '';
                 } else {
                     $route['admin_prefix'] .= '\\';
                 }

                 $route['controller'] = self::upperCamelCase($route['controller']);
                 self::$route = $route;

                 return true;
             }
         }
         return false;
     }

     protected static function upperCamelCase($name): string
     {
         return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
     }

     protected static function loverCamelCase($name): string
     {
         return lcfirst(self::upperCamelCase($name));
     }
 }
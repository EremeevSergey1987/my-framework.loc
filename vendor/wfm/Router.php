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


     public static function dispatch($url)
     {
         if (self::matchRoute($url)) {
             echo 'OK';
         } else {
             echo 'NO';
         }
     }

     public static function matchRoute($url): bool
     {
         foreach (self::$routes as $pattern => $route ){

             print_r($url);
             echo '<br/>';
             print_r($pattern);
             echo '<br/>';

             if (preg_match("#{$pattern}#", $url, $matches)) {
                 return true;
             }
         }
         return false;
     }
 }
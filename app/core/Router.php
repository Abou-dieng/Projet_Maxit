<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function addRoute($method, $path, $controller, $action)
    {
        $this->routes[$method][$path] = [
            'controller' => $controller,
            'action' => $action
        ];
    }

    public static function resolve($routes)
    {
            
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        // Normalisation de l'URI : suppression du slash final sauf pour la racine
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }
        $method = $_SERVER['REQUEST_METHOD'];

        $route = $routes[$uri] ?? null;
        if (!$route) {
            http_response_code(404);
            header("Location: /error/404");
            exit;
        }
        $midellewares = require __DIR__.'/../config/middlewares.php';
         // 
        // empty verifie si cest vide 
         if ( !empty($route['midellewares'])){
           
            foreach($route['midellewares']as $midelleware){
                // dd($midellewares);
                // il recupere le nom 
                $midellewareclassName=$midellewares[$midelleware];
            
                $midellewareInstance=new $midellewareclassName();
                   
                $midellewareInstance();
                           
             
                if (is_callable($midellewareInstance)){
                     $midellewareInstance();
                }


            }
         }

        $controllerName = $route['controller'];
        $action = $route['action'];

        if (!class_exists($controllerName) || !method_exists($controllerName, $action)) {
            http_response_code(404);
            header("Location: /error/404");
            exit;
        }

        $controller = new $controllerName();
         $controller->$action();
    }
}

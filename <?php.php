<?php
namespace App\core;
class Router{
  public static function resolver(){
    $route = require __DIR__.'/../../routes/route.web.php';
    $uri =parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH) ;
     if($route[$uri]){
       $controllerName = $route[$uri]['controller'];
       $controllerAction = $route[$uri]['action'];
       $controller = new $controllerName();
       $controller->$controllerAction();
     }
     else{
      echo '404';
     }
  }
}
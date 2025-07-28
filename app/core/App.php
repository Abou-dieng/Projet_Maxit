<?php 
namespace App\Core;

use Symfony\Component\Yaml\Yaml;

class  App{
    private static array $instancies=[

        // 'Session' => object

    ];

    public  static function  getDependency(string $name){
     //  $deps=require __DIR__. '/../config/dependencies.php';
      $deps=Yaml::parseFile(__DIR__.'/../config/service.yml');


       if(array_key_exists($name,self::$instancies)){
        //dd($name,$instancies);
        return self::$instancies[$name];
       }
       
       foreach($deps as $group){

           if(isset($group[$name])){
                $className=$group[$name];

                if(class_exists($className)){
                   $instance=$className::getInstance();

                    if ($instance){
                        self::$instancies[$name] = $instance;
                        return $instance;
                    }
                }

            }

       }
       return null;




    }
}


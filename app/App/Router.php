<?php

namespace Mahatech\AlindoExpress\App;
class Router{
    private static array $routes;

    // function membuat alur
    public static function add(string $method, string $path, string $controller, string $function){
        self::$routes[] = [
            "method" => $method,
            "path" => $path,
            "controller" => $controller,
            "function" => $function
        ];
    }

    //function menjalankan route
    public static function run(){
        // define default path
        $path = "/";
        // define default method
        $method = $_SERVER['REQUEST_METHOD'];

        //cek path info
        if(isset($_SERVER['PATH_INFO'])){
            $path = $_SERVER['PATH_INFO'];
        }

        // looping setiap data yang ada dalam array routes
        foreach(self::$routes as $route){
            if($route['path'] == $path && $route['method'] == $method){
                echo "PATH ADA DI DALAM ROUTE";
                return;
            }
        }


        //jika tidak ada dalam route
        http_response_code(404);
        echo "CONTROLLER NOT FOUND";

    }
}
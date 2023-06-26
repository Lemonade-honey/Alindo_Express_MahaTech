<?php

namespace Mahatech\AlindoExpress\App;
class Router{
    private static array $routes;

    // function membuat alur
    public static function add(string $method, string $path, string $controller, string $function, ?array $middleware = []){
        self::$routes[] = [
            "method" => $method,
            "path" => $path,
            "controller" => $controller,
            "function" => $function,
            "middleware" => $middleware
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
            $pattern = "#^" . $route['path'] . "$#";
            if(preg_match($pattern, $path, $variabels) && $route['method'] == $method){
                // echo "PATH ADA DI DALAM ROUTE";

                // run middleware
                foreach($route['middleware'] as $middleware){
                    $interface = new $middleware;
                    $interface->before();
                }

                $controller = new $route['controller'];
                $function = $route['function'];

                // hapus data array kecocokan di index 0
                array_shift($variabels);
                call_user_func_array([$controller, $function], $variabels);
                return;
            }
        }


        //jika tidak ada dalam route
        http_response_code(404);
        echo "CONTROLLER NOT FOUND";

    }
}
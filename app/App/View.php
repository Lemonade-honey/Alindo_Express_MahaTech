<?php
namespace Mahatech\AlindoExpress\App;
class View{
    public static function render(string $targetRender, ?array $response = []){
        define('ROOT', 'http://localhost:8080');
        // define('ROOT', 'http://192.168.1.7:8080');
        require(__DIR__ . "/../View/" . $targetRender . ".php");
    }

    public static function redirect(string $targetRedirect){
        header('location: ' . $targetRedirect);
        exit();
    }
}
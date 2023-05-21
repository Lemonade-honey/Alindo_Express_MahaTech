<?php
namespace Mahatech\AlindoExpress\App;
class View{
    public static function render(string $targetRender){
        define('ROOT', 'http://localhost:8080');
        require(__DIR__ . "/../View/" . $targetRender . ".php");
    }

    public static function redirect(string $targetRedirect){
        header('location: ' . $targetRedirect);
        exit();
    }
}
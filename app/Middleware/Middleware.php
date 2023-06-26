<?php
namespace Mahatech\AlindoExpress\Middleware;
interface Middleware{
    public function before(): void;
}
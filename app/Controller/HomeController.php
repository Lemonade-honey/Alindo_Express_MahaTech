<?php

namespace Mahatech\AlindoExpress\Controller;

use Mahatech\AlindoExpress\App\View;

class HomeController{
    // Home Page
    public function index(){
        View::render('Home/home');
    }
}
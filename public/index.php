<?php

use Mahatech\AlindoExpress\App\Router;

require_once (__DIR__ . "/../vendor/autoload.php");

// Add Route
Router::add('GET', '/', 'HomeController_Class', 'homeFunction');

// RUN All Route
Router::run();
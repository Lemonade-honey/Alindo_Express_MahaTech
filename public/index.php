<?php

use Mahatech\AlindoExpress\App\Router;
use Mahatech\AlindoExpress\Controller\PaketController;

require_once (__DIR__ . "/../vendor/autoload.php");

// Add Route
Router::add('GET', '/', PaketController::class, 'tambahPaket');

// RUN All Route
Router::run();
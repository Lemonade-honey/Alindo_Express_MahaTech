<?php

use Mahatech\AlindoExpress\App\Router;
use Mahatech\AlindoExpress\Controller\PaketController;

require_once (__DIR__ . "/../vendor/autoload.php");

// Add Route
Router::add('GET', '/', PaketController::class, 'tambahPaket');
Router::add('POST', '/', PaketController::class, 'postTambahPaket');

Router::add('GET', '/detail-paket/([0-9]*)', PaketController::class, 'detailPaket');
Router::add('GET', '/detail', PaketController::class, 'test');

// RUN All Route
Router::run();
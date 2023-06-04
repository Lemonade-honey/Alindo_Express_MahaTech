<?php

use Mahatech\AlindoExpress\App\Router;
use Mahatech\AlindoExpress\Controller\HomeController;
use Mahatech\AlindoExpress\Controller\PaketController;

require_once (__DIR__ . "/../vendor/autoload.php");

// home page
Router::add('GET', '/', HomeController::class, 'index');

// Add Paket
Router::add('GET', '/paket', PaketController::class, 'listPaket');

Router::add('GET', '/paket/register', PaketController::class, 'tambahPaket');
Router::add('POST', '/paket/register', PaketController::class, 'postTambahPaket');

// Paket Detail
Router::add('GET', '/paket/detail-paket/([0-9]*)', PaketController::class, 'detailPaket');

// Paket Vendor
Router::add('GET', '/paket/detail-paket/([0-9]*)/vendor', PaketController::class, 'vendorPaket');
Router::add('POST', '/paket/detail-paket/([0-9]*)/vendor', PaketController::class, 'postVendorPaket');


// RUN All Route
Router::run();
<?php

use Mahatech\AlindoExpress\App\Router;
use Mahatech\AlindoExpress\Controller\PaketController;

require_once (__DIR__ . "/../vendor/autoload.php");

// Add Route
Router::add('GET', '/', PaketController::class, 'tambahPaket');
Router::add('POST', '/', PaketController::class, 'postTambahPaket');

// Paket Detail
Router::add('GET', '/detail-paket/([0-9]*)', PaketController::class, 'detailPaket');

// Paket Vendor
Router::add('GET', '/detail-paket/([0-9]*)/vendor', PaketController::class, 'vendorPaket');
Router::add('POST', '/detail-paket/([0-9]*)/vendor', PaketController::class, 'postVendorPaket');

// RUN All Route
Router::run();
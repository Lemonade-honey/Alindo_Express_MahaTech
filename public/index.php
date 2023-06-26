<?php

use Mahatech\AlindoExpress\App\Router;
use Mahatech\AlindoExpress\Controller\HomeController;
use Mahatech\AlindoExpress\Controller\LaporanController;
use Mahatech\AlindoExpress\Controller\PaketController;
use Mahatech\AlindoExpress\Middleware\Mustlogin;

require_once (__DIR__ . "/../vendor/autoload.php");

// home page
Router::add('GET', '/', HomeController::class, 'index');

// Add Paket
Router::add('GET', '/paket', PaketController::class, 'listPaket', [Mustlogin::class]);

Router::add('GET', '/paket/register', PaketController::class, 'tambahPaket', [Mustlogin::class]);
Router::add('POST', '/paket/register', PaketController::class, 'postTambahPaket', [Mustlogin::class]);

// Paket Detail
Router::add('GET', '/paket/detail-paket/([0-9]*)', PaketController::class, 'detailPaket', [Mustlogin::class]);

// Paket Vendor
Router::add('GET', '/paket/detail-paket/([0-9]*)/vendor', PaketController::class, 'vendorPaket', [Mustlogin::class]);
Router::add('POST', '/paket/detail-paket/([0-9]*)/vendor', PaketController::class, 'postVendorPaket', [Mustlogin::class]);

// Laporan
Router::add('GET', '/laporan', LaporanController::class, 'index', [Mustlogin::class]);
Router::add('GET', '/laporan/([0-9-]*)', LaporanController::class, 'detail', [Mustlogin::class]);
Router::add('GET', '/laporan/([0-9-]*)/download', LaporanController::class, 'detailDownload', [Mustlogin::class]);

// RUN All Route
Router::run();
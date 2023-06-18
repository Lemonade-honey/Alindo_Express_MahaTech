<?php

namespace Mahatech\AlindoExpress\Controller;

use Mahatech\AlindoExpress\App\View;
use Mahatech\AlindoExpress\Config\Database;
use Mahatech\AlindoExpress\Repository\PaketRepository;
use Mahatech\AlindoExpress\Service\PaketService;

class LaporanController{

    private PaketService $paketService;
    public function __construct() {
        $paketRepo = new PaketRepository(Database::getConnection());
        $this->paketService = new PaketService($paketRepo);
    }
    public function index(){
        $response = $this->paketService->listPaket();
        View::render('Laporan/laporan', $response);
    }

    public function detail(string $tanggalTarget){
        if($this->paketService->listPaketByTanggal($tanggalTarget) != null){
            $response = [
                'target' => $tanggalTarget,
                'response-data' => $this->paketService->listPaketByTanggal($tanggalTarget)
            ];
            View::render('Laporan/laporan', $response);
        }
    }
}
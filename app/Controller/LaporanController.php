<?php

namespace Mahatech\AlindoExpress\Controller;

use Mahatech\AlindoExpress\App\View;
use Mahatech\AlindoExpress\Config\Database;
use Mahatech\AlindoExpress\Repository\PaketRepository;
use Mahatech\AlindoExpress\Service\LaporanService;
use Mahatech\AlindoExpress\Service\PaketService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanController{

    private PaketService $paketService;
    private LaporanService $laporanService;
    public function __construct() {
        $paketRepo = new PaketRepository(Database::getConnection());
        $this->paketService = new PaketService($paketRepo);
        $this->laporanService = new LaporanService();
    }

    /**
     * GET Laporan List 
     */
    public function index(): void{
        $response = $this->paketService->listPaket();
        View::render('Laporan/laporan', $response);
    }

    /**
     * GET Detail Laporan
     */
    public function detail(string $tanggalTarget): void{
        try{
            if($this->paketService->listPaketByTanggal($tanggalTarget) != null){
                $response = [
                    'target' => $tanggalTarget,
                    'response-data' => $this->paketService->listPaketByTanggal($tanggalTarget)
                ];
                View::render('Laporan/laporan', $response);
            }else{
                $response = null;
            }
        } catch(\Exception $ex){
            die($ex->getMessage());
        }
    }

    /**
     * GET Download Detail Laporan
     * 
     * memanggil fungsi download
     */
    public function detailDownload(string $tanggalTarget): void{
        try {
            $this->laporanService->download($this->paketService->listPaketByTanggal($tanggalTarget), $tanggalTarget);
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }
}
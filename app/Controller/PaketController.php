<?php

namespace Mahatech\AlindoExpress\Controller;

use Mahatech\AlindoExpress\App\View;
use Mahatech\AlindoExpress\Config\Database;
use Mahatech\AlindoExpress\Model\Paket\PaketRegisterRequest;
use Mahatech\AlindoExpress\Model\Vendor\VendorPaketRegisterRequest;
use Mahatech\AlindoExpress\Repository\PaketRepository;
use Mahatech\AlindoExpress\Service\PaketService;

class PaketController{

    private PaketService $paketService;

    public function __construct() {
        $connection = Database::getConnection();
        $paketRepository = new PaketRepository($connection);
        $this->paketService = new PaketService($paketRepository);
    }

    public function listPaket(){
        View::render('Paket/list-invoice', [
            'response-paket' => $this->paketService->listPaket()
        ]);
    }

    public function tambahPaket(){
        View::render('Paket/invoice-paket');
    }

    public function postTambahPaket(){
        $request = new PaketRegisterRequest;
        $request->kotaAsal = $_POST['kota-asal'];
        $request->kotaTujuan = $_POST['kota-tujuan'];
        $request->jumlahKoli = $_POST['jumlah-koli'];
        $request->hargaPerKilo = $_POST['harga-kg'];
        $request->berat = $_POST['berat'];
        $request->beratVolume = $_POST['berat-volume'];
        $request->kategori = $_POST['kategori-barang'];
        $request->pemeriksaan = $_POST['status_periksa'];
        $request->namaPengirim = $_POST['nama-pengirim'];
        $request->hpPengirim = $_POST['no-HP-pengirim'];
        $request->namaPenerima = $_POST['nama-penerima'];
        $request->alamatPenerima = $_POST['alamat-tujuan'];
        $request->hpPenerima = $_POST['no-HP-penerima'];
        $request->biayaKirim = $_POST['biaya-kirim'];
        if(isset($_POST['keterangan'])){
            $request->keteranganBiayaLainnya = $_POST['keterangan'];
        }
        if(isset($_POST['harga'])){
            $request->hargaBiayaLainnya = $_POST['harga'];
        }
        $request->totalBiaya = $_POST['total_harga'];

        // Karyawan
        $request->karyawanProfile = 'Daffa Manual';

        try {
            $response = $this->paketService->tambahPaket($request);
            //jika tidak ada error response
            View::redirect('/detail-paket/' . $response->kodeResi);
        } catch (\Exception $ex) {
            View::render('Paket/invoice-paket', [
                'error' => $ex->getMessage()
            ]);
        }
    }

    public function detailPaket(string $kodeResi){
        try{
            View::render('Paket/detail-paket', [
                'response-paket' => $this->paketService->detailPaket($kodeResi)
            ]);
        } catch(\Exception $ex){
            die($ex->getMessage());
        }
    }

    /**
     * GET VENDOR PAKET
     * 
     * Menampilkan data vendor pada target invoice/paket
     */
    public function vendorPaket(string $kodeResi){
        try{
            View::render('Paket/vendor-paket', [
                'response-paket' => $this->paketService->detailPaket($kodeResi)
            ]);
        } catch (\Exception $ex){
            die($ex->getMessage());
        }
    }

    /**
     * POST VENDOR PAKET
     * 
     * Menambahkan data Vendor pada target invoice/paket
     */
    public function postVendorPaket(string $kodeResi){
        $request = new VendorPaketRegisterRequest;
        $request->namaVendor = $_POST['nama'];
        $request->kotaVendor = $_POST['kota'];
        $request->hargaVendor = $_POST['harga'];
        try{
            $this->paketService->tambahVendor($request, $kodeResi);
            View::redirect('/paket/detail-paket/' . $kodeResi);
        } catch(\Exception $ex){
            die($ex->getMessage());
        }
    }
}
<?php

namespace Mahatech\AlindoExpress\Controller;

use Mahatech\AlindoExpress\App\View;
use Mahatech\AlindoExpress\Config\Database;
use Mahatech\AlindoExpress\Model\Paket\PaketRegisterRequest;
use Mahatech\AlindoExpress\Repository\PaketRepository;
use Mahatech\AlindoExpress\Service\PaketService;

class PaketController{

    private PaketService $paketService;

    public function __construct() {
        $connection = Database::getConnection();
        $paketRepository = new PaketRepository($connection);
        $this->paketService = new PaketService($paketRepository);
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
        $request->keteranganBiayaLainnya = $_POST['keterangan'];
        $request->hargaBiayaLainnya = $_POST['harga'];
        $request->totalBiaya = $_POST['total_harga'];

        // Karyawan
        $request->karyawanProfile = 'Daffa Manual';

        try {
            $this->paketService->tambahPaket($request);
            //jika tidak ada error response
            View::redirect('google.com');
        } catch (\Exception $ex) {
            View::render('Paket/invoice-paket', [
                'error' => $ex->getMessage()
            ]);
        }
    }
}
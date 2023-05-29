<?php

namespace Mahatech\AlindoExpress\Service;

use Mahatech\AlindoExpress\Config\Database;
use Mahatech\AlindoExpress\Domain\Paket;
use Mahatech\AlindoExpress\Model\Paket\PaketRegisterRequest;
use Mahatech\AlindoExpress\Repository\PaketRepository;

class PaketService{
    private PaketRepository $paketRepository;

    public function __construct($paketRepository) {
        $this->paketRepository = $paketRepository;
    }

    public function tambahPaket(PaketRegisterRequest $request){
        $this->tambahPaketValidation($request);

        date_default_timezone_set("Asia/Jakarta");
        $dataPaket = [
            "kota_asal" => $request->kotaAsal,
            "kota_tujuan" => $request->kotaTujuan,
            "jumlah_koli" => $request->jumlahKoli,
            "berat" => $request->berat,
            "berat_volume" => $request->beratVolume,
            "harga_kilo" => $request->hargaPerKilo,
            "kategori" => $request->kategori,
            "periksa" => $request->pemeriksaan,
            "nama_pengirim" => $request->namaPengirim,
            "hp_pengirim" => $request->hpPengirim,
            "nama_penerima" => $request->namaPenerima,
            "alamat_penerima" => $request->alamatPenerima,
            "hp_penerima" => $request->hpPenerima
           ];

        $biayaPaket = [
            "biaya_kirim" => $request->biayaKirim,
        ];

        $vendorPaket = null;

        $riwayatPaket = [
            "Action" => "Create",
            "Massage" => date("d M Y, H:i:s") . " by " . "nama orang"
        ];

        try {

            Database::beginTransaction();

            $paket = new Paket;
            $paket->kodeResi = 123;
            $paket->tanggalPembuatan = date("Y/m/d H:i:s");
            $paket->dataPaket = serialize($dataPaket);
            $paket->biayaPaket = serialize($biayaPaket);
            $paket->vendorPaket = serialize($vendorPaket);
            $paket->riwayatPaket = serialize($riwayatPaket);

            $this->paketRepository->save($paket);

            Database::commitTransaction();
        }catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    // Validate Form Input
    private function tambahPaketValidation(PaketRegisterRequest $request){
        // Validate type is not String
        // if(is_string($request->berat) && is_string($request->beratVolume) && is_string($request->biayaKirim) && is_string($request->hargaPerKilo) && is_string($request->jumlahKoli) &&  is_string($request->hpPenerima) && is_string($request->hpPengirim) && is_string($request->totalBiaya)){
        //     throw new \Exception('Invalid type data, harus number');
        // }

        // Kota Asal
        if($request->kotaAsal == null || $request->kotaAsal == ''){
            throw new \Exception('Inputan Kota Asal tidak boleh Null atau Kosong');
        }

        // Kota Tujuan
        if($request->kotaTujuan == null || $request->kotaTujuan == ''){
            throw new \Exception('Inputan Kota Tujuan tidak boleh Null atau Kosong');
        }

        // Jumlah Koli
        if($request->jumlahKoli == null || $request->jumlahKoli == 0){
            throw new \Exception('Inputan Jumlah Koli tidak boleh Null atau Kosong');
        }

        // Harga perkilo
        if($request->hargaPerKilo == null || $request->hargaPerKilo == 0){
            throw new \Exception('Inputan Harga/Kilo tidak boleh Null atau Kosong');
        }

        // Berat Paket
        if($request->berat == null || $request->berat == 0){
            throw new \Exception('Inputan Berat tidak boleh Null atau Kosong');
        }
        
        // Berat Volume
        if($request->beratVolume == null || $request->beratVolume == 0){
            throw new \Exception('Inputan Berat Volume tidak boleh Null atau Kosong');
        }

        // Kategori
        if($request->kategori == null || $request->kategori == ''){
            throw new \Exception('Inputan Kategori tidak boleh Null atau Kosong');
        }

        // Pemeriksaan
        if($request->pemeriksaan == null){
            throw new \Exception('Inputan Pemeriksaan tidak boleh Null atau Kosong');
        }

        // nama pengirim
        if($request->namaPengirim == null || $request->namaPengirim == '' ){
            throw new \Exception('Inputan Nama Pengirim tidak boleh Null atau Kosong');
        }
        
        // HP Penerima
        if($request->hpPengirim == null || $request->hpPengirim == 0 ){
            throw new \Exception('Inputan HP Pengirim tidak boleh Null atau Kosong');
        }

        // nama penerima
        if($request->namaPenerima == null || $request->namaPenerima == '' ){
            throw new \Exception('Inputan Nama Penerima tidak boleh Null atau Kosong');
        }
        
        // alamat penerima
        if($request->alamatPenerima == null || $request->alamatPenerima == '' ){
            throw new \Exception('Inputan Alamat Penerima tidak boleh Null atau Kosong');
        }
        
        // HP Penerima
        if($request->hpPenerima == null || $request->hpPenerima == 0 ){
            throw new \Exception('Inputan HP Penerima tidak boleh Null atau Kosong');
        }
        
        // Biaya Kirim
        if($request->biayaKirim == null || $request->biayaKirim == 0 ){
            throw new \Exception('Inputan Biaya Kirim tidak boleh Null atau Kosong');
        }

        // Biaya Lainnya
        // if($request->biayaLainnya == null || $request->biayaLainnya == '' ){
        //     $request->biayaLainnya = null;
        // }
        
        // Total Biaya
        if($request->totalBiaya == null || $request->totalBiaya == 0 ){
            throw new \Exception('Inputan Biaya Total tidak boleh Null atau Kosong');
        }
        
    }
}
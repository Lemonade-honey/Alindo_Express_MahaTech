<?php

namespace Mahatech\AlindoExpress\Service;

use Mahatech\AlindoExpress\Config\Database;
use Mahatech\AlindoExpress\Config\DotEnv;
use Mahatech\AlindoExpress\Domain\Paket;
use Mahatech\AlindoExpress\Model\Paket\PaketRegisterRequest;
use Mahatech\AlindoExpress\Model\Paket\PaketRegisterResponse;
use Mahatech\AlindoExpress\Model\Vendor\VendorPaketRegisterRequest;
use Mahatech\AlindoExpress\Repository\PaketRepository;

class PaketService{
    private PaketRepository $paketRepository;

    public function __construct($paketRepository) {
        $this->paketRepository = $paketRepository;
    }

    public function tambahPaket(PaketRegisterRequest $request): PaketRegisterResponse{
        $this->tambahPaketValidation($request);

        DotEnv::set_default_timezone();
        // date_default_timezone_set("Asia/Jakarta");
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
            "biaya_lainnya" => $this->biayaLainnya($request),
            "biaya_total" => $request->totalBiaya
        ];

        $updatePaket = [
            "Create Invoice => " . " nama orang [" . date('H:i, d M Y') . "]"
        ];

        try {

            Database::beginTransaction();
            Repeat:

            $paket = new Paket;
            $paket->kodeResi = $this->generateKodeResi();
            $paket->tanggalPembuatan = date("Y/m/d H:i:s");
            $paket->dataPaket = serialize($dataPaket);
            $paket->biayaPaket = serialize($biayaPaket);
            $paket->updatePaket = serialize($updatePaket);

            if(!$this->paketRepository->checkKodeResiInDatabase($paket->kodeResi)){
                // save to Database
                $this->paketRepository->save($paket);
                $response = new PaketRegisterResponse;
                $response->kodeResi = $paket->kodeResi;
                Database::commitTransaction();
                return $response;
            }else{
                // naik ke atas untuk ulangi program
                goto Repeat;
            }

        }catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    // Validate Form Input
    private function tambahPaketValidation(PaketRegisterRequest $request){

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
        
        // Total Biaya
        if($request->totalBiaya == null || $request->totalBiaya == 0 ){
            throw new \Exception('Inputan Biaya Total tidak boleh Null atau Kosong');
        }
        
    }

    /**
     * CONFIG BIAYA LAINNYA
     * 
     * return berupa string gabungan dari keterangan dan harga
     */
    private function biayaLainnya(PaketRegisterRequest $request): ?array{
        if($request->keteranganBiayaLainnya == null || $request->keteranganBiayaLainnya == '' && $request->hargaBiayaLainnya == null || $request->hargaBiayaLainnya == ''){
            return null;
        }else{
            if(count($request->keteranganBiayaLainnya) == count($request->hargaBiayaLainnya)){
                for($i = 0; $i < count($request->keteranganBiayaLainnya); $i++){
                    $gabungan[] = [
                        'keterangan' => $request->keteranganBiayaLainnya[$i],
                        'harga' => $request->hargaBiayaLainnya[$i]
                    ];
                }

                return $gabungan;
            }else{
                throw new \Exception('Inputan Biaya lainnya harus diisi semua');
            }
        }
    }

    /**
     * RESI GENERATOR
     * 
     * kode resi berbentuk 10 digit number yang terdiri dari : 6 digit pertama menunjukkan tanggal, 4 digit terakhir menunjukkan urutan paket hari itu
     */
    private function generateKodeResi(){
        // define set timezone date
        date_default_timezone_set('ASIA/JAKARTA');

        // check last input resi di database
        $lastInputKode = $this->paketRepository->getLastKodeResi();

        if($lastInputKode != null){
            // bagi kode menjadi 2 bagian
            $lastInputKode = str_split($lastInputKode, 6);
            if($lastInputKode[0] == date('dmy')){
                $kodeResi = $lastInputKode[0] . $this->autoIncrementKodeResi($lastInputKode[1]);
            }else{
                $kodeResi = date('dmy') . '0000';
            }

        }else{
            // jika isi database kosong
            $kodeResi = date('dmy') . '0000';
        }

        return $kodeResi;
    }

    /**
     * AUTO INCREMENT KODE RESI
     * 
     * menambahkan secara otoamatis pada 4 digit angka terakhir kode resi
     */
    private function autoIncrementKodeResi(string $lastDigitKode): string{
        // ubah/hapus prefix 0 didepan real number
        (int)$lastDigitKode = ltrim($lastDigitKode, 0);

        if($lastDigitKode == null){
            //jika tidak ada angka di real number/ == 0
            $lastDigitKode = 1; 
        }else{
            // jika ada angka real maka incrementkan (++)
            $lastDigitKode = $lastDigitKode + 1;
        }

        return (string)str_pad($lastDigitKode, 4, '0', STR_PAD_LEFT);
    }

    /**
     * DETAIL PAKET
     * 
     * Menampilkan data data paket yang tersimpan didatabase
     */
    public function detailPaket(string $kodeResi): array{
        // check apakah kode resi ada di database
        if($this->paketRepository->findByKodeResi($kodeResi) != null){
            $paket = new Paket;
            $paket = $this->paketRepository->findByKodeResi($kodeResi);

            $kodeResi = $paket->kodeResi;
            $tanggalPembuatan = $paket->tanggalPembuatan;
            $dataPaket = unserialize($paket->dataPaket);
            $biayaPaket = unserialize($paket->biayaPaket);
            $vendorPaket = unserialize($paket->vendorPaket);
            $updatePaket = unserialize($paket->updatePaket);
            $statusPaket = $paket->statusPaket;

            $detailPaket = [
                'kode-resi' => $kodeResi,
                'tanggal' => $tanggalPembuatan,
                'data-paket' => $dataPaket,
                'biaya-paket' => $biayaPaket,
                'vendor-paket' => $vendorPaket,
                'update-paket' => $updatePaket,
                'status-paket' => $statusPaket

            ];

            return $detailPaket;
        }else{
            throw new \Exception('Data tidak ditemukan');
        }        
    }

    /**
     * TAMBAH VENDOR KE PAKET
     */
    public function tambahVendor(VendorPaketRegisterRequest $request, string $kodeResi){

        try{
            Database::beginTransaction();
            
            $paket = new Paket;
            // check apakah kode resi ada di database
            $paket = $this->paketRepository->findByKodeResi($kodeResi);
            // jika ada semua data sudah dipindah ke obj paket

            if($paket != null){
                // ubah ke bentuk array
                $update = unserialize($paket->updatePaket);

                // buat update baru
                DotEnv::set_default_timezone();
                $update[] = "Update Vendor => " . " nama orang [" . date('H:i, d M Y') . "]";
                $paket->updatePaket = serialize($update);

                $paket->vendorPaket = serialize($this->vendorLogic($request));
                // update data paket vendor
                $this->paketRepository->updateInvoiceVendor($paket);
            }else{
                throw new \Exception('Failde Update, Kode resi tidak ditemukan didatabase');
            }

            Database::commitTransaction();
        }catch(\Exception $ex){
            Database::rollbackTransaction();
            throw $ex;
        }
    }

    private function tambahVendorValidate(VendorPaketRegisterRequest $request){
        if(isset($request->namaVendor)){
            foreach($request->namaVendor as $key => $value){
                if($value == null || $value == ''){
                    throw new \Exception('nama vendor ada yang kosong');
                }
            }
        }else{
            $request->namaVendor = null;
        }

        if(isset($request->kotaVendor)){
            foreach ($request->kotaVendor as $key => $value) {
                if($value == null || $value == ''){
                    throw new \Exception('kota vendor ada yang kosong');
                }
            }
        }else{
            $request->kotaVendor = null;
        }

        if(isset($request->hargaVendor)){
            foreach ($request->hargaVendor as $key => $value) {
                if(preg_match('/^[A-Za-z]*$/',$value)){
                    throw new \Exception('harga vendor harus angka');
                }
                elseif($value == null || $value <= 0){
                    throw new \Exception('harga vendor ada yang kosong');
                }
            }
        }else{
            $request->hargaVendor = null;
        }
    }

    private function vendorLogic(VendorPaketRegisterRequest $request): array{
        $gabungan = [];
        $this->tambahVendorValidate($request);
        $totalHarga = 0;
        if($request->kotaVendor != null){
            for($i = 0; $i < count($request->kotaVendor); $i++){
                $gabungan[] = [
                    'nama-vendor' => $request->namaVendor[$i],
                    'kota-vendor' => $request->kotaVendor[$i],
                    'harga-vendor' => $request->hargaVendor[$i]
                ];
                $totalHarga += (int)$request->hargaVendor[$i];
            }
        }else{
            $gabungan = null;
        }

        $vendor = [
            'total-harga' => $totalHarga,
            'vendor' => $gabungan
        ];

        return $vendor;
    }

    /**
     * LIST INVOICE PAKET
     * 
     * nilai return berupa array yang isinya resi, data paket, vendor dan status paket
     * 
     * @return array
     */
    public function listPaket(): array{
        foreach($this->paketRepository->getAllData() as $unserialize){
            $data[] = [
                'resi' => $unserialize['resi'],
                'tanggal' => $unserialize['tanggal_pembuatan'],
                'data_paket' => unserialize($unserialize['data_paket']),
                'biaya_paket' => unserialize($unserialize['biaya_paket']),
                'vendor_paket' => unserialize($unserialize['vendor_paket']),
                'status_paket' => $unserialize['status_paket']
            ];
        }

        return $data;
    }

    /**
     * LIST INVOICE PAKET
     * 
     * nilai return berupa array yang isinya resi, data paket, vendor dan status paket
     * 
     * @return array
     */
    public function listPaketByTanggal(string $tanggal): ?array{
        if($this->paketRepository->getDataByDate($tanggal) != null){
            foreach($this->paketRepository->getDataByDate($tanggal) as $data){
                $gabungan[] = [
                    'resi' => $data['resi'],
                    'tanggal' => $data['tanggal_pembuatan'],
                    'data_paket' => unserialize($data['data_paket']),
                    'biaya_paket' => unserialize($data['biaya_paket']),
                    'vendor_paket' => unserialize($data['vendor_paket']),
                    'status_paket' => $data['status_paket']
                ];
            }

            return $gabungan;
        }else{
            throw new \Exception('Data Not Found');
        }
    }
}
<?php

namespace Mahatech\AlindoExpress\Repository;

use Mahatech\AlindoExpress\Domain\Paket;
use PDO;

class PaketRepository{
    private PDO $connection;

    public function __construct(PDO $connection) {
        // saat class ini dipanggil memerlukan koneksi dari database (Config/ Class Database)
        $this->connection = $connection;
    }

    /**
     * Save data ke paket tabel
     * 
     * data yang disimpan ke atribut : resi, tanggal pembuatan, data paket, biaya paket, vendor paket, update paket.
     * @return Paket
     */
    public function save(Paket $paket): Paket{
        $stmt = $this->connection->prepare('INSERT INTO paket(resi, tanggal_pembuatan, data_paket, biaya_paket, vendor_paket, update_paket, status_paket) VALUES(?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$paket->kodeResi, $paket->tanggalPembuatan, $paket->dataPaket, $paket->biayaPaket, $paket->vendorPaket, $paket->updatePaket, 'Proses']);

        return $paket;
    }

    /**
     * Show All Data Paket
     * 
     * Menampilkan semua isi data dari database
     * @return array | null
     */
    public function getAllData(): ?array{
        $stmt = $this->connection->prepare('SELECT resi, tanggal_pembuatan, data_paket, biaya_paket, vendor_paket, status_paket FROM paket');
        $stmt->execute();

        try {
            if($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                $array = [];
                foreach($row as $data){
                    $array[] = $data;
                }

                return $array;
            }
        } finally{
            $stmt->closeCursor();
        }
    }

    /**
     * Find Data By Kode Resi
     * 
     * mencari data di database berdasarkan kode resi, dan return valuenya OBJ Paket jika data ditemukan
     * @return Paket | null
     */
    public function findByKodeResi(string $kodeResi): ?Paket{
        $stmt = $this->connection->prepare('SELECT resi, tanggal_pembuatan, data_paket, biaya_paket, vendor_paket, update_paket, status_paket FROM paket WHERE resi = ?');
        $stmt->execute([$kodeResi]);

        try{
            if($row = $stmt->fetch()){
                $paket = new Paket;
                $paket->kodeResi = $row['resi'];
                $paket->tanggalPembuatan = $row['tanggal_pembuatan'];
                $paket->dataPaket = $row['data_paket'];
                $paket->biayaPaket = $row['biaya_paket'];
                $paket->vendorPaket = $row['vendor_paket'];
                $paket->updatePaket = $row['update_paket'];
                $paket->statusPaket = $row['status_paket'];


                return $paket;
            }
        }finally{
            $stmt->closeCursor();
        }

        return null;
    }

    /**
     * Check Kode Resi
     * 
     * check kode resi di db, sudah ada atau belum
     * @return bool
     */
    public function checkKodeResiInDatabase(string $kodeResi): bool{
        $stmt = $this->connection->prepare('SELECT resi FROM paket WHERE resi = ?');
        $stmt->execute([$kodeResi]);

        try{
            if($stmt->fetch()){
                // kode resi ada di database
                return true;
            }else{
                // kode tidak ada di database (Aman)
                return false;
            }
        }finally{
            $stmt->closeCursor();
        }
    }

    /**
     * Get Last Kode Resi
     * 
     * mendapatkan kode resi yang terakhir atau yang paling baru di DB
     */
    public function getLastKodeResi(): ?string{
        $stmt = $this->connection->prepare('SELECT resi FROM paket ORDER BY resi DESC LIMIT 1');
        $stmt->execute();

        try{
            if($row = $stmt->fetch()){
                // jika ada balikkan kode resi
                return $row['resi'];
            }else{
                return null;
            }
        } finally{
            $stmt->closeCursor();
        }
    }

    /**
     * Update Vendor
     * 
     * Update data vendor, hal yang diupdate vendor paket dan update paket (history)
     */
    public function updateInvoiceVendor(Paket $paket): Paket{
        $stmt = $this->connection->prepare('UPDATE paket SET vendor_paket = ?, update_paket = ? WHERE resi = ? ');
        $stmt->execute([$paket->vendorPaket, $paket->updatePaket, $paket->kodeResi]);

        return $paket;
    }

    /**
     * Get Data berdasarkan tanggal
     * 
     * mendapatkan data paket di DB berdasarkan tanggal yang dimasukkan
     */
    public function getDataByDate(string $tanggal): ?array{
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $stmt = $this->connection->prepare('SELECT * FROM paket WHERE YEAR(tanggal_pembuatan) = ? AND MONTH(tanggal_pembuatan) = ?');
        $stmt->execute([$tahun, $bulan]);

        try {
            if($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                $array = [];
                foreach($row as $data){
                    $array[] = $data;
                }

                return $array;
            }else{
                return null;
            }
        } finally{
            $stmt->closeCursor();
        }
    }

    /**
     * Jumlah Row pada tabel paket DB
     */
    public function totalRow(){
        $stmt = $this->connection->prepare('SELECT * FROM paket');
        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * Pagination Paket
     * 
     * menggunakan syntax limit
     */
    public function pagination(int $halamanAwal, int $batas): array{
        $stmt = $this->connection->prepare('SELECT resi, tanggal_pembuatan, data_paket , status_paket FROM paket LIMIT :start, :batas');
        $stmt->bindParam(':start', $halamanAwal, PDO::PARAM_INT);
        $stmt->bindParam(':batas', $batas, PDO::PARAM_INT);
        $stmt->execute();

        try{
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($data as $row){
                $array[] = $row;
            }

            return $array;
        } finally{
            $stmt->closeCursor();
        }
    }
}
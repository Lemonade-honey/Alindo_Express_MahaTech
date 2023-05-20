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

    public function save(Paket $paket): Paket{
        $stmt = $this->connection->prepare('INSERT INTO paket(resi, tanggal_pembuatan, data_paket, biaya_paket, vendor_paket) VALUES(?, ?, ?, ?, ?)');
        $stmt->execute([$paket->kodeResi, $paket->tanggalPembuatan, $paket->dataPaket, $paket->biayaPaket, $paket->vendorPaket]);

        return $paket;
    }

    public function findByKodeResi(string $kodeResi): ?Paket{
        $stmt = $this->connection->prepare('SELECT resi, tanggal_pembuatan, data_paket, biaya_paket, vendor_paket, status_paket FROM paket WHERE resi = ?');
        $stmt->execute([$kodeResi]);

        try{
            if($row = $stmt->fetch()){
                $paket = new Paket;
                $paket->kodeResi = $row['resi'];
                $paket->tanggalPembuatan = $row['tanggal_pembuatan'];
                $paket->dataPaket = $row['data_paket'];
                $paket->biayaPaket = $row['biaya_paket'];
                $paket->vendorPaket = $row['vendor_paket'];
                $paket->statusPaket = $row['status_paket'];


                return $paket;
            }
        }finally{
            $stmt->closeCursor();
        }
    }
}
<?php

/**
 * Berisi tentang data-data yang diperlukan untuk object tersebut
 * Dalam kasus/Class ini ialah data Paket
 */


namespace Mahatech\AlindoExpress\Domain;
class Paket{
    public ?int $kodeResi = null;
    public ?string $tanggalPembuatan = null;
    public ?string $dataPaket = null;
    public ?string $biayaPaket = null;
    public ?string $vendorPaket = null;
    public ?string $riwayatPaket = null;

    // Fitur Track Paket belum tersedia
    // public ?array $trackPaket = null;
    public ?int $statusPaket = null;

}
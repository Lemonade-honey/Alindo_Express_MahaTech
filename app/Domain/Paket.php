<?php

/**
 * Berisi tentang data-data yang diperlukan untuk object tersebut
 * Dalam kasus/Class ini ialah data Paket
 */


namespace Mahatech\AlindoExpress\Domain;
class Paket{
    public ?string $kodeResi = null;
    public ?string $tanggalPembuatan = null;
    public ?string $dataPaket = null;
    public ?string $biayaPaket = null;
    public ?string $vendorPaket = null;
    public ?string $updatePaket = null;

    // Fitur Track Paket belum tersedia
    // public ?array $trackPaket = null;
    public ?string $statusPaket = null;

}
<?php
namespace Mahatech\AlindoExpress\Model\Paket;
class PaketRegisterRequest{
    // data_paket
    public ?string $kotaAsal = null;
    public ?string $kotaTujuan = null;
    public ?string $jumlahKoli = null;
    public ?string $hargaPerKilo = null;
    public ?string $berat = null;
    public ?string $beratVolume = null;
    public ?string $kategori = null;
    public ?string $pemeriksaan = null;
    public ?string $namaPengirim = null;
    public ?string $hpPengirim = null;
    public ?string $namaPenerima = null;
    public ?string $alamatPenerima = null;
    public ?string $hpPenerima = null;

    // biaya_paket
    public ?string $biayaKirim = null;
    public ?string $biayaLainnya = null;
    public ?string $totalBiaya = null;

    // Karyawan
    public ?string $karyawanProfile = null;
}
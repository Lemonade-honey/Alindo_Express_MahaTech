<?php
    // print_r($response['response-paket']);
    $paket = $response['response-paket'];
    print_r($paket['update-paket']);
    // echo $paket['data-paket']['kota_tujuan'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= ROOT ?>/css/global-style.css">
    <link rel="stylesheet" href="<?= ROOT ?>/css/paket-style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js" defer></script>
    <title>Detail Invoice || <?= $paket['kode-resi']?></title>
</head>
<body>
    <section>
        <div class="flex">
            <h1><div class="judul-page">Detail Invoice</div></h1>
        </div>
        <div class="container-paket">
            <form>
                <!-- id barang -->
                <div class="form-container">
                    <div class="form-input flex">
                        <div class="fullwidth">
                            <p><strong>Kode Resi</strong></p>
                            <strong><p class="box-input" id="kode-resi"><?= $paket['kode-resi']?></p></strong>
                        </div>
                        <div class="fullwidth">
                            <p>Tanggal</p>
                            <p class="box-input" id="tanggal"><?= date('H:i, d M Y', strtotime($paket['tanggal']))?></p>
                        </div>
                    </div>
                    <div class="form-input">
                        <p>Kota Asal</p>
                        <p class="box-input" id="kota-asal"><?= $paket['data-paket']['kota_asal']?></p>
                    </div>
                    <div class="form-input">
                        <p>Kota Tujuan</p>
                        <p class="box-input" id="kota-tujuan"><?= $paket['data-paket']['kota_tujuan']?></p>
                    </div>
                    <div class="form-input">
                        <p>Jumlah Koli</p>
                        <p class="box-input"><?= $paket['data-paket']['jumlah_koli']?></p>
                    </div>
                    <div class="form-input">
                        <p>Harga/Kg</p>
                        <p class="box-input">Rp. <?= $paket['data-paket']['harga_kilo']?></p>
                    </div>
                    <div class="form-input flex">
                        <div class="fullwidth">
                            <p>Berat</p>
                            <p class="box-input"><?= $paket['data-paket']['berat']?> kg</p>
                        </div>
                        <div class="fullwidth">
                            <p>Berat Volume</p>
                            <p class="box-input"><?= $paket['data-paket']['berat_volume']?> kg</p>
                        </div>
                    </div>
                    <div class="form-input">
                        <p>Kategori Barang</p>
                        <p class="box-input"><?= $paket['data-paket']['kategori']?></p>
                    </div>
                    <div class="form-input">
                        <p>Pemeriksaan</p>
                        <p class="box-input"><?= $paket['data-paket']['periksa']?></p>
                    </div>
                </div>
                <!-- data pengirim dan penerima -->
                <div class="form-container">
                    <!-- pengirim -->
                    <div class="sub-form-container">
                        <div class="form-input">
                            <p>Nama Pengirim</p>
                            <p class="box-input"><?= $paket['data-paket']['nama_pengirim']?></p>
                        </div>
                        <div class="form-input">
                            <p>No HP Pengirim</p>
                            <p class="box-input"><?= $paket['data-paket']['hp_pengirim']?></p>
                        </div>
                    </div>
                    <!-- penerima -->
                    <div class="sub-form-container">
                        <div class="form-input">
                            <p>Nama Penerima</p>
                            <p class="box-input"><?= $paket['data-paket']['nama_penerima']?></p>
                        </div>
                        <div class="form-input">
                            <p>Alamat</p>
                            <textarea cols="30" rows="5" class="box-input" disabled><?= trim(htmlspecialchars($paket['data-paket']['alamat_penerima']))?></textarea>
                        </div>
                        <div class="form-input">
                            <p>No HP Penereima</p>
                            <p class="box-input"><?= $paket['data-paket']['hp_penerima']?></p>
                        </div>
                    </div>
                </div>
                <!-- harga setting -->
                <div class="form-container">
                    <div class="form-input">
                        <p>Biaya Kirim</p>
                        <p class="box-input"><?= $paket['biaya-paket']['biaya_kirim']?></p>
                    </div>
                    <div class="form-input">
                        <p>Biaya Lainnya</p>
                        <?php if(isset($paket['biaya-paket']['biaya_lainnya']))
                            foreach($paket['biaya-paket']['biaya_lainnya'] as $data)
                        {?>
                        <div class="multy-input-biaya-lainnya">
                            <div class="form-input">
                                <p class="box-input"><?= $data['keterangan']?></p>
                                <p class="box-input"><?= $data['harga']?></p>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <div class="form-input">
                        <p><strong>Total</strong></p>
                        <p class="box-input" id="show_total_harga">Rp. <?= $paket['biaya-paket']['biaya_total']?></p>
                    </div>
                    <div class="form-submit">
                        <!-- <p class="btn-submit red" id="cancel">Cancel</p> -->
                        <button type="button" class="btn-submit red" id="cancel">Cancel Invoice</button>
                        <!-- <p class="btn-submit" id="submit">Buat Invoice</p> -->
                        <button type="button" class="btn-submit" id="submit">Edit Invoice</button>
                        <button type="button" class="btn-submit green" id="submit">Cetak Invoice</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Status Paket -->
    <section>
        <div class="control-form">
            <h1><div class="judul-page">Status Invoice</div></h1>
        </div>
        <div class="container-detail-paket">
            <p>Status : <strong id="status-paket"><?= $paket['status-paket']?></strong></p>
        </div>
    </section>
    
    <!-- Vendor Paket -->
    <section>
        <div class="control-form">
            <h1><div class="judul-page">Vendor Invoice</div></h1>
        </div>
        <div class="container-detail-paket">
            <?php if($paket['vendor-paket'] == null){?>
            <p>Vendor Set Empty <a href="/detail-invoice/<?= $paket['kode-resi']?>/vendor">Set up</a></p>
            <?php }?>
        </div>
    </section>

    <!-- Vendor Paket -->
    <section>
        <div class="control-form">
            <h1><div class="judul-page">Vendor Invoice</div></h1>
        </div>
        <div class="container-detail-paket">
            <p>Total Vendor Rp. 20.000</p>
            <ol>
                <li>Vendor A => Jakarta, Rp. 5000</li>
                <li>Vendor B => Magelang, Rp. 15000</li>
                <li>Vendor C => Surakarta, Rp. 50000</li>
            </ol>
            <a href="#">Edit Vendor</a>
        </div>
    </section>

    <!-- Update Invoice -->
    <section>
        <div class="control-form">
            <h1><div class="judul-page">Update Invoice</div></h1>
        </div>
        <div class="container-detail-paket">
            <ol>
                <?php 
                    foreach($paket['update-paket'] as $update){
                ?>
                <li><?= $update?></li>
                <?php }?>
            </ol>
        </div>
    </section>

    <script>
        const statusPaket = document.getElementById('status-paket')
        if(statusPaket.textContent == 'Proses'){
            statusPaket.style.color = '#35a4d4'
        }else if(statusPaket.textContent == 'Selesai'){
            statusPaket.style.color = '#16cc3e'
        }else if(statusPaket.textContent == 'Batal'){
            statusPaket.style.color = '#e03d45'
        }
    </script>
</body>
</html>
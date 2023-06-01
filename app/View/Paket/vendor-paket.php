<?php
    // print_r($response['response-paket']);
    $paket = $response['response-paket'];
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
    <script type="module" src="<?= ROOT ?>/js/VendorPaket.js" defer></script>
    <title>Vendor Invoice || <?= $paket['kode-resi']?></title>
</head>
<body>
    <section>
        <div class="flex">
            <h1><div class="judul-page">Vendor Invoice</div></h1>
        </div>
        <div class="target"><button type="button" class="btnTambah" id="tambah">Tambah Vendor</button> <?= $paket['data-paket']['kota_asal']?> > <?= $paket['data-paket']['kota_tujuan']?></div>
        <form method="post">
            <div id="target-container">
            <?php
                if($paket['vendor-paket']['vendor'] != null){
                    foreach ($paket['vendor-paket']['vendor'] as $key => $value) {
            ?>
                <div class="container-detail-paket">
                    <div class="form-input">
                        <p>Nama Vendor</p>
                        <input type="text" class="box-input" name="nama[]" value="<?= $value['nama-vendor']?>">
                    </div>
                    <div class="form-input">
                        <p>Kota Vendor</p>
                        <input type="text" class="box-input" name="kota[]" value="<?= $value['kota-vendor']?>">
                    </div>
                    <div class="form-input">
                        <p>Harga Vendor</p>
                        <input type="number" class="box-input" name="harga[]" value="<?= $value['harga-vendor']?>">
                    </div>
                    <button class="btnDelete" type='button'>hapus</button>
                </div>
            <?php } }?>
                
                <!-- <div class="container-detail-paket">
                    <div class="form-input">
                        <p>Nama Vendor</p>
                        <input type="text" class="box-input" name="nama[]">
                    </div>
                    <div class="form-input">
                        <p>Kota Vendor</p>
                        <input type="text" class="box-input" name="kota[]">
                    </div>
                    <div class="form-input">
                        <p>Harga Vendor</p>
                        <input type="number" class="box-input" name="harga[]">
                    </div>
                    <button class="btnDelete" type='button'>hapus</button>
                </div> -->
            </div>
            <button type="submit" class="btnSubmit" id="submit">Update Vendor</button>
        </form>
    </section>
</body>
</html>
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
    <script type="module" src="<?= ROOT ?>/js/InvoicePaket.js" defer></script>
    <title>Pendaftaran Paket</title>
</head>
<body>
    <section>
        <h1><div class="judul-page">Input Data Paket</div></h1>
        <?php if(isset($response['error'])){?>
            <p class="error"><?= $response['error']?></p>
        <?php }?>
        <div class="container-paket">
            <form action="" autocomplete="off" method="POST" id="form">
                <!-- id barang -->
                <div class="form-container">
                    <div class="form-input">
                        <p>Kota Asal</p>
                        <div class="test">
                            <select name="kota-asal" id="kota-asal" class="box-input" onchange="actionKotaAsal()">
                                <option value="Yogyakarta">Yogyakarta</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <!-- name atribut ad di js -->
                            <div id="kota-asal-lainnya"></div>
                        </div>
                    </div>
                    <div class="form-input">
                        <p>Kota Tujuan</p>
                        <input type="search" id="kota-tujuan" class="box-input" name="kota-tujuan" value="<?php if(isset($_POST['kota-tujuan'])) echo $_POST['kota-tujuan']?>">
                            <ul class="list"></ul>
                    </div>
                    <div class="form-input">
                        <p>Jumlah Koli</p>
                        <input type="number" name="jumlah-koli" id="" class="box-input" value="<?php if(isset($_POST['jumlah-koli'])) echo $_POST['jumlah-koli']?>">
                    </div>
                    <div class="form-input">
                        <p>Harga/Kg</p>
                        <input type="number" name="harga-kg" id="harga-kg" value="<?php if(isset($_POST['harga-kg'])) echo $_POST['harga-kg']?>" class="box-input" onchange="calculetBiayaKirim()">
                    </div>
                    <div class="form-input">
                        <p>Berat</p>
                        <input type="number" name="berat" id="berat" class="box-input">
                    </div>
                    <div class="form-input">
                        <p>Berat Volume (<strong>Min berat 50 Kg</strong>)</p>
                        <input type="number" name="berat-volume" id="berat-volume" class="box-input disabled" value="" onchange="calculetBiayaKirim()">
                    </div>
                    <div class="form-input">
                        <p>Kategori Barang</p>
                        <input type="text" name="kategori-barang" class="box-input">
                    </div>
                    <div class="form-input radio">
                        <div class="radio">
                            <input type="radio" name="status_periksa" id="iya" value="Diperiksa" required>
                            <label for="iya">Diperiksa</label>
                        </div>
                        <div class="radio">
                            <input type="radio" name="status_periksa" id="tidak" value="Tidak Diperiksa">
                            <label for="tidak">Tidak Diperikasa</label>
                        </div>
                    </div>
                </div>
                <!-- data pengirim dan penerima -->
                <div class="form-container">
                    <!-- pengirim -->
                    <div class="sub-form-container">
                        <div class="form-input">
                            <p>Nama Pengirim</p>
                            <input type="text" name="nama-pengirim" id="" class="box-input capital" required>
                        </div>
                        <div class="form-input">
                            <p>No HP Pengirim</p>
                            <input type="number" name="no-HP-pengirim" id="" class="box-input">
                        </div>
                    </div>
                    <!-- penerima -->
                    <div class="sub-form-container">
                        <div class="form-input">
                            <p>Nama Penerima</p>
                            <input type="text" name="nama-penerima" id="" class="box-input capital">
                        </div>
                        <div class="form-input">
                            <p>Alamat</p>
                            <textarea name="alamat-tujuan" id="" cols="30" rows="12" class="box-input"></textarea>
                        </div>
                        <div class="form-input">
                            <p>No HP Penereima</p>
                            <input type="number" name="no-HP-penerima" id="" class="box-input">
                        </div>
                    </div>
                </div>
                <!-- harga setting -->
                <div class="form-container">
                    <div class="form-input">
                        <p>Biaya Kirim</p>
                        <input type="number" name="biaya-kirim" id="biaya-kirim" class="box-input" value="" placeholder="0">
                    </div>
                    <div class="form-input">
                        <p>Biaya Lainnya <button type="button" class="btnTambah" id="tambah-biaya-lainnya">Tambah</button></p>
                        <div class="multy-input-biaya-lainnya">
                            
                        </div>
                    </div>
                    <div class="form-input">
                        <p><strong>Total</strong></p>
                        <p class="box-input disabled text">Rp.<span style="margin-left: .4rem;" id="show-total-harga">0</span></p>
                        <input type="number" style="display: none;" name="total_harga" id="total-harga" class="box-input disabled"  value="0">
                    </div>
                    <div class="form-submit">
                        <!-- <p class="btn-submit red" id="cancel">Cancel</p> -->
                        <button type="button" class="btn-submit red" id="cancel">Cancel</button>
                        <!-- <p class="btn-submit" id="submit">Buat Invoice</p> -->
                        <button class="btn-submit" type="submit" id="submit">Buat Invoice</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
<script>
    function actionKotaAsal(){
        const kotaAsal = document.getElementById('kota-asal')
        const kotaAsalLainnya = document.getElementById('kota-asal-lainnya')
        if(kotaAsal.value == 'lainnya'){
            // remove name tag
            kotaAsal.removeAttribute('name')

            const inputForm = document.createElement('input')
            inputForm.setAttribute('type', 'text')
            inputForm.setAttribute('name', 'kota-asal')
            inputForm.setAttribute( 'class','box-input')
            inputForm.setAttribute('placeholder', 'Masukkan nama kota')

            kotaAsalLainnya.appendChild(inputForm)
        }else{
            if(kotaAsalLainnya.children.length > 0){
                kotaAsalLainnya.removeChild(kotaAsalLainnya.children[0])
            }
            kotaAsal.setAttribute('name', 'kota-asal')
        }
    }

    function calculetBiayaKirim(){
        const hargaPerKg = document.getElementById('harga-kg')
        const beratVolume = document.getElementById('berat-volume')

        let harga = 0, berat = 0;

        if(!isNaN(Number(hargaPerKg.value)) && hargaPerKg.value > 0){
            // console.log('yes');
            harga = Number(hargaPerKg.value)
        }

        if(!isNaN(Number(beratVolume.value)) && beratVolume.value > 0){
            berat = Number(beratVolume.value)
        }

        if(harga > 0 && berat > 0){
            const biayaKirim = document.getElementById('biaya-kirim')
            biayaKirim.value = berat * harga
        }
    }

    function getAllHarga(){
        let totalHarga = 0
        
        // biaya kirim
        const biayaKirim = document.getElementById('biaya-kirim')
        if(biayaKirim.value == '' || biayaKirim.value == null || biayaKirim.value == 0 || biayaKirim.value < 0){
            totalHarga = 0
        }else{
            totalHarga = Number(biayaKirim.value)
        }

        // biaya lainnya
        document.getElementsByName('harga[]').forEach((e) => {
            // console.log(e.value);
            totalHarga += Number(e.value)
        })

        const targetContainerTotalHarga = document.getElementById('show-total-harga')
        targetContainerTotalHarga.innerHTML = new Intl.NumberFormat().format(totalHarga)

        const totalHargaInput = document.getElementById('total-harga')
        totalHargaInput.value = totalHarga

    }

    // main runner
    setInterval(() => {
        // calculetBiayaKirim()
        getAllHarga()
    }, 500)
    
</script>
</html>
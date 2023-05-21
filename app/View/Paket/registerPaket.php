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
    <title>Pendaftaran Paket</title>
</head>
<body>
    <section>
        <div class="control-form">
            <h1><div class="judul-kontent">Input Data</div></h1>
            <!-- <?php ?> -->
        </div>
        <div class="container-paket">
            <form action="" autocomplete="off" method="POST" id="form">
                <!-- id barang -->
                <div class="form-container">
                    <div class="form-input">
                        <p>Kota Asal</p>
                        <div class="test">
                            <select name="kota_asal" id="kota_asal" class="box-input" onchange="actionKotaAsal()">
                                <option value="Yogyakarta">Yogyakarta</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <!-- name atribut ad di js -->
                            <div id="kota-asal-lainnya"></div>
                        </div>
                    </div>
                    <div class="form-input">
                        <p>Kota Tujuan</p>
                        <input type="search" id="kota_tujuan" class="box-input" name="kota_tujuan" value="">
                            <ul class="list"></ul>
                    </div>
                    <div class="form-input">
                        <p>Jumlah Koli</p>
                        <input type="number" name="jumlah_koli" id="" class="box-input" value="">
                    </div>
                    <div class="form-input">
                        <p>Harga/Kg</p>
                        <input type="number" name="harga_kg" id="harga_kg" value="" class="box-input">
                    </div>
                    <div class="form-input">
                        <p>Berat</p>
                        <input type="number" name="berat" id="berat" class="box-input">
                    </div>
                    <div class="form-input">
                        <p>Berat Volume (<strong>Min berat 50 Kg</strong>)</p>
                        <input type="number" name="berat_volume" id="berat_volume" class="box-input disabled" value="">
                    </div>
                    <div class="form-input">
                        <p>Kategori Barang</p>
                        <input type="text" name="kategori_barang" class="box-input">
                    </div>
                    <div class="form-input radio">
                        <div class="radio">
                            <input type="radio" name="status_barang" id="iya">
                            <label for="iya">Diperiksa</label>
                        </div>
                        <div class="radio">
                            <input type="radio" name="status_barang" id="tidak">
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
                            <input type="text" name="nama_pengirim" id="" class="box-input capital">
                        </div>
                        <div class="form-input">
                            <p>No HP Pengirim</p>
                            <input type="number" name="no_HP_pengirim" id="" class="box-input">
                        </div>
                    </div>
                    <!-- penerima -->
                    <div class="sub-form-container">
                        <div class="form-input">
                            <p>Nama Penerima</p>
                            <input type="text" name="nama_penerima" id="" class="box-input capital">
                        </div>
                        <div class="form-input">
                            <p>Alamat</p>
                            <textarea name="alamat_tujuan" id="" cols="30" rows="12" class="box-input"></textarea>
                        </div>
                        <div class="form-input">
                            <p>No HP Penereima</p>
                            <input type="number" name="no_HP_pengirim" id="" class="box-input">
                        </div>
                    </div>
                </div>
                <!-- harga setting -->
                <div class="form-container">
                    <div class="form-input">
                        <p>Biaya Kirim</p>
                        <input type="number" name="biaya_kirim" id="biaya_kirim" class="box-input" value="" placeholder="0">
                    </div>
                    <div class="form-input">
                        <p>Biaya Lainnya <i class="fa-solid fa-plus" style="padding: .4rem .5rem; background-color: #3a8f2f; border-radius: .5rem;"></i></p>
                        <div class="multy-input">
                            <input type="text" name="ket_lain-lain" id="" class="box-input" placeholder="Keterangan">
                            <input type="number" name="lain-lain" id="harga_tambahan" class="box-input" placeholder="0">
                            <div class="multy-input-btn"><i class="fa-solid fa-minus"></i></div>
                        </div>
                    </div>
                    <div class="form-input">
                        <p><strong>Total</strong></p>
                        <p class="box-input disabled text" id="show_total_harga"></p>
                        <input type="number" name="total_harga" id="total_harga" class="box-input disabled" disabled value="0" style="display: none;">
                    </div>
                    <div class="form-submit">
                        <p class="btn-submit red" id="cancel">Cancel</p>
                        <p class="btn-submit" id="submit-btn">Buat Invoice</p>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
<script>
    function actionKotaAsal(){
        const kotaAsal = document.getElementById('kota_asal')
        const kotaAsalLainnya = document.getElementById('kota-asal-lainnya')
        if(kotaAsal.value == 'lainnya'){
            // remove name tag
            kotaAsal.removeAttribute('name')

            const inputForm = document.createElement('input')
            inputForm.setAttribute('type', 'text')
            inputForm.setAttribute('name', 'kota_asal')
            inputForm.setAttribute( 'class','box-input')
            inputForm.setAttribute('placeholder', 'Masukkan nama kota')

            kotaAsalLainnya.appendChild(inputForm)
        }else{
            if(kotaAsalLainnya.children.length > 0){
                kotaAsalLainnya.removeChild(kotaAsalLainnya.children[0])
            }
            kotaAsal.setAttribute('name', 'kota_asal')
        }
    }
</script>
</html>
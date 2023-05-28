<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global-style.css">
    <link rel="stylesheet" href="css/paket-style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js" defer></script>
    <title>Pendaftaran Paket</title>
</head>
<body>
    <section>
        <h1><div class="judul-page">Input Data Paket</div></h1>
        <p class="error">Input Empty Error dll</p>
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
                        <input type="search" id="kota-tujuan" class="box-input" name="kota-tujuan" value="">
                            <ul class="list"></ul>
                    </div>
                    <div class="form-input">
                        <p>Jumlah Koli</p>
                        <input type="number" name="jumlah-koli" id="" class="box-input" value="">
                    </div>
                    <div class="form-input">
                        <p>Harga/Kg</p>
                        <input type="number" name="harga-kg" id="harga-kg" value="" class="box-input" onchange="calculetBiayaKirim()">
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
                            <input type="radio" name="status-barang" id="iya">
                            <label for="iya">Diperiksa</label>
                        </div>
                        <div class="radio">
                            <input type="radio" name="status-barang" id="tidak">
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
                            <input type="text" name="nama-pengirim" id="" class="box-input capital">
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
                            <input type="number" name="no-HP-pengirim" id="" class="box-input">
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
                        <input type="number" name="total-harga" id="total-harga" class="box-input disabled" disabled value="0" style="display: none;">
                    </div>
                    <div class="form-submit">
                        <!-- <p class="btn-submit red" id="cancel">Cancel</p> -->
                        <button type="button" class="btn-submit red" id="cancel">Cancel</button>
                        <!-- <p class="btn-submit" id="submit">Buat Invoice</p> -->
                        <button class="btn-submit" type="button" id="submit">Buat Invoice</button>
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
    }

    function setTotalHarga(){
        const totalHarga = document.getElementById('total-harga')
    }

    // main runner
    setInterval(() => {
        // calculetBiayaKirim()
        getAllHarga()
    }, 500)
    
</script>
<script type="module">
    import { ml } from "./js/domElement.js";
    const btnTambahBiayaLainnya = document.getElementById('tambah-biaya-lainnya')
    const btnSubmit = document.getElementById('submit')
    const btnCancel = document.getElementById('cancel')
    const targetBiayaLainnya = document.querySelector('.multy-input-biaya-lainnya')

    btnCancel.addEventListener('click', () => {
        document.getElementsByName('harga[]').forEach((e) => {
            console.log(e.value);
        })
    })


    // Tambah Function
    btnTambahBiayaLainnya.addEventListener('click', () => {
        let container = ml('div', {class: 'form-input'}, [
            ml('input', {type: 'text', class: 'box-input', placeholder: 'keterangan', name: 'keterangan[]'}, ),
            ml('input', {type: 'number', class: 'box-input', placeholder: 'harga', name: 'harga[]'}, ),
        ])

        const btnDelete = document.createElement('button')
        btnDelete.setAttribute('type', 'button')
        btnDelete.setAttribute('class', 'btnDelete')
        btnDelete.innerHTML = 'hapus'
        btnDelete.addEventListener('click', () => {
            btnDelete.parentElement.remove()
        })

        container.append(btnDelete)
        targetBiayaLainnya.append(container)

        for(let i = 0; i < targetBiayaLainnya.childElementCount; i++){
            targetBiayaLainnya.children[i].children[0].required = true
            targetBiayaLainnya.children[i].children[1].required = true
        }
    })

    // Submit Action
    function actionValidBtb(){
        const input = document.querySelectorAll('input:required')
        if(input.length > 0){
            for(let i = 0; i < input.length; i++){
                // console.log(input[i]);
                if(input[i].value == '' || input[i].value == ''){
                    btnSubmit.disabled = true
                    btnSubmit.style.cursor = 'no-drop'
                    btnSubmit.style.opacity = .5
                    break
                }else{
                    btnSubmit.disabled = false
                    btnSubmit.removeAttribute('style')
                }
            }
        }else{
            btnSubmit.disabled = false
            btnSubmit.removeAttribute('style')
        }
    }


    setInterval(() => {
        // refresh .5s
        actionValidBtb()
    }, 500);


</script>
</html>
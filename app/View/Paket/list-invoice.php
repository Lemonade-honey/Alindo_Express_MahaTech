<?php
    $paket = $response['response-paket'];
    // print_r($paket);
    $no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global-style.css">
    <link rel="stylesheet" href="css/list-style.css">
    <title>List Invoice</title>
</head>
<body>
    <section>
        <div class="container">
            <table>
                <thead>
                    <th>No</th>
                    <th>Kode Resi</th>
                    <th>Tanggal</th>
                    <th>Tujuan</th>
                    <th>Pengirim</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php foreach($paket as $data){?>
                    <tr>
                        <td><?= $no++?></td>
                        <td><?= $data['resi']?></td>
                        <td><?= $data['tanggal']?></td>
                        <td><?= $data['data_paket']['kota_asal']?> - <?= $data['data_paket']['kota_tujuan']?></td>
                        <td><?= $data['data_paket']['nama_pengirim']?></td>
                        <td id="status"><?= $data['status_paket']?></td>
                        <td><a href="/paket/detail-paket/<?= $data['resi']?>">lihat</a></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="page-number">
                <a href="#">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
            </div>
        </div>
    </section>
    <script>
        const tdStatus = document.querySelectorAll('#status')
        tdStatus.forEach(element => {
            if(element.textContent == 'Proses'){
                element.style.color = '#35a4d4'
            }else if(element.textContent == 'Selesai'){
                element.style.color = '#16cc3e'
            }else if(element.textContent == 'Batal'){
                element.style.color = '#e03d45'
            }
        });
    </script>
</body>
</html>
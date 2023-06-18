<?php
    // print_r($response);
    $totalBiaya = 0;
    $totalVendor = 0;
    // nomer
    $i = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= ROOT?>/css/global-style.css">
    <link rel="stylesheet" href="<?= ROOT?>/css/list-style.css">
    <style>
        table{
            width: 100%;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <button>Cetak Exel</button>
            <table>
                <thead>
                    <th>No</th>
                    <th>Kode Resi</th>
                    <th>Kota Tujuan</th>
                    <th>Total Vendor</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <?php foreach($response['response-data'] as $data){
                        if($data['status_paket'] == 'Selesai'){
                            $totalBiaya += $data['biaya_paket']['biaya_total'];
                            if(isset($data['vendor_paket']['total-harga'])){
                                $vendor = $data['vendor_paket']['total-harga'];
                                $totalVendor += $data['vendor_paket']['total-harga'];
                            }
                        
                    ?>
                    <tr>
                        <td><?= $i++?></td>
                        <td><?= $data['resi']?></td>
                        <td><?= $data['data_paket']['kota_tujuan']?></td>
                        <td><?php if(isset($data['vendor_paket']['total-harga'])) echo $data['vendor_paket']['total-harga']; else echo 0?></td>
                        <td><?= $data['biaya_paket']['biaya_total']?></td>
                        <td><?= $data['status_paket']?></td>
                    </tr>
                    <?php } }?>
                </tbody>
                <tfoot>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Rp. <?= $totalVendor?></th>
                    <th>Rp. <?= $totalBiaya?></th>
                    <th></th>
                </tfoot>
            </table>
            <p>Jika <b>tidak ada data yang muncul</b>, maka ada kemungkinan pada bulan ini <b>status paket belum diselesaikan</b> atau memang <b>tidak ada transaksi</b> pada bulan ini</p>
        </div>
    </section>
</body>
</html>
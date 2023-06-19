<?php

namespace Mahatech\AlindoExpress\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanService{

    public function download(array $dataArray, string $tanggalTarget): void{
        if($dataArray != null){
            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();

            // styling
            // set columen dimension
            $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
            $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
            $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
            $activeWorksheet->getColumnDimension('E')->setAutoSize(true);

            // set Header
            $activeWorksheet->setCellValue( 'A1', 'Rekap Laporan Bulan May 2023');
            $activeWorksheet->mergeCells("A1:G1");
            $activeWorksheet->getStyle('A1')->getFont()->setSize(20);
            $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // set nama kolom pada posisi row 1, sebagai judul column
            $activeWorksheet->setCellValue('A2', 'No');
            $activeWorksheet->setCellValue('B2', 'Kode Resi');
            $activeWorksheet->setCellValue('C2', 'Tanggal Pembuatan');
            $activeWorksheet->setCellValue('D2', 'Kota Tujuan');
            $activeWorksheet->setCellValue('E2', 'Total Harga Vendor');
            $activeWorksheet->setCellValue('F2', 'Total Biaya Paket');
            $activeWorksheet->setCellValue('G2', 'Status Paket');

            // urutan
            $i = 2;
            $no = 1;
            foreach($dataArray as $data){
                // hanya yg selesai
                if($data['status_paket'] == 'Selesai'){
                    // row A, nomer auto inc
                    $activeWorksheet->setCellValue('A' . ++$i, $no++);

                    // row B, Kode Resi
                    $activeWorksheet->setCellValue('B' . $i, $data['resi']);

                    // row C, Tanggal
                    $activeWorksheet->setCellValue('C' . $i, date('d M Y', strtotime($data['tanggal'])));

                    // row D, Kota Tujuan
                    $activeWorksheet->setCellValue('D' . $i, $data['data_paket']['kota_tujuan']);

                    // row E, Biaya Vendor
                    if(isset($data['vendor_paket']['total-harga'])){
                        $activeWorksheet->setCellValue('E' . $i, $data['vendor_paket']['total-harga']);
                    }

                    // row F, Biaya Total
                    $activeWorksheet->setCellValue('F' . $i, $data['biaya_paket']['biaya_total']);

                    // row G, status paket
                    $activeWorksheet->setCellValue('G' . $i, $data['status_paket']);
                }

            }

            // set header file
            $name = $tanggalTarget;
            header('Content-disposition: attachment; filename= Rekap-'.$name.'.xlsx');
            header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }else{
            throw new \Exception('Data Array is Null');
        }
    }
}
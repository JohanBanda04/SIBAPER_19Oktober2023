<?php
session_start();

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tanggala = $_POST['tanggala'];
$tanggalb = $_POST['tanggalb'];
$unit = $_POST['unit'];

//$kode_brg_lengkap = $_POST['kode_brg_lengkap'];

//echo $tanggala.'<br>'.$tanggalb.'<br>'.$unit;die;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1','No');
$sheet->setCellValue('B1','Kode Barang');
$sheet->setCellValue('C1','Nama Barang');
$sheet->setCellValue('D1','Satuan');
$sheet->setCellValue('E1','Tgl Pengajuan');
$sheet->setCellValue('F1','Jumlah');
$sheet->setCellValue('G1','Harga');
$sheet->setCellValue('H1','Total');
$sheet->getStyle('A1:H1')->getFont()->setBold(true);






$query = mysqli_query($koneksi, "SELECT  pengajuan.kode_brg, nama_brg, pengajuan.jumlah,pengajuan.satuan, 
pengajuan.hargabarang, pengajuan.total, tgl_pengajuan 
FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg  
WHERE unit='$unit' AND tgl_pengajuan BETWEEN '$tanggala' and '$tanggalb'");


$no= 1;
$i = 2;




while($row = mysqli_fetch_array($query)){

    $sheet->setCellValue('A'.$i,$no++);
    $sheet->setCellValue('B'.$i,date('d/m/Y', strtotime($row['tgl_pengajuan'])) );
    $sheet->setCellValue('C'.$i,$row['kode_brg']);
    $sheet->setCellValue('D'.$i,$row['nama_brg']);
    $sheet->setCellValue('E'.$i,$row['satuan']);
    $sheet->setCellValue('F'.$i,$row['jumlah']);
    $sheet->setCellValue('G'.$i,number_format($row['hargabarang']));
    $sheet->setCellValue('H'.$i,number_format($row['total']));
    $sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    $sheet->getStyle('F')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    $sheet->getStyle('G')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    $i++;

}

//$write = new Xlsx($spreadsheet);
//$write->save('Detil_Lap_Pengajuan.xlsx');
//echo "<script>window.location='Detil_Lap_Pengajuan.xlsx'</script>";

$filename = "Detil_Laporan_Pengajuan.xlsx";

try {
    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);
    $content = file_get_contents($filename);
} catch(Exception $e) {
    exit($e->getMessage());
}

header("Content-Disposition: attachment; filename=".$filename);

unlink($filename);
exit($content);

?>
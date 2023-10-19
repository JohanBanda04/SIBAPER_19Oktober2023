<?php
session_start();

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//echo "testt";die;

$tanggala = $_POST['tanggala']??'';
$tanggalb = $_POST['tanggalb']??'';
$unit = $_POST['unit']??'';
$kode_brg_lengkap = $_POST['kode_brg_lengkap']??'';



//echo $tanggala.'<br>'.$tanggalb.'<br>'.$unit.'<br>'.$kode_brg_lengkap;die;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1','No');
$sheet->setCellValue('B1','Kode Barang');
$sheet->setCellValue('C1','Nama Barang');
$sheet->setCellValue('D1','Harga Barang');
$sheet->setCellValue('E1','Satuan');
$sheet->setCellValue('F1','Masuk');
$sheet->setCellValue('G1','Keluar');
$sheet->setCellValue('H1','Sisa');
$sheet->setCellValue('I1','Keterangan');
$sheet->setCellValue('J1','Operator');
$sheet->getStyle('A1:J1')->getFont()->setBold(true);



$query = mysqli_query($koneksi, "SELECT * FROM stokbarang WHERE id_jenis='1' ");

$no= 1;
$i = 2;

while($row = mysqli_fetch_array($query)){

    $sheet->setCellValue('A'.$i,$no++);
    $sheet->setCellValue('B'.$i,$row['kode_brg']);
    $sheet->setCellValue('C'.$i,$row['nama_brg']);
    $sheet->setCellValue('D'.$i,number_format($row['hargabarang']));
    $sheet->setCellValue('E'.$i,$row['satuan']);
    $sheet->setCellValue('F'.$i,$row['stok']);
    $sheet->setCellValue('G'.$i,$row['keluar']);
    $sheet->setCellValue('H'.$i,$row['sisa']);
    $sheet->setCellValue('I'.$i,$row['keterangan']);
    $sheet->setCellValue('J'.$i,$row['bendahara']);
    $sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    $sheet->getStyle('G')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    $i++;

}

//$write = new Xlsx($spreadsheet);
//$write->save('Detail_Laporan_Permintaan.xlsx');
//echo "<script>window.location='Detail_Laporan_Permintaan.xlsx'</script>";


//$date = date('Y-m-d'.substr((string)microtime(), 1, 8));
//$date = str_replace(".", "", $date);
//$filename = "Detail_Laporan_Permintaan".$date.".xlsx";
$filename = "Material_ATK.xlsx";

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
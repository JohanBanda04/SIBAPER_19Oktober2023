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
$kode_brg_lengkap = $_POST['kode_brg_lengkap'];



//echo $tanggala.'<br>'.$tanggalb.'<br>'.$unit.'<br>'.$kode_brg_lengkap;die;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1','No');
$sheet->setCellValue('B1','Tanggal Permintaan');
$sheet->setCellValue('C1','Nama');
$sheet->setCellValue('D1','Kode Barang');
$sheet->setCellValue('E1','Nama Barang');
$sheet->setCellValue('F1','Satuan');
$sheet->setCellValue('G1','Jumlah');
$sheet->getStyle('A1:G1')->getFont()->setBold(true);





$query_bk = mysqli_query($koneksi, "SELECT pengeluaran.kode_brg, unit, nama_brg, 
jumlah, satuan, tgl_keluar FROM pengeluaran 
INNER JOIN stokbarang ON pengeluaran.kode_brg = stokbarang.kode_brg 
WHERE unit='$unit' AND tgl_keluar BETWEEN '$tanggala' and '$tanggalb' ");

if(isset($_SESSION['sesi_kode_barang_lengkap'])){
    if($_SESSION['sesi_kode_barang_lengkap']!=""){
        //cetak berdasarkan jenis barang BERHASIL SUKSES I
//                      echo "sesi kode barang terset dan ada isi:".$_SESSION['sesi_kode_barang_lengkap'];
        $query = mysqli_query($koneksi, "select * from ((pengeluaran inner join stokbarang on 
pengeluaran.kode_brg=stokbarang.kode_brg) 
inner join permintaan on permintaan.id_sementara=pengeluaran.id_sementara) 
where pengeluaran.tgl_keluar between '$tanggala' and '$tanggalb' and permintaan.status='1' 
and permintaan.kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
and permintaan.unit='$unit'");
    } else if($_SESSION['sesi_kode_barang_lengkap']==""){
//                      echo "sesi kode barang terset dan tidak ada isis cuy:".$_SESSION['sesi_kode_barang_lengkap'];
        $query = mysqli_query($koneksi, "select * from ((pengeluaran inner join stokbarang on 
pengeluaran.kode_brg=stokbarang.kode_brg) 
inner join permintaan on permintaan.id_sementara=pengeluaran.id_sementara) 
where pengeluaran.tgl_keluar between '$tanggala' and '$tanggalb' and permintaan.status='1' 
and permintaan.unit='$unit'");
    }
} else if(!isset($_SESSION['sesi_kode_barang_lengkap'])){
//                  echo "sesi kode barang tidak terset dan tidak ada isis cuy:".$_SESSION['sesi_kode_barang_lengkap'];
    $query = mysqli_query($koneksi, "select * from ((pengeluaran inner join stokbarang on 
pengeluaran.kode_brg=stokbarang.kode_brg) 
inner join permintaan on permintaan.id_sementara=pengeluaran.id_sementara) 
where pengeluaran.tgl_keluar between '$tanggala' and '$tanggalb' and permintaan.status='1' 
and permintaan.unit='$unit'");
}

$query_old_v1 = mysqli_query($koneksi, "select * from ((pengeluaran inner join stokbarang on 
pengeluaran.kode_brg=stokbarang.kode_brg) 
inner join permintaan on permintaan.id_sementara=pengeluaran.id_sementara) 
where pengeluaran.tgl_keluar between '$tanggala' and '$tanggalb' and permintaan.status='1' 
and permintaan.kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
and permintaan.unit='$unit'");


$no= 1;
$i = 2;

while($row = mysqli_fetch_array($query)){

    $sheet->setCellValue('A'.$i,$no++);
    $sheet->setCellValue('B'.$i,$row['tgl_keluar']);
    $sheet->setCellValue('C'.$i,$row['unit']);
    $sheet->setCellValue('D'.$i,$row['kode_brg']);
    $sheet->setCellValue('E'.$i,$row['nama_brg']);
    $sheet->setCellValue('F'.$i,$row['satuan']);
    $sheet->setCellValue('G'.$i,$row['jumlah']);
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
$filename = "Detail_Laporan_Permintaan.xlsx";

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
<?php
session_start();

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tanggala = $_POST['tanggala'];
$tanggalb = $_POST['tanggalb'];
$kode_brg_lengkap = $_POST['kode_brg_lengkap'];

//echo $tanggala.'<br>'.$tanggalb.'<br>'.$kode_brg_lengkap;die;

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





if(isset($_POST['kode_brg_lengkap'])){
    if($_POST['kode_brg_lengkap']!=""){
        //cetak berdasarkan jenis barang BERHASIL SUKSES II
//                   echo "kode brg lengkap terset dan ada ISI YGY";
        $query = mysqli_query($koneksi, "select * from (((pengeluaran inner join stokbarang 
on pengeluaran.kode_brg=stokbarang.kode_brg) inner join permintaan 
on pengeluaran.id_sementara=permintaan.id_sementara) inner join 
sementara on pengeluaran.id_sementara=sementara.id_sementara)
where pengeluaran.tgl_keluar BETWEEN '$tanggala' and '$tanggalb' 
and permintaan.`status`='1' and permintaan.kode_brg='$_POST[kode_brg_lengkap]'");
    } else if($_POST['kode_brg_lengkap']==""){
//                   echo "kode brg lengkap terset dan TIDAK ADA ISI YGY";
        $query = mysqli_query($koneksi, "select * from (((pengeluaran inner join stokbarang 
on pengeluaran.kode_brg=stokbarang.kode_brg) inner join permintaan 
on pengeluaran.id_sementara=permintaan.id_sementara) inner join 
sementara on pengeluaran.id_sementara=sementara.id_sementara)
where pengeluaran.tgl_keluar BETWEEN '$tanggala' and '$tanggalb' 
and permintaan.`status`='1'");
    }
} else if(!isset($_POST['kode_brg_lengkap'])){
//                echo "kode brg lengkap TIDAK terset dan TIDAK ADA ISI YGY";
    $query = mysqli_query($koneksi, "select * from (((pengeluaran inner join stokbarang 
on pengeluaran.kode_brg=stokbarang.kode_brg) inner join permintaan 
on pengeluaran.id_sementara=permintaan.id_sementara) inner join 
sementara on pengeluaran.id_sementara=sementara.id_sementara)
where pengeluaran.tgl_keluar BETWEEN '$tanggala' and '$tanggalb' 
and permintaan.`status`='1'");
}


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
//$write->save('RekapitulasiPermintaan.xlsx');
//echo "<script>window.location='RekapitulasiPermintaan.xlsx'</script>";

$filename = "Rekapitulasi_Laporan_Permintaan.xlsx";

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
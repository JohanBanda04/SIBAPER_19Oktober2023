<?php 
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

ob_start(); 
$id  = isset($_GET['id']) ? $_GET['id'] : false;


$unit = $_GET['unit'];
$tgl= $_GET['tgl'];

?>
<!-- Setting CSS bagian header/ kop -->
<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
  

</style>
<!-- Setting Margin header/ kop -->
<!-- Setting CSS Tabel data yang akan ditampilkan -->
<style type="text/css">
 .tabel2 {
  border-collapse: collapse;
  margin-left: 5px;
}
.tabel2 th, .tabel2 td {
  padding: 5px 5px;
  border: 1px solid #000;
}
div.kanan {
 width:300px;
 float:right;
 margin-left:210px;
 margin-top:-235px;
}

div.kiri {
 width:300px;
 float:left;
 margin-left:30px;
 display:inline;
}

</style>
<table>
  <tr>
      <th rowspan="3"><img src="../gambar/icon_pengayoman.jpeg" style="width:90px;height:100px" /></th>
      <td align="center" style="width: 520px;"><font style="font-size: 18px">KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA  <br> <b>REPUBLIK INDONESIA</b>
              <br><b>KANTOR WILAYAH NUSA TENGGARA BARAT</b></font>
          <br>Jalan Majapahit No. 44 Mataram Telepon : (0370) 7856244 Fax : 625341<br>Laman : ntb.kemenkumham.go.id , Email : kanwilntb@kemenkumham.go.id</td>



    </tr>
  </table>
  <hr>
  <p align="center" style="font-weight: bold; font-size: 18px;"><u>FORM PENGAJUAN BARANG</u></p>
  <div class="isi" style="margin: 0 auto;">
    <p style="color: black; text-align: left;">Permintaan Pembelian Barang  <br>Pada Tanggal : <b> <?=  tanggal_indo($tgl); ?> </b></p>
    <table class="tabel2">
      <thead>
        <tr>
          <td style="text-align: center; width=10px;"><b>No.</b></td>        
          <td style="text-align: center; width=90px;"><b>Kode Barang</b></td>
          <td style="text-align: center; width=150px;"><b>Nama Barang</b></td>
          <td style="text-align: center; width=50px;"><b>Satuan</b></td>
          <td style="text-align: center; width=90px;"><b>Harga Barang</b></td>
          <td style="text-align: center; width=50px;"><b>Jumlah</b></td>

          <td style="text-align: center; width=70px;"><b>Total</b></td>
        </tr>
      </thead>
      <tbody>
        <?php


        $query_bk = mysqli_query($koneksi, "SELECT  pengajuan.kode_brg, 
nama_brg, pengajuan.jumlah,pengajuan.satuan, pengajuan.hargabarang, pengajuan.total, tgl_pengajuan 
FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg  WHERE tgl_pengajuan='$tgl' and pengajuan.status='1'");

        $query = mysqli_query($koneksi, "SELECT  pengajuan.kode_brg, 
nama_brg, pengajuan.jumlah,pengajuan.satuan, pengajuan.hargabarang, pengajuan.total, tgl_pengajuan 
FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg  
WHERE tgl_pengajuan='$tgl' and unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' ");

        $i   = 1; 
        while($data=mysqli_fetch_array($query))
        {
          ?>

          <tr>
            <td style="text-align: center; font-size: 12px;"><?php echo $i; ?></td>             
            <td style="text-align: center; font-size: 12px;"><?php echo $data['kode_brg']; ?></td>
            <td style="text-align: left; font-size: 12px;"><?php echo $data['nama_brg']; ?></td>
            <td style="text-align: center; font-size: 12px;"><?php echo $data['satuan']; ?></td>
            <td style="text-align: center; font-size: 12px;"><?php echo number_format($data['hargabarang']); ?></td>
            <td style="text-align: center; font-size: 12px;"><?php echo $data['jumlah']; ?></td>

            <td style="text-align: center; font-size: 12px;"><?php echo number_format($data['total']); ?></td>

          </tr>
          <?php
          $i++;

        }
        ?>
      </tbody>
      <?php 

      $query2 = mysqli_query($koneksi, "SELECT SUM(jumlah), SUM(hargabarang), SUM(total) FROM pengajuan WHERE unit='$unit' AND tgl_pengajuan='$tgl' ");  
      $data2 = mysqli_fetch_assoc($query2);

      ?>
    </table>
  </div>
    <?php
        $dt_query = mysqli_query($koneksi, "SELECT  pengajuan.id_pengajuan ,pengajuan.id_pengajuan_sementara,pengajuan.kode_brg, nama_brg, pengajuan.jumlah
,pengajuan.satuan, pengajuan.hargabarang, pengajuan.total, pengajuan_sementara.tgl_pengajuan 
FROM ((pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg ) 
inner join pengajuan_sementara on pengajuan_sementara.id_pengajuan_sementara=pengajuan.id_pengajuan_sementara)
WHERE pengajuan_sementara.unit='$_SESSION[username]' and pengajuan_sementara.user_id='$_SESSION[user_id]' 
AND pengajuan_sementara.tgl_pengajuan='$tgl' ");

        $total_jumlah = 0 ;
        $total_harga_barang = 0 ;
        $total_harga_barang_semua = 0 ;

        foreach ($dt_query as $id=>$val){
            $total_jml = $val['jumlah'];
            $total_hrg_brg = $val['hargabarang'];
            $total_hrg_brg_smw = $val['jumlah']*$val['hargabarang'];

            $total_jumlah += $total_jml;
            $total_harga_barang += $total_hrg_brg;
            $total_harga_barang_semua += $total_hrg_brg_smw;
        }

//        echo $total_jumlah.'--';
//        echo $total_harga_barang.'--';
//        echo $total_harga_barang_semua.'--';
    ?>
  <table class="tabel2">
      <tr>
          <td style="text-align: center; width=482px;"><b>Sub Totaal</b></td>
          <td style="text-align: center; width=50px;"><b><?php echo number_format($total_jumlah)?></b></td>
          <td style="text-align: center; width=70px;"><b>Rp.<?php echo number_format($total_harga_barang_semua)?>.-</b></td>
      </tr>
  </table>




  <div class="kiri">
      <?php
        $query_get_user = mysqli_query($koneksi,"select * from user where id_user='$_SESSION[user_id]'");
        $item = mysqli_fetch_assoc($query_get_user);
      ?>
    <p> </p>
    <p>Diajukan Oleh :<br><?php echo $item['jabatan']?>  </p>
    <p></p>
    <p></p>
<!--    <b><p><u>Siti Rusdah </u><br>NIK: 198507122010012039</p></b>-->
    <b><p><u><?php echo $item['nama_lengkap'];?></u><br>NIP: <?php echo $item['nik']; ?></p></b>
    <br>
    <br>
    <br>


  </div>



  <div class="kanan">
    <p></p>
<!--    <p>Disetujui Oleh :<br>Lurah </p>-->
    <p>Disetujui Oleh :<br>Yg Menyetujui </p>
    <p></p>
    <p> </p>       
<!--    <b><p><u>Darsito, S.Sos </u><br>NIK: 196606051986031015</p></b>-->
    <b><p><u>Nama </u><br>NIP: ..........</p></b>
    <br>
    <br>
    <br>

  </div>

  <!-- Memanggil fungsi bawaan HTML2PDF -->
  <?php
  $content = ob_get_clean();
  include '../assets/html2pdf_backup/html2pdf.class.php';
  try
  {
    $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('bukti_permintaan_dan_pengeluaran_barang.pdf');
  }
  catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
  }
  ?>
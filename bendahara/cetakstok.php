<?php ob_start(); ?>
<!-- Setting CSS bagian header/ kop -->
<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
  h1 {color: #000033}
  h2 {color: #000055}
  h3 {color: #000077}
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
   margin-left:180px;
   margin-top:-140px;
 }

 div.kiri {
   width:300px;
   float:left;
   margin-left:30px;
   display:inline;
 }

</style>
<table>
  <?php 
  include "../fungsi/koneksi.php";
  $id = isset($_GET['idjenis']) ? $_GET['idjenis'] : "";
  switch($id) {
    case 1 :
    $material = "ATK";
    break;
    default:
    $material = "";
  }

  ?>
<!--  <tr>-->
<!--    <th rowspan="3"><img src="../gambar/jy.png" style="width:100px;height:100px" /></th>-->
<!--    <td align="center" style="width: 520px;"><font style="font-size: 18px"><b>PEMERINTAH KOTA JAKARTA <br> KELURAHAN JATINEGARA KAUM</b></font>-->
<!--      <br>Jl. TB. Badaruddin No. 1 RT.1/RW.5, Kel. Jatinegara Kaum, Kec. Pulo Gadung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13250 <br> Telp : (021) 4751119</td>-->
<!---->
<!--    </tr>-->
    <tr>

        <!--            <th rowspan="3"><img src="../gambar/lobar_logo.png" style="width:90px;height:100px" /></th>-->
        <th rowspan="3"><img src="../gambar/icon_pengayoman.jpeg" style="width:90px;height:100px" /></th>
        <td align="center" style="width: 550px; ">
            <font style="font-size: 18px">
                KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA
                <br>
                REPUBLIK INDONESIA
                <br>
                KANTOR WILAYAH NUSA TENGGARA BARAT
                <br>
                <b>KANTOR IMIGRASI KELAS II TPI SUMBAWA BESAR </b>
            </font>
            <br>
            Jalan Garuda No. 131, Sumbawa Besar 84351 Telepon: (0370) 626642
            <br>
            Laman: kanimsumbawa.kemenkumham.go.id ; Surel: kanimsumbawa@kemenkumham.go.id
        </td>

    </tr>
  </table>
  <hr>
  <?php 

  $query2 = mysqli_query($koneksi, "SELECT jenis_brg FROM jenis_barang  WHERE id_jenis='$id' ");
  if ($query2){                
    $data = mysqli_fetch_assoc($query2);

  } else {
    echo 'gagal';
  }
  ?>
  <p align="center" style="font-weight: bold; font-size: 18px;"><u>LAPORAN DATA STOK BARANG <?= $data['jenis_brg'] ?></u></p>
  <table class="tabel2">
    <thead>
      <tr>
        <td style="text-align: center; "><b>No.</b></td>
        <td style="text-align: center; "><b>Kode Barang</b></td>
        <td style="text-align: center; "><b>Nama Barang</b></td>
<!--        <td style="text-align: center; "><b>Harga Barangs</b></td>-->
        <td style="text-align: center; "><b>Satuan</b></td>
        <td style="text-align: center; "><b>Masuk</b></td>
        <td style="text-align: center; "><b>Keluar</b></td>
        <td style="text-align: center; "><b>Sisa</b></td>
        <td style="text-align: center; "><b>Keterangan</b></td>

      </tr>
    </thead>
    <tbody>
      <?php

      $total_brg_masuk = 0;
      $total_brg_keluar = 0;
      $total_brg_sisa = 0;
      $sql = mysqli_query($koneksi, "SELECT * FROM stokbarang WHERE id_jenis = '$id' ");
      $i   = 1;
      while($data=mysqli_fetch_array($sql))
      {
        ?>
        <tr>
          <td style="text-align: center; width=15px; font-size: 12px;"><?php echo $i; ?></td>
          <td style="text-align: center; width=110px; font-size: 12px;"><?php echo $data['kode_brg']; ?></td>
          <td style="text-align: left; width=150px; font-size: 12px;"><?php echo $data['nama_brg']; ?></td>
<!--          <td style="text-align: center; width=70px; font-size: 12px;">--><?php //echo number_format($data['hargabarang']); ?><!--</td> -->
          <td style="text-align: center; width=30px; font-size: 12px;"><?php echo $data['satuan']; ?></td>
          <td style="text-align: center; width=30px; font-size: 12px;"><?php echo $data['stok']; ?></td>
          <td style="text-align: center; width=30px; font-size: 12px;"><?php echo $data['keluar']; ?></td>
          <td style="text-align: center; width=30px; font-size: 12px;"><?php echo $data['sisa']; ?></td>
          <td style="text-align: center; width=130px; font-size: 12px;"><?php echo $data['keterangan']; ?></td>

        </tr>
        <?php
        $i++;
        $total_brg_masuk += $data['stok'];
        $total_brg_keluar += $data['keluar'];
        $total_brg_sisa += $data['sisa'];
      }

      ?>
      <tr>
          <td style="border-right-color:white; text-align: center; width=15px; font-size: 12px;"></td>
          <td style="border-right-color:white; text-align: center; width=110px; font-size: 12px;">
               <b>Total</b>
          </td>
          <td style="border-right-color:white; text-align: left; width=150px; font-size: 12px;"></td>
          <!--          <td style="text-align: center; width=70px; font-size: 12px;">--><?php //echo number_format($data['hargabarang']); ?><!--</td> -->
          <td style=" text-align: center; width=30px; font-size: 12px;"></td>
          <td style=" text-align: center; width=30px; font-size: 12px;">
              <b><?php echo $total_brg_masuk; ?></b>
          </td>
          <td style=" text-align: center; width=30px; font-size: 12px;">
              <b><?php echo $total_brg_keluar; ?></b>
          </td>
          <td style=" text-align: center; width=30px; font-size: 12px;">
              <b><?php echo $total_brg_sisa; ?></b>
          </td>
          <td style="text-align: center; width=130px; font-size: 12px;"></td>

      </tr>
      <?php
      ?>
    </tbody>
  </table>
  
  <div class="kiri">
    <p>Diketahui :<br>Kasubbag</p>
    <br>
    <br>
    <br>
    <p><b><u>Nama Kasubbag</u><br>NIK : ..................</b></p>
  </div>

  <div class="kanan">
    <p>Mengetahui :<br>Pengelola </p>
    <br>
    <br>
    <br>
    <p><b><u>Nama Pengelola Persediaan Barang</u><br>NIK : ..................</b></p>
  </div>

  <!-- Disini Set Cetak PDF untuk Olah Data Stok Barang  ATK -->
  <!-- Memanggil fungsi bawaan HTML2PDF -->
  <?php
  $content = ob_get_clean();
  include '../assets/html2pdf_backup/html2pdf.class.php';
  try
  {
    $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('laporan_stok_material_teknik.pdf');
  }
  catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
  }
  ?>
<?php
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

ob_start(); 
$id  = isset($_GET['id']) ? $_GET['id'] : false;

$tanggala=$_POST['tanggala'];
$tanggalb=$_POST['tanggalb'];
$unit=$_POST['unit'];
//echo $unit; die;

$query_get_pengaju = mysqli_query($koneksi, "Select * from `user` where username='$unit'");
//echo mysqli_fetch_assoc($query_get_pengaju)['id_user']; die;
$id_lengkap_pengaju_brg = mysqli_fetch_assoc($query_get_pengaju)['id_user'];

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
  margin-left: 20px;
}
.tabel2 th, .tabel2 td {
  padding: 5px 5px;
  border: 1px solid #000000;
}
.tabelatas{

  margin-left: 20px;
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
  margin-left:20px;
  display:inline;
}

</style>
<table>
  <tr>

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


<!--    <th rowspan="3"><img src="../gambar/jy.png" style="width:100px;height:100px" /></th>-->
<!--    <td align="center" style="width: 520px;"><font style="font-size: 18px"><b>PEMERINTAH KOTA JAKARTA  <br> KELURAHAN JATINEGARA KAUM</b></font>-->
<!--      <br>Jl. TB. Badaruddin No. 1 RT.1/RW.5, Kel. Jatinegara Kaum, Kec. Pulo Gadung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13250 <br>Telp : (021) 4751119</td>-->
      
    </tr>
  </table>
  <hr>
  <p align="center" style="font-weight: bold; font-size: 18px;"><u>LAPORAN PENGAJUAN BARANG</u></p>

  <div class="isi" style="margin: 0 auto;">

    <?php 

    $query2 = mysqli_query($koneksi, "SELECT jabatan FROM user WHERE username='$unit' ");
    if ($query2){                
      $data = mysqli_fetch_assoc($query2);

    } else {
      echo 'gagal';
    }
    ?>
    <table class="tabelatas">

      <tr>
        <td style="text-align: left; width=80px;  "><b>Periode </b></td>   
        <td style="text-align: left; "><b>: <?= tanggal_indo($tanggala); ?> S/d  <?= tanggal_indo($tanggalb);?></b></td>       
      </tr>
      <tr>
        <td style="text-align: left; width=80px;  "><b>Nama </b></td>
          <?php
          $query_get_nama_pengaju = mysqli_query($koneksi, "Select nama_lengkap from `user` where username='$unit'");

          ?>
        <td style="text-align: left; "><b>: <?php echo mysqli_fetch_assoc($query_get_nama_pengaju)['nama_lengkap'];?></b></td>
      </tr>
      <tr>
        <td style="text-align: left; width=80px;  "><b>Level </b></td>
        <td style="text-align: left; "><b>: <?php if ($data['jabatan']=="Operator"){
                echo "Pengelola Persediaan Barang";
                } ?></b></td>
      </tr>

    </table>
    
    <br>
    <table class="tabel2">      
      <thead>
        <tr>
         <td style="text-align: center; width=10px;"><b>No.</b></td>
         <td style="text-align: center; width=40px;"><b>Kode Barang</b></td>
         <td style="text-align: center; width=100px;"><b>Nama Barang</b></td>
         <td style="text-align: center; width=50px;"><b>Satuan</b></td>
         <td style="text-align: center; width=50px;"><b>Tgl Pengajuan</b></td>
         <td style="text-align: center; width=50px;"><b>Harga Barang</b></td>
         <td style="text-align: center; width=60px;"><b>Jumlah</b></td>
         <td style="text-align: center; width=70px;"><b>Total</b></td>                            
       </tr>
     </thead>
     <tbody>
      <?php

      $query_get_nama_pengaju = mysqli_query($koneksi, "Select * from `user` where username='$unit'");
      $nama_lengap_pengaju = mysqli_fetch_assoc($query_get_nama_pengaju)['nama_lengkap'];
      $user_id_pengaju = mysqli_fetch_assoc($query_get_nama_pengaju)['id_user'];


      $query = mysqli_query($koneksi, "SELECT  pengajuan.kode_brg, nama_brg, pengajuan.jumlah
,pengajuan.satuan, pengajuan.hargabarang, pengajuan.total, tgl_pengajuan 
FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg  
WHERE unit='$nama_lengap_pengaju' AND tgl_pengajuan BETWEEN '$tanggala' and '$tanggalb' ");
      $i   = 1;

      $dt_total_harga_barang_= 0;
      echo $user_id_pengaju;
      while($data=mysqli_fetch_array($query))

      {

        ?>

        <tr>
          <td style="text-align: center; font-size: 12px;"><?php echo $i ; ?></td>
          <td style="text-align: center; font-size: 12px;"><?php echo $data['kode_brg']; ?></td>
          <td style="text-align: left; font-size: 12px;"><?php echo $data['nama_brg']; ?></td>
          <td style="text-align: center; font-size: 12px;"><?php echo $data['satuan']; ?></td>
          <td style="text-align: center; font-size: 12px;"><?php echo tanggal_indo($data['tgl_pengajuan']); ?></td>
          <td style="text-align: center; font-size: 12px;"><?php echo number_format($data['hargabarang']); ?></td>
          <td style="text-align: center; font-size: 12px;"><?php echo $data['jumlah']; ?></td>
            <td style="text-align: center; font-size: 12px;"><?php echo number_format($data['jumlah']*$data['hargabarang']); ?></td>
        </tr>
        <?php
        $i++;
        ?>


          <?php
      }
      ?>
      <tr>
          <?php

          $query2_bk_1 = mysqli_query($koneksi, "SELECT SUM(jumlah), SUM(hargabarang), SUM(total) 
FROM pengajuan WHERE unit='$unit' AND unit='$unit' AND tgl_pengajuan 
BETWEEN '$tanggala' and '$tanggalb' ");
          $data2_bk_1 = mysqli_fetch_assoc($query2_bk_1);

          $query2_bk_2 = mysqli_query($koneksi, "SELECT  pengajuan.kode_brg, nama_brg, pengajuan.jumlah
,pengajuan.satuan, pengajuan.hargabarang, pengajuan.total, tgl_pengajuan 
FROM pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg  
WHERE unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' AND tgl_pengajuan 
BETWEEN '$tanggala' and '$tanggalb' ");


          $query2 = mysqli_query($koneksi, "SELECT  pengajuan.id_pengajuan ,pengajuan.id_pengajuan_sementara,pengajuan.kode_brg, nama_brg, pengajuan.jumlah
,pengajuan.satuan, pengajuan.hargabarang, pengajuan.total, pengajuan_sementara.tgl_pengajuan 
FROM ((pengajuan INNER JOIN stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg ) 
inner join pengajuan_sementara on pengajuan_sementara.id_pengajuan_sementara=pengajuan.id_pengajuan_sementara)
WHERE pengajuan_sementara.unit='$nama_lengap_pengaju' and 
pengajuan_sementara.user_id='$id_lengkap_pengaju_brg' AND pengajuan_sementara.tgl_pengajuan 
BETWEEN '$tanggala' and '$tanggalb' ");
          //  $data2 = mysqli_fetch_assoc($query2);

          //  $data2 = mysqli_fetch_array($query2);

          $total_jumlah = 0 ;
          $total_harga_barang = 0 ;
          $total_harga_barang_semua = 0 ;

          //metode penggunaan foreach di php native
          foreach ($query2 as $id=>$val){
              $total_jml = $val['jumlah'];
              $total_hrg_brg = $val['hargabarang'];
              $total_hrg_brg_smw = $val['jumlah']*$val['hargabarang'];

              $total_jumlah += $total_jml;
              $total_harga_barang += $total_hrg_brg;
              $total_harga_barang_semua += $total_hrg_brg_smw;
          }

          ?>
          <td style="border-right-color: white; text-align: center; font-size: 12px;"></td>
          <td style="border-right-color: white; text-align: center; font-size: 12px;"><b>Total</b></td>
          <td style="border-right-color: white; text-align: left; font-size: 12px;"></td>
          <td style="border-right-color: white; text-align: center; font-size: 12px;"></td>
          <td style="border-right-color: white; text-align: center; font-size: 12px;"></td>
          <td style="text-align: center; font-size: 12px;"></td>
          <td style="text-align: center; font-size: 12px;"><b><?php echo number_format($total_jumlah); ?></b></td>
          <td style="text-align: center; font-size: 12px;"><b>Rp.<?php echo number_format($total_harga_barang_semua)?></b></td>
      </tr>
      <?php
      ?>
    </tbody>
  </table>



</div>


<!--<div class="kiri">-->
<!--  <p> </p>-->
<!--  <p>Diminta Oleh :<br>Bendahara  </p>-->
<!--  <p></p>-->
<!--  <p></p>-->
<!--  <b><p><u>Siti Rusdah </u><br>NIK: 198507122010012039</p></b>-->
<!--  <br>-->
<!--  <br>-->
<!--  <br>-->
<!--</div>-->

    <div class="kiri">
        <?php
        $query_get_user = mysqli_query($koneksi,"select * from user where id_user='$_SESSION[user_id]'");
        $item = mysqli_fetch_assoc($query_get_user);
        ?>
        <p> </p>
        <p>Diajukan Oleh :<br><?php if($item['jabatan']=="Operator"){
            echo "Pengelola Persediaan Barang";
            } ?>  </p>
        <p></p>
        <p></p>
        <!--    <b><p><u>Siti Rusdah </u><br>NIK: 198507122010012039</p></b>-->
        <b><p><u><?php echo $item['nama_lengkap'];?></u><br>NIP: <?php echo $item['nik']; ?></p></b>
        <br>
        <br>
        <br>


    </div>

<!--<div class="kanan">-->
<!--  <p></p>-->
<!--  <p>Disetujui Oleh :<br>Lurah </p>-->
<!--  <p></p>-->
<!--  <p> </p>-->
<!--  <b><p><u>Darsito, S.Sos </u><br>NIK: 196606051986031015</p></b>-->
<!--  <br>-->
<!--  <br>-->
<!--  <br>-->
<!---->
<!--</div>-->

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
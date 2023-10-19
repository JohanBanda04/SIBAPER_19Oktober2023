<?php  
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if (isset($_GET['aksi']) && isset($_GET['tgl'])) {
        //die($id = $_GET['id']);
  $tgl = $_GET['tgl'];
  echo $tgl;

  if ($_GET['aksi'] == 'detil') {
    header("location:?p=detil&tgl=$tgl");
  } 
}

$query_bk = mysqli_query($koneksi, "SELECT unit, tgl_pengajuan, count(kode_brg) 
FROM pengajuan WHERE unit= '$_SESSION[username]'  GROUP BY tgl_pengajuan");

$query_bk_2 = mysqli_query($koneksi, "	SELECT *, count(kode_brg) 
FROM pengajuan WHERE unit= '$_SESSION[username]' and user_id='$_SESSION[user_id]' 
and !isnull(id_pengajuan_sementara) GROUP BY tgl_pengajuan DESC");

$query = mysqli_query($koneksi, "	SELECT *, count(pengajuan.kode_brg) 
FROM  (pengajuan inner join pengajuan_sementara on pengajuan.id_pengajuan_sementara=pengajuan_sementara.id_pengajuan_sementara) 
WHERE pengajuan_sementara.unit='$_SESSION[username]' and pengajuan_sementara.user_id='$_SESSION[user_id]' 
and !isnull(pengajuan_sementara.id_pengajuan_sementara) GROUP BY pengajuan_sementara.tgl_pengajuan DESC");

?>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-sm-12">
     <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="text-center">Data Pengaajuan Barang</h3>
      </div>                
      <div class="box-body">
        <a href="index.php?p=formpengajuan" style="margin:10px 15px;" class="btn btn-success"><i class='fa fa-plus'> Form Pengajuan Barang</i></a>
        <div class="table-responsive">
          <table class="table text-center">
            <thead  > 
              <tr>
                <th>No</th>                                                                                             
                <th>Tanggal Pengajuan</th>
                <th>User</th>
                
                <th>Aksi</th>
                <th>Cetak</th>
                
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php 
                $no =1 ;
                if (mysqli_num_rows($query)) {
                  while($row=mysqli_fetch_assoc($query)):

                   ?>
                   <td> <?= $no; ?> </td>                                      
                   <td> <?= tanggal_indo($row['tgl_pengajuan']); ?> </td> 
                   <td> <?= $row['unit']; ?> </td>
                   
                   <td>
                       <?php

                       if($row['status_pengajuan']!='Input Pengajuan Ke Stok'){?>
                       <a href="?p=detilpengajuan&unit=<?= $row['unit'];?>&tgl_pengajuan=<?= $row['tgl_pengajuan']; ?>&user_id=<?php echo $row['user_id'];?>">
                           <span data-placement='top' data-toggle='tooltip' title='Input Barang Masuk'>
                               <button class="btn btn-info">Input Barang Masuk</button>
                           </span>
                       </a>
                       <?php
                       } else if ($row['status_pengajuan']='Input Pengajuan Ke Stok'){ ?>
                           <a href="#">
                           <span data-placement='top' data-toggle='tooltip' title='Riil Sudah Diinput Ke Stok Barang'>
                               <button class="btn btn-info">Sudah Diinput Ke Stok Barang</button>
                           </span>
                           </a>
                       <?php }
                       ?>
<!--                       <a href="?p=detilpengajuan&unit=--><?//= $row['unit'];?><!--&tgl_pengajuan=--><?//= $row['tgl_pengajuan']; ?><!--&user_id=--><?php //echo $row['user_id'];?><!--">-->
<!--                           <span data-placement='top' data-toggle='tooltip' title='Input Barang Masuk'>-->
<!--                               <button class="btn btn-info">Input Barang Masuk</button>-->
<!--                           </span>-->
<!--                       </a>-->
                   </td>
                   <td>
                       <a target="_blank" href="cetakpengajuan.php?&tgl=<?= $row['tgl_pengajuan']; ?>&unit=<?= $row['unit']; ?>">
                           <span data-placement='top' data-toggle='tooltip' title='Cetak'>
                               <button class="btn btn-success">
                                   <i class="fa fa-print"> Cetak Pengajuan Barang</i>
                               </button>
                           </span>
                       </a>

                   </tr>    

                   <?php $no++; endwhile; }else {echo "<tr><td colspan=9>Tidak ada permintaan material teknik.</td></tr>";} ?>

                 </tbody>
               </table>
             </div>                  
           </div>
         </div>
       </div>
     </div>


   </section>


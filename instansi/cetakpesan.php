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

$query_old_1 = mysqli_query($koneksi, "SELECT unit, instansi, tgl_permintaan, count(kode_brg)  
FROM permintaan WHERE unit= '$_SESSION[username]' AND status=1  GROUP BY tgl_permintaan DESC");

//disini
$query_old_2 = mysqli_query($koneksi, "select * from ((sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) inner join
stokbarang on sementara.kode_brg=stokbarang.kode_brg) where sementara.unit='$_SESSION[username]' 
and sementara.user_id='$_SESSION[user_id]' and sementara.status_acc='Selesai'
and permintaan.status='1' group by sementara.bendahara_id,sementara.tgl_permintaan");

$query_bk = mysqli_query($koneksi, "SELECT sementara.bendahara, sementara.bendahara_id, 
sementara.unit, sementara.instansi, sementara.tgl_permintaan, 
count(sementara.kode_brg)  
FROM (permintaan inner join sementara on permintaan.id_sementara=sementara.id_sementara) WHERE 
sementara.unit= '$_SESSION[username]' AND sementara.user_id='$_SESSION[user_id]' 
AND permintaan.status=1  GROUP BY sementara.bendahara_id,tgl_permintaan DESC");

$query = mysqli_query($koneksi, "SELECT 
sementara.unit, sementara.instansi, sementara.tgl_permintaan, 
count(sementara.kode_brg),sementara.bendahara, sementara.bendahara_id  
FROM (permintaan inner join sementara on permintaan.id_sementara=sementara.id_sementara) WHERE 
sementara.unit= '$_SESSION[username]' AND sementara.user_id='$_SESSION[user_id]' 
AND permintaan.status=1  GROUP BY sementara.bendahara_id,sementara.tgl_permintaan DESC");

//penggunaan select all dan additional column lainnya
$query_bk_3 = mysqli_query($koneksi, "select *, count(sementara.kode_brg) from  (permintaan inner join sementara on permintaan.id_sementara=sementara.id_sementara) WHERE 
sementara.unit= '$_SESSION[username]' AND sementara.user_id='$_SESSION[user_id]' 
AND permintaan.status=1  GROUP BY sementara.bendahara_id,sementara.tgl_permintaan DESC");

?>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-sm-12">
     <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="text-center"><strong>sCetak</strong> BBUKTI PENGELUARAN PERMINTAAN BARANG <strong>(BPP) telah disetujui</strong>
        </h3>
      </div>                
      <div class="box-body">
        <div class="table-responsive">
          <table class="table text-center">
            <thead  style="background-color: #b6eee0">
              <tr>
                <th style="color: black">No</th>
                <th style="color: black">Tanggal Permintaan</th>
                <th style="color: black">Bendahara</th>
                <th style="color: black">Jumlah Permintaan</th>
                <th style="color: black">Aksi</th>
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
                   <td> <?= tanggal_indo($row['tgl_permintaan']); ?> </td>  
                   <td> <?= $row['bendahara']; ?> </td>
                   <td> <?= $row['count(sementara.kode_brg)']; ?> </td>
                   <td>        
                    <a target="_blank" href="cetakpesanan.php?&tgl=<?= $row['tgl_permintaan']; ?>&unit=<?= $row['unit']; ?>&instansi=<?= $row['instansi']; ?>&bendahara=<?= $row['bendahara']; ?>&bendahara_id=<?= $row['bendahara_id']; ?>">
                        <span data-placement='top' data-toggle='tooltip' title='Cetak BPP'>
                            <button class="btn btn-success" style="background-color: #10d4cb">
                                <i class="fa fa-print" style=""> sCetak BPP </i>
                            </button>
                        </span>
                    </a>
                  </td>
                </tr>        

                <?php $no++; endwhile; }else {echo "<tr><td colspan=9>Belum ada BPP yang akan dicetak</td></tr>";} ?>

              </tbody>
            </table>
          </div>                  
        </div>
      </div>
    </div>
  </div>


</section>


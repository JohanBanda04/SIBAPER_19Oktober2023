<?php  
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if (isset($_GET['tgl_pengajuan']) && isset($_GET['unit'])) {
    $tgl_pengajuan = isset($_GET['tgl_pengajuan'])? $_GET['tgl_pengajuan']:'';
    $unit = isset($_GET['unit'])? $_GET['unit']:'';
    $user_id = isset($_GET['user_id'])? $_GET['user_id']:'';
//    $unit = $_GET['unit'];
//    $user_id = $_GET['user_id'];

    echo $tgl_pengajuan.'::';
    echo $unit.'::';
    echo $user_id.'::';

    $query_bk = mysqli_query($koneksi, "SELECT pengajuan.tgl_pengajuan, pengajuan.id_pengajuan, pengajuan.kode_brg, pengajuan.jumlah, pengajuan.hargabarang, pengajuan.total, pengajuan.status,   stokbarang.nama_brg, stokbarang.satuan FROM pengajuan INNER JOIN 
        stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg  WHERE tgl_pengajuan='$tgl_pengajuan' AND unit='$unit' AND status!=1");

    $query_bk_2 = mysqli_query($koneksi, "SELECT * FROM pengajuan INNER JOIN 
        stokbarang ON pengajuan.kode_brg = stokbarang.kode_brg  WHERE 
        tgl_pengajuan='$tgl_pengajuan' AND unit='$_SESSION[username]' AND user_id='$_SESSION[user_id]' and status!=1");

    $query = mysqli_query($koneksi, "select * from ((pengajuan inner join pengajuan_sementara 
on pengajuan.id_pengajuan_sementara=pengajuan_sementara.id_pengajuan_sementara) inner join stokbarang
on pengajuan_sementara.kode_brg=stokbarang.kode_brg)
where pengajuan_sementara.tgl_pengajuan='$tgl_pengajuan' and pengajuan_sementara.unit='$_SESSION[username]' 
and pengajuan_sementara.user_id='$_SESSION[user_id]' and pengajuan.status!='1'");
    
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'edit')
        header("location:?p=editpesan");
}

?>
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
         <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="text-center">IInput Barang Masuk</h3>
                <h3 class="text-center">Username <?php echo $unit; ?></h3>
            </div>
            <div class="box-body">
                <a href="index.php?p=datapengajuan" style="margin:10px;" class="btn btn-success"><i class='fa fa-backward'>  Kembali</i></a>
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead  >
                            <tr>
                                <th>No</th>
                                <th>IPS</th>
                                <th>IP</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Harga Barang</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
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
                                     <td> <?= $row['id_pengajuan_sementara']; ?> </td>
                                     <td> <?= $row['id_pengajuan']; ?> </td>
                                     <td> <?= $row['kode_brg']; ?> </td>
                                     <td> <?= $row['nama_brg']; ?> </td>
                                     <td> <?= $row['satuan']; ?> </td>
                                     <td> <?= $row['jumlah']; ?> </td>
                                     <td> <?= number_format($row['hargabarang']); ?> </td>
                                     <td> <?= number_format($row['total']); ?> </td>
                                     <td > <?php
                                     if ($row['status'] == 0){
                                        echo '<span class=text-warning>Data Stok Belum Tersimpan</span>';
                                    } elseif ($row['status'] == 1) {
                                        echo '<span class=text-primary>Telah Masuk Ke Stok Barang</span>';
                                    } else {
                                        echo '<span class=text-danger>Dibatalkan</span>';
                                    }
                                    ?>
                                </td>
                                <td>

                                    <form style="alignment: center" method="post" action="setujuipengajuanbarang.php">
                                            <!--lanjut pemberian rata tengah utk tombol 'MMasukan Ke Stok Barang'-->
                                            <input class="hidden" type="text" name="id_pengajuan" value="<?php echo $row['id_pengajuan']; ?>">
                                            <input class="hidden" type="text" name="id_pengajuan_sementara" value="<?php echo $row['id_pengajuan_sementara']; ?>">
                                            <input onclick="return confirm('Masukkan Barang ke Stok?')"
                                                   type="submit" id="setujui_pengajuan_barang"
                                                   name="setujui_pengajuan_barang"
                                                   style="background-color: #1b860c; margin-left: 1px"
                                                   class="btn btn-primary col-sm-offset-3"
                                                   value="MMasukan Ke Stok Barang">


                                    </form>
                                    <a class="hide"
                                       href="setujupengajuan.php?id_pengajuan=<?= $row['id_pengajuan']; ?>&id_pengajuan_sementara=<?php echo $row['id_pengajuan_sementara'];?>">
                                        <span data-placement='top' data-toggle='tooltip' title='Masukkan Ke Stok Barang'>
                                            <button   class="btn btn-success">
                                                MMasukan Ke Stok Barang
                                            </button>
                                        </span>
                                    </a>




                                </td>
                            </tr>

                            <?php $no++; endwhile; }else {echo "<tr><td colspan=9>Tidak ada Data.</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


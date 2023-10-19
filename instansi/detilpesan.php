<?php  

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
if (isset($_GET['tgl'])) {
    $tgl = $_GET['tgl'];


    $query_bk_1= mysqli_query($koneksi,"select * from sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and tgl_permintaan='$tgl' ");

    $query = mysqli_query($koneksi," select * from sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and tgl_permintaan='$tgl' and 
status_acc in('Pengajuan Kasub','setuju','tidak_setuju')");
    
}

if(isset($_GET['aksi']) && isset($_GET['id'])) {
    $aksi = $_GET['aksi'];
    $id = $_GET['id'];
    if ($aksi == 'hapus') {
        $query2 = mysqli_query($koneksi, "DELETE FROM permintaan WHERE id_permintaan='$id' ");
        if ($query2) {
            header("location:?p=detil&tgl=".$tgl);
        } else {
            echo 'gagal';
        }
    }
}
?>

<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
           <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="text-center">ssData Permintaan Barang Tanggal <strong><?php echo tanggal_indo($tgl); ?></strong></h3>
            </div>
            <div class="box-body">                   
                <a href="index.php?p=datapesanan" style="margin:10px;background-color: #486055" class="btn btn-success"><i class='fa fa-backward'>  Kembali</i></a>
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead style="background-color: #b6eee0; font-weight: bold" >
                            <tr>
                                <th style="color: black">No</th>
                                <th style="color: black">Id Sementara</th>
                                <th style="color: black">Kode Barang</th>
                                <th style="color: black">Nama Barang</th>
                                <th style="color: black">Satuan</th>
                                <th style="color: black">Jumlah</th>
                                <th style="color: black">Status</th>
                                <th style="color: black">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $no = 1;
                        if(mysqli_num_rows($query)){
                            //disini metode post
                            while($row= mysqli_fetch_assoc($query)){ ?>
                                <form method="post" action="permintaan_ke_bendahara.php">
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['id_sementara']; ?></td>
                                        <input class="hidden" type="text" name="nomor_urut" value="<?php echo $no++; ?>">
                                        <input class="hidden" type="text" name="id_sementara" value="<?php echo $row['id_sementara']; ?>">

                                        <td><?php echo $row['kode_brg']; ?></td>
                                        <input class="hidden" type="text" name="kode_brg" value="<?php echo $row['kode_brg']; ?>">
                                        <input class="hidden" type="text" name="id_jenis" value="<?php echo $row['id_jenis']; ?>">

                                        <td><?php echo $row['nama_brg']; ?></td>
                                        <input class="hidden" type="text" name="nama_brg" value="<?php echo $row['nama_brg']; ?>">

                                        <td><?php echo $row['satuan']; ?></td>
                                        <input class="hidden" type="text" name="satuan_brg" value="<?php echo $row['satuan']; ?>">

                                        <td><?php echo $row['jumlah']; ?></td>
                                        <input class="hidden" type="text" name="jumlah_brg" value="<?php echo $row['jumlah']; ?>">

                                        <td><?php echo $row['status_acc']; ?></td>
                                        <input class="hidden" type="text" name="status_acc_brg" value="<?php echo $row['status_acc']; ?>">
                                        <input class="hidden" type="text" name="tgl_permintaan" value="<?php echo $row['tgl_permintaan']; ?>">
                                        <input class="hidden" type="text" name="status" value="<?php echo $row['status']; ?>">

                                        <td title="Ajukan Ke Bendahara Barang">
                                            <center>
                                                <?php if($row['status_acc'] !='setuju') { ?>
                                                    <input onclick=""
                                                           type="button" id="permintaan_ke_bendahara"
                                                           name="permintaan_ke_bendahara"
                                                           class="btn btn-primary col-sm-offset-3 disabled"
                                                           value="Ajukan Bendahara">
                                                <?php } else if($row['status_acc']=='setuju') {?>
                                                    <input onclick="return confirm('Kirim Permintaan Barang ke Bendahara?')"
                                                           type="submit" id="permintaan_ke_bendahara"
                                                           name="permintaan_ke_bendahara"
                                                           class="btn btn-primary col-sm-offset-3"
                                                           value="Ajukan Bendahara">
                                                <?php } ?>

                                            </center>

                                        </td>
                                    </tr>
                                </form>
                            <?php }
                        }
                        ?>



                        </tbody>
                    </table>
                </div>                  
            </div>
        </div>
    </div>
</div>
    <div>
        <span style="color: black">
        NB : Setelah semua permintaan diajukan ke Bendahara, Anda dapat melihat posisi proses pada menu
            <a style="font-weight: bold" href="?p=history_permintaan_barang&pa=history_pengguna">
                History
            </a>
    </span>

    </div>



</section>


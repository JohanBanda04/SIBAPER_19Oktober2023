<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

//index.php?p=detilpermintaan&unit=Undar&tgl=2022-10-19&user_id_pemohon=23&bendahara_id=31
if (isset($_GET['tgl']) && isset($_GET['unit'])) {
    $tgl = $_GET['tgl'];
    $unit = $_GET['unit'];
    $user_id_pemohon = $_GET['user_id_pemohon'];
    $bendahara_id = isset($_GET['bendahara_id'])? $_GET['bendahara_id']:'';

    echo "bendahara_id:".$bendahara_id."::";

    $query = mysqli_query($koneksi,"select * from ((permintaan inner join stokbarang on permintaan.kode_brg=stokbarang.kode_brg) 
inner join sementara on permintaan.id_sementara=sementara.id_sementara) where 
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id='$_SESSION[user_id]' and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) 
or  
(sementara.tgl_permintaan='$tgl' and sementara.unit='$unit' and sementara.user_id='$user_id_pemohon'
and sementara.bendahara_id is null and 
sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')) ");

}



if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'edit')
        header("location:?p=editpesan");
}

?>
<!--disini dicek johan-->

<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">sKonfirmasi Permintaan  <?php echo $unit; ?></h3>
                </div>
                <div class="box-body">
                    <a href="index.php?p=datapermintaan" style="margin:10px;" class="btn btn-success"><i class='fa fa-backward'>  Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead  >
                            <tr>
                                <th>No</th>
                                <th>Id Permintaan</th>
                                <th>Nama Pemohon</th>
                                <th>Nama Bendahara</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                $no = 1 ;
                                if (mysqli_num_rows($query)) {
                                while($row=mysqli_fetch_assoc($query)){

                                ?>
                                <td> <?= $no; ?> </td>
                                <td> <?= $row['id_sementara']; ?> </td>
                                <td> <?= $row['unit']; ?> </td>

                                <?php if($row['bendahara']=='' || $row['bendahara']==null) { ?>
                                    <td> Belum Ada </td>
                                <?php } else { ?>
                                    <td> <?= $row['bendahara']; ?> </td>
                                <?php } ?>

                                <td> <?= $row['kode_brg']; ?> </td>
                                <td> <?= $row['nama_brg']; ?> </td>
                                <td> <?= $row['satuan']; ?> </td>
                                <td> <?= $row['jumlah']; ?> </td>
                                <td style="color: #00a7d0;font-weight: bold"> <?= $row['status_acc']; ?> </td>
                                <td>

                                    <?php
                                        if($row['status_acc'] != 'Pengajuan Bendahara'){
                                            if($row['status_acc']=='Setuju Kasub Bendahara'){
                                                ?>
                                                <!--disini contoh penggunaan metode post terbaru-->
                                                <form method="post" action="penyerahan_barang_pengguna.php">
                                                    <input class="hidden" type="text" name="unit" value="<?php echo $row['unit']; ?>">
                                                    <input class="hidden" type="text" name="tgl_permintaan" value="<?php echo $row['tgl_permintaan']; ?>">
                                                    <input class="hidden" type="text" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                    <input class="hidden" type="text" name="bendahara_id" value="<?php echo $row['bendahara_id']; ?>">

                                                    <input class="hidden" type="text" name="bendahara" value="<?php echo $row['bendahara']; ?>">
                                                    <input class="hidden" type="text" name="id_sementara" value="<?php echo $row['id_sementara']; ?>">

                                                    <input onclick="return confirm('Penyerahan Barang Ke Pengguna?')"
                                                           type="submit" id="penyerahan_barang_pengguna"
                                                           name="penyerahan_barang_pengguna"
                                                           style="background-color: #1b860c"
                                                           class="btn btn-primary col-sm-offset-3"
                                                           value="pPenyerahan Barang Ke Pengguna">

                                                </form>
<!--                                                <a id="bt_penyerahan_barang_ke_pengguna" onclick="" class="btn btn-success"-->
<!--                                                   style="background-color: #1b860c"-->
<!--                                                   href="penyerahan_barang_pengguna.php?bendahara=--><?php //echo $row['bendahara'];?><!--">-->
<!--                                                    Penyerahan Barang Ke Pengguna-->
<!--                                                </a>-->
                                                <?php
                                            } else if($row['status_acc']=="Pengajuan Kasub Bendahara"){
                                                if($row['status_acc'] == "Pengajuan Kasub Bendahara") { ?>
                                                    <a id="bt_edit_fake" href="#">
                                                        <span class="disabled btn btn-info" data-placement='top' data-toggle='tooltip'
                                                            title='Edit'>
                                                            <i class="fa fa-edit"></i>
                                                        </span>
                                                    </a>


                                                    <a id="bt_ajukan_kasubbendahara_fake" href="#">
                                                        <span class="disabled btn btn-success"
                                                              data-placement='top' data-toggle='tooltip'
                                                              title='sPemberitahuan Kasub Bendahara'>
                                                            <i class="fa fa-check"></i>
                                                        </span>
                                                    </a>
                                                <?php } ?>
                                            <?php } else if ($row['status_acc']=="Tidak Setuju Kasub Bendahara") { ?>
                                                <!--penggunaan metode post disini juga-->
                                                <form action="hapus_yg_tidak_disetujui.php" method="post">
                                                    <input class="hidden" type="text"
                                                           name="hapus_yg_tidak_disetujui"
                                                           id="hapus_yg_tidak_disetujui"
                                                           value="<?php echo $row['id_sementara']; ?>">
                                                    <button class="btn btn-danger"
                                                            title="Hapus" data-placement='top' data-toggle='tooltip'
                                                            type="submit"
                                                            onclick="return confirm('Menghapus Data?')">
                                                        <i class="fa fa-remove"></i>
                                                    </button>


                                                </form>
                                                <form action="edit_yg_tidak_disetujui.php" method="post">
                                                    <input class="hidden" type="text" name="edit_yg_tidak_disetujui"
                                                           id="edit_yg_tidak_disetujui"
                                                           value="<?php echo $row['id_sementara']; ?>">
                                                    <button class="btn btn-info"
                                                            title="Edit" data-placement='top' data-toggle='tooltip'
                                                            type="submit"
                                                            onclick="return confirm('Edit Data?')">
                                                        <i class="fa fa-edit"></i>
                                                    </button>


                                                </form>


                                            <?php } else if($row['status_acc']=='Penyerahan Barang Ke Pengguna') { ?>
                                                <a href="#">Silakan Lakukan Pemberian Barang</a>
                                            <?php } else if($row['status_acc']=='Penerimaan Barang Dari Bendahara'){ ?>
<!--                                                <a href="#">Sudah Diterima Pengguna</a>-->
<!--                                                <form action="edit_yg_tidak_disetujui.php" method="post">-->
<!--                                                    <input class="hidden" type="text" name="edit_yg_tidak_disetujui"-->
<!--                                                           id="edit_yg_tidak_disetujui"-->
<!--                                                           value="--><?php //echo $row['id_sementara']; ?><!--">-->

                                                    <a href="index.php?p=sudah_serahkan_barang_ke_pengguna&id_sementara=<?php echo $row['id_sementara'];?>" class="btn btn-info"
                                                       title="Konfirmasi Selesai"
                                                       data-placement='top'
                                                       data-toggle='tooltip' onclick="return confirm('Konfirmasi Selesai?')">
                                                        sSudah Diterima Pengguna
                                                    </a>


<!--                                                </form>-->
                                            <?php } else { ?>
<!--                                                <a href="index.php?p=sudah_serahkan_barang_ke_pengguna&id_sementara=--><?php //echo $row['id_sementara'];?><!--" class="btn btn-info"-->
                                                <a href="../<?php echo $row['path_foto'];?>" class="btn btn-info"
                                                   title="Konfirmasi Selesai" target="_blank"
                                                   data-placement='top'
                                                   data-toggle='tooltip' onclick="return confirm('Lihat Foto?')">
                                                    Lihat Foto Penyerahan
                                                </a>
                                            <?php }
                                            ?>

                                            <?php
                                        } else {

                                                if($row['status_acc']=='Pengajuan Bendahara'){ ?>
                                                    <a href="index.php?p=edit_permintaan_pengguna&unit=<?php echo $row['unit'];?>&id_sementara=<?php echo $row['id_sementara'];?>&tgl_permintaan=<?php echo $row['tgl_permintaan']?>&user_id_pemohon=<?php echo $row['user_id'];?>">
                                                        <span class="btn btn-info" data-placement='top' data-toggle='tooltip'
                                                              title='Edits'>
                                                            <i class="fa fa-edit"></i>
                                                        </span>
                                                    </a>
                                                    <a data-placement='top' data-toggle='tooltip' title="riil Pemberitahuan Kasub Bendahara"
                                                       onclick="return confirm('Ajukan ke Kasub Bendahara?')" class="btn btn-success"
                                                       style="background-color: #1b860c"
                                                       href="ajukan_via_kasub_barang.php?unit=<?php echo $row['unit']; ?>&id_sementara=<?php echo $row['id_sementara'];?>&tgl_permintaan=<?php echo $row['tgl_permintaan'];?>&user_id_pemohon=<?php echo $row['user_id']?>&bendahara_id=<?php echo $row['bendahara_id']??''; ?>">
<!--                                                        Pemberitahuan Kasub Bendahara-->
                                                        <i class="fa fa-check "></i>
                                                    </a>
                                                    <?php

                                                }
                                            ?>
                                            <!--Pemberitahuan Kasub Barang-->

                                            <?php
                                        }
                                    ?>

                                </td>
                            </tr>

                            <?php $no++; } } else {
                                    echo "<tr><td colspan=9>Tidak ada permintaan material teknik.</td></tr>";
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


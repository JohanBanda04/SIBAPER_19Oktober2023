<?php

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if (isset($_GET['id_sementara'])) {
    $id_sementara = $_GET['id_sementara'];

    $unit = $_GET['unit'];
    $tgl_permintaan = $_GET['tgl_permintaan'];
    $user_id_pemohon = $_GET['user_id_pemohon'];

    //echo "Ujicoba".'::';
    //echo $id_sementara."::";
    //echo $unit."::";
    //echo $tgl_permintaan."::";
    //echo $user_id_pemohon;
    $query_old = mysqli_query($koneksi, "SELECT permintaan.id_permintaan, permintaan.tgl_permintaan,permintaan.status, permintaan.kode_brg, unit, permintaan.jumlah, stokbarang.nama_brg FROM permintaan INNER JOIN stokbarang ON permintaan.kode_brg=stokbarang.kode_brg WHERE id_permintaan = $id_sementara ");

    $query = mysqli_query($koneksi,"select * from (sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg) where id_sementara='$id_sementara'");

    if (mysqli_num_rows($query)) {
        $row2=mysqli_fetch_assoc($query);
    }
}
?>

<section class="content">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Edit Data Permintaan Barang</h3>
                </div>
                <form method="post"  action="edit_prosesminta_pengguna.php" class="form-horizontal">
                    <div class="box-body">
                        <input type="hidden" name="id_sementara" value="<?= $row2['id_sementara']; ?>">
                        <input type="hidden" name="user_id" value="<?= $row2['user_id']; ?>">
                        <input type="hidden" name="tgl_permintaan" value="<?= $row2['tgl_permintaan']; ?>">
                        <div class="form-group ">
                            <label for="nama_brg" class="col-sm-offset-1 col-sm-3 control-label">Nama Pemohon</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?= $row2['unit']; ?>"
                                       readonly name="unit">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_brg" class="col-sm-offset-1 col-sm-3 control-label">Nama Barang</label>

                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="nama_brg" value="<?= $row2['nama_brg']; ?>" readonly>
                                <input class="hidden form-control" type="text" name="kode_brg" value="<?= $row2['kode_brg']; ?>" readonly>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jumlah" class="col-sm-offset-1 col-sm-3 control-label">Jumlah</label>
                            <div class="col-sm-2">
                                <input type="number" value="<?= $row2['jumlah'] ?>"class="form-control" name="jumlah">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="catatan_bendahara" class="col-sm-offset-1 col-sm-3 control-label">Catatan</label>
                            <div class="col-sm-4">
                                <input required type="text" value="<?= $row2['note_bendahara'] ?>" class="form-control"
                                       name="catatan_bendahara" id="catatan_bendahara">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="update_jumlah_brg" class="btn btn-primary col-sm-offset-4 " value="Update" >
                            &nbsp;
                            <input type="reset" class="btn btn-danger" value="Batal">
                            <!--index.php?p=detilpermintaan&unit=Undar&tgl=2022-10-04&user_id_pemohon=23-->
                            <!--index.php?p=detilpermintaan&unit=Undar&tgl=2022-11-01&user_id_pemohon=23&bendahara_id=-->
                            <a href="index.php?p=detilpermintaan_table&unit=<?php echo $unit?>&tgl=<?php echo $tgl_permintaan?>&user_id_pemohon=<?php echo $user_id_pemohon?>&bendahara_id=" style="margin:10px;" class="btn btn-success">
                                <i class='fa fa-backward'>
                                    Kembali
                                </i>
                            </a>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
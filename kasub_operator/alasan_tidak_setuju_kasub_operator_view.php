<?php

include_once "../fungsi/koneksi.php";
include_once "../fungsi/fungsi.php";



//$id_sementara = isset($_GET['id_sementara'])? $_GET['id_sementara']:'';
$id_sementara = isset($_GET['id_sementara'])? $_GET['id_sementara']:'';
$unit = isset($_GET['unit'])? $_GET['unit']:'';

//echo $id_sementara."<br>";
//echo $unit."<br>";

$unit = $_GET['unit'];
$user_id = $_GET['user_id'];
$tgl_permintaan = $_GET['tgl_permintaan'];

//echo "<br><br>unit : ".$unit.'<br>';
//echo "user_id : ".$user_id.'<br>';
//echo "tgl_permintaan : ".$tgl_permintaan.'<br>';

$query = mysqli_query($koneksi,"select * from ((sementara inner join `user` 
on sementara.user_id=user.id_user) 
inner join stokbarang on sementara.kode_brg=stokbarang.kode_brg) where id_sementara='$id_sementara'");


while($dt = mysqli_fetch_array($query)){
    $id_sementara = $dt['id_sementara'];
    $nama_pemohon = $dt['unit'];
    $nama_bendahara = $dt['bendahara'];
    $nama_lengkap = $dt['nama_lengkap'];
    $jumlah = $dt['jumlah'];
    $nama_brg = $dt['nama_brg'];
//    $user_id = $dt['user_id'];
//    $tgl_permintaan= $dt['tgl_permintaan'];
}


?>
<section class="content">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Catatan Tidak Setuju</h3>
                </div>
                <form method="POST"  action="simpan_catatan_tidak_setuju_kasub_operator.php" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group ">
                            <label for="nama_bendahara" class="col-sm-offset-1 col-sm-3 control-label">Nama Bendahara</label>
                            <div class="col-sm-4">
                                <input class="hidden" type="text" name="id_sementara" id="id_sementara" value="<?php echo $id_sementara; ?>">
                                <input class="hidden" type="text" name="unit" id="unit" value="<?php echo $nama_pemohon; ?>">
                                <input class="hidden" type="text" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                                <input class="hidden" type="text" name="tgl_permintaan" id="tgl_permintaan" value="<?php echo $tgl_permintaan; ?>">

                                <input readonly  required type="text" value="<?php echo $nama_bendahara;?>" class="form-control"
                                       name="unit" id="unit">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="nama_lengkap" class="col-sm-offset-1 col-sm-3 control-label">Nama Pemohon</label>
                            <div class="col-sm-4">
                                <input readonly required type="text" value="<?php echo $nama_lengkap;?>" class="form-control" name="nama_lengkap">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="nip" class="col-sm-offset-1 col-sm-3 control-label">Jumlah Barang</label>
                            <div class="col-sm-4">
                                <input readonly required type="text" value="<?php echo $jumlah;?>" class="form-control" name="nip">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="nip" class="col-sm-offset-1 col-sm-3 control-label">Nama Barang</label>
                            <div class="col-sm-4">
                                <input readonly required type="text" value="<?php echo $nama_brg;?>" class="form-control" name="nip">
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="catatan_tidak_setuju_kasub_operator"
                                   class="col-sm-offset-1 col-sm-3 control-label">Catatan Tidak Setuju</label>
                            <div class="col-sm-4">
                                <input  type="text"  class="form-control" name="catatan_tidak_setuju_kasub_operator">
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="simpan_catatan_tidak_setuju_kasub_operator"
                                   id="simpan_catatan_tidak_setuju_kasub_operator"
                                   class="btn btn-primary col-sm-offset-4 " value="Simpan" >
                            &nbsp;

                            <!--index.php?p=detilpermintaan&unit=Undar&user_id=23&tgl_permintaan=2022-10-17-->
                            <a id="batal_tidak_setuju_kasub_pengguna" class="btn btn-danger"
                               href="index.php?p=detilpermintaan_table&unit=<?php echo $unit;?>&user_id=<?php echo $user_id;?>&tgl_permintaan=<?php echo $tgl_permintaan;?>">
                                        <span id="alasan_tidak_setuju" data-placement='top' data-toggle='tooltip' title='Alasan Tidak Setuju'>
                                            Batal
                                        </span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
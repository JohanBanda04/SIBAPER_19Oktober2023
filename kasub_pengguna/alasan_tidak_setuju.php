<?php

include_once "../fungsi/koneksi.php";
include_once "../fungsi/fungsi.php";


$id_sementara = isset($_GET['id_sementara'])? $_GET['id_sementara']:'';

echo $id_sementara."::";

$query = mysqli_query($koneksi,"select * from ((sementara inner join `user` 
on sementara.user_id=user.id_user) 
inner join stokbarang on sementara.kode_brg=stokbarang.kode_brg) where id_sementara='$id_sementara'");

while($dt = mysqli_fetch_array($query)){
    $id_sementara = $dt['id_sementara'];
    $nama_pemohon = $dt['unit'];
    $nama_lengkap = $dt['nama_lengkap'];
    $jumlah = $dt['jumlah'];
    $nama_brg = $dt['nama_brg'];
    $user_id = $dt['user_id'];
    $tgl_permintaan= $dt['tgl_permintaan'];
}

//if(isset($_POST['simpan'])) {
//    $username = $_POST['username'];
//    $nama_lengkap = $_POST['nama_lengkap'];
//    $nip = $_POST['nip'];
//    $password = md5($_POST['password']);
//    $level = $_POST['level'];
//    $jabatan = $_POST['jabatan'];
//    $subbidang_id = $_POST['subbidang_id'];
//    $email = $_POST['email'];
//
//
////    $query = mysqli_query($koneksi, "INSERT INTO user VALUES ('', '$username', '$nama_lengkap','$password', '$level','$jabatan') ");
//
//    $query = mysqli_query($koneksi,"INSERT INTO user (username, nama_lengkap, nik, password, level,
//jabatan, subbidang_id, email)
//VALUES ('$username', '$nama_lengkap', '$nip',
//'$password','$level','$jabatan','$subbidang_id', '$email')");
//    if ($query) {
//        echo '<script language="javascript">alert("Data Berhasil Disimpan !!!"); document.location="index.php?p=user";</script>';
//    } else {
//        echo 'gagal : ' . mysqli_error($koneksi);
//    }
//}


?>

<section class="content">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">sCatatan Tidak Setuju</h3>
                </div>
                <form method="post"  action="simpan_alasan_tidak_setuju_kasub_pengguna.php" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group ">
                            <label for="username" class="col-sm-offset-1 col-sm-3 control-label">Nama Pemohon</label>
                            <div class="col-sm-4">
                                <input class="hidden" type="text" name="id_sementara" id="id_sementara" value="<?php echo $id_sementara; ?>">
                                <input class="hidden" type="text" name="unit" id="unit" value="<?php echo $nama_pemohon; ?>">
                                <input class="hidden" type="text" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                                <input class="hidden" type="text" name="tgl_permintaan" id="tgl_permintaan" value="<?php echo $tgl_permintaan; ?>">

                                <input readonly  required type="text" value="<?php echo $nama_pemohon;?>" class="form-control"
                                       name="unit" id="unit">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="nama_lengkap" class="col-sm-offset-1 col-sm-3 control-label">Nama Lengkap</label>
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
                            <label for="catatan_tidak_setuju_kasub_pengguna"
                                   class="col-sm-offset-1 col-sm-3 control-label">Catatan Tidak Setuju</label>
                            <div class="col-sm-4">
                                <input  type="text"  class="form-control" name="catatan_tidak_setuju_kasub_pengguna">
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="simpan_catatan_tidak_setuju"
                                   id="simpan_catatan_tidak_setuju" class="btn btn-primary col-sm-offset-4 " value="Simpan" >
                            &nbsp;

                            <!--index.php?p=detilpermintaan&unit=Undar&user_id=23&tgl_permintaan=2022-10-29-->
                            <a id="batal_tidak_setuju_kasub_pengguna" class="btn btn-danger"
                               href="index.php?p=detilpermintaan&unit=<?php echo $nama_pemohon;?>&user_id=<?php echo $user_id;?>&tgl_permintaan=<?php echo $tgl_permintaan;?>">
                                        <span id="alasan_tidak_setuju" data-placement='top' data-toggle='tooltip' title='Alasan Tidak Setuju'>
                                            Batals
                                        </span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>



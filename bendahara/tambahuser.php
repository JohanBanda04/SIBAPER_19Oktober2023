<?php  

include_once "../fungsi/koneksi.php";

if(isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $nip = $_POST['nip'];
    $password = md5($_POST['password']);
    $level = $_POST['level'];
    $jabatan = $_POST['jabatan'];
    $subbidang_id = $_POST['subbidang_id'];
    $email = $_POST['email'];


//    $query = mysqli_query($koneksi, "INSERT INTO user VALUES ('', '$username', '$nama_lengkap','$password', '$level','$jabatan') ");

    $query = mysqli_query($koneksi,"INSERT INTO user (username, nama_lengkap, nik, password, level, 
jabatan, subbidang_id, email)
VALUES ('$username', '$nama_lengkap', '$nip', 
'$password','$level','$jabatan','$subbidang_id', '$email')");
    if ($query) {
     echo '<script language="javascript">alert("Data Berhasil Disimpan !!!"); document.location="index.php?p=user";</script>';
 } else {
    echo 'gagal : ' . mysqli_error($koneksi);
}
}


?>

<section class="content">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Tambah Data User</h3>
                </div>
                <form method="post"  action="" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group ">
                            <label for="username" class="col-sm-offset-1 col-sm-3 control-label">Username</label>
                            <div class="col-sm-4">
                                <input  required type="text"  class="form-control" name="username">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="nama_lengkap" class="col-sm-offset-1 col-sm-3 control-label">Nama Lengkap</label>
                            <div class="col-sm-4">
                                <input  required type="text"  class="form-control" name="nama_lengkap">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="nip" class="col-sm-offset-1 col-sm-3 control-label">NIP</label>
                            <div class="col-sm-4">
                                <input  required type="text"  class="form-control" name="nip">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="paswword"class="col-sm-offset-1 col-sm-3 control-label">Password</label>
                            <div class="col-sm-4">
                                <input required type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group">
<!--                            <label id="tes"for="nama_brg" class="col-sm-offset-1 col-sm-3 control-label">Level</label>-->
                            <label id="tes"for="level" class="col-sm-offset-1 col-sm-3 control-label">
                                Level
                            </label>
                            <div class="col-sm-4">
                                <select required name="level" class="form-control">
                                    <option >--Pilih Level--</option>

                                    <option value="operator">Operator</option>
                                    <option value="kasub_operator">Kasub Operator</option>
                                    <option value="pengguna">Pengguna</option>
                                    <option value="kasub_pengguna">Kasub Pengguna</option>

                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="jabatan" class="col-sm-offset-1 col-sm-3 control-label">Jabatan</label>
                            <div class="col-sm-4">
                                <input  required type="text"  class="form-control" name="jabatan">
                            </div>
                        </div>

                        <div class="form-group">
                            <label id="tes"for="subbidang_id" class="col-sm-offset-1 col-sm-3 control-label">Subbidang</label>
                            <div class="col-sm-4">
                                <select required name="subbidang_id" class="form-control">
                                    <option >--Pilih Sub Bidang--</option>
                                    <?php
                                    include "../fungsi/koneksi.php";
                                    include "../fungsi/fungsi.php";
                                        $querys = mysqli_query($koneksi,"select * from subbidang");
                                        while ($it = mysqli_fetch_array($querys)){ ?>
                                            <option value="<?php echo $it['id_subbidang']?>">
                                                <?php echo $it['nama_subbidang']?>
                                            </option>
                                        <?php }
                                    ?>
<!--                                    <option value="bendahara">Bendahara</option>-->
<!--                                    <option value="instansi">Instansi</option>-->

                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="email" class="col-sm-offset-1 col-sm-3 control-label">Email</label>
                            <div class="col-sm-4">
                                <input  required type="email"  class="form-control" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="simpan" class="btn btn-primary col-sm-offset-4 " value="Simpan" > 
                            &nbsp;
                            <input type="reset" class="btn btn-danger" value="Batal">
                            <a href="index.php?p=user&pa=DataUser" style="margin:10px;"
                               class="btn btn-success"><i
                                        class='fa fa-backward'> Kembali</i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>



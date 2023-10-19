<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$query_get_data_user = mysqli_query($koneksi,"select * from user where id_user='$_SESSION[user_id]'");

$dt_user = mysqli_fetch_assoc($query_get_data_user);


?>
<section class="content">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Ediit Data User</h3>
                </div>
                <form method="post"  action="edituproses_kasub_operator.php" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group ">
                            <label for="username" class="col-sm-offset-1 col-sm-3 control-label">Username</label>
                            <div class="col-sm-4">
                                <input  required type="text" value="<?php echo $_SESSION['username']?>"
                                        class="form-control"
                                        name="username">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="nama_lengkap" class="col-sm-offset-1 col-sm-3 control-label">Nama Lengkap</label>
                            <div class="col-sm-4">
                                <input  required type="text" value="<?php echo $dt_user['nama_lengkap'];?>"
                                        class="form-control"
                                        name="nama_lengkap">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="nip" class="col-sm-offset-1 col-sm-3 control-label">NIP</label>
                            <div class="col-sm-4">
                                <input  required type="text" value="<?php echo $dt_user['nik'];?>"
                                        class="form-control"
                                        name="nip">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="paswword" class="col-sm-offset-1 col-sm-3 control-label">Password</label>
                            <div class="col-sm-4">

                                <input required type="password" value="<?php echo $dt_user['password'] ;?>"
                                       class="form-control"
                                       name="password">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="email" class="col-sm-offset-1 col-sm-3 control-label">Email</label>
                            <div class="col-sm-4">
                                <input  required type="email" value="<?php echo $dt_user['email'];?>"
                                        class="form-control"
                                        name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="simpan" class="btn btn-primary col-sm-offset-4 " value="Simpan" >
                            &nbsp;
                            <input type="reset" class="btn btn-danger" value="Batal">
                            <!--                            <a href="index.php?p=material-m2&id_jenis=2" style="margin:10px;"-->
                            <!--                               class="btn btn-success"><i class='fa fa-backward'> Kembali</i></a>-->
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
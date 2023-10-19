<!--form tampilan Edit Data User sisi Bendahara -->
<?php
	include "../fungsi/koneksi.php";
    //mengambil id untuk edit user
	if (isset($_GET['id'])) {
		$id = $_GET['id'];

//		echo $id;
		$query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = $id ");
		if (mysqli_num_rows($query)) {
			while($row2 = mysqli_fetch_assoc($query)):
?>

<section class="content">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Edit Data User</h3>
                </div>
                <form method="post"  action="edituproses.php" class="form-horizontal">
                    <div class="box-body">
                     <div class="row">
                        <!--<div class="col-md-2">
                            <a href="index.php?p=user" class="btn btn-primary"><i class="fa fa-backward"></i> Kembali</a>
                        </div>-->
                        <br><br>
                    </div>

                        <input type="hidden" name="id" value="<?php echo $row2['id_user']; ?>">
                        <div class="form-group ">
                            <label for="username" class="col-sm-offset-1 col-sm-3 control-label">Username</label>
                            <div class="col-sm-4">
                                <input   type="text" required value="<?php echo $row2['username'];?>"  class="form-control" name="username">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="nama_lengkap" class="col-sm-offset-1 col-sm-3 control-label">Nama Lengkap</label>
                            <div class="col-sm-4">
                                <input type="text" required value="<?php echo $row2['nama_lengkap'];?>"  class="form-control" name="nama_lengkap">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="nip" class="col-sm-offset-1 col-sm-3 control-label">NIP</label>
                            <div class="col-sm-4">
                                <input type="text" required value="<?php echo $row2['nik'];?>"  class="form-control" name="nip">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="paswword"class="col-sm-offset-1 col-sm-3 control-label">Passwordd</label>
                            <div class="col-sm-4">
                                <input required value="<?php echo $row2['password'];?>" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label id="tes"for="level" class="col-sm-offset-1 col-sm-3 control-label">Level</label>
                            <div class="col-sm-4">
                                <select required name="level" class="form-control">
                                    <option >--Pilih Level--</option>

                                    <option value="operator" <?php if ($row2['level']=='operator'){?> selected <?php }?> >Operator</option>
                                    <option value="kasub_operator" <?php if ($row2['level']=='kasub_operator'){?> selected <?php }?> >Kasub Operator</option>
                                    <option value="pengguna" <?php if ($row2['level']=='pengguna'){?> selected <?php }?> >Pengguna</option>
                                    <option value="kasub_pengguna" <?php if ($row2['level']=='kasub_pengguna'){?> selected <?php }?> >Kasub Pengguna</option>


                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="jabatan" class="col-sm-offset-1 col-sm-3 control-label">Jabatan</label>
                            <div class="col-sm-4">
                                <input  required value="<?php echo $row2['jabatan'];?>" type="text"  class="form-control" name="jabatan">
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
                                        <option value="<?php echo $it['id_subbidang']?>" <?php if($it['id_subbidang']==$row2['subbidang_id']) { ?> selected <?php } ?> >
                                            <?php echo $it['nama_subbidang']?>
                                        </option>
                                    <?php }
                                    ?>

                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="email" class="col-sm-offset-1 col-sm-3 control-label">Email</label>
                            <div class="col-sm-4">
                                <input  required value="<?php echo $row2['email'];?>" type="email"  class="form-control" name="email">
                            </div>
                        </div>


                        <div class="form-group">
                            <input type="submit" name="update" class="btn btn-primary col-sm-offset-4 " value="Simpan" >
                            &nbsp;
<!--                            <a href="index.php?p=user" class="btn btn-primary"><i class="fa fa-backward"></i> Kembali</a>-->
                            <input type="reset" class="btn btn-danger" value="Reset">
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

<?php endwhile; } }  ?>
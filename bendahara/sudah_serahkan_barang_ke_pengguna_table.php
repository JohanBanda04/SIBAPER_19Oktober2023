<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$id_sementara = isset($_GET['id_sementara'])? $_GET['id_sementara']:'';
//echo "id sementaranya : ". $id_sementara;die;

$get_data_untuk_detail = mysqli_query($koneksi,"select * from sementara inner join 
stokbarang on sementara.kode_brg=stokbarang.kode_brg where sementara.id_sementara='$id_sementara' ");

//$dt = mysqli_fetch_assoc($get_data_untuk_detail);
//if($dt['path_foto']!=""){
//    echo "ada foto"; die;
//} else {
//    echo "tidak ada foto"; die;
//}

while($dt = mysqli_fetch_array($get_data_untuk_detail)){
    //echo "<pre>"; print_r($dt['id_sementara']); die;


    $tgl_permintaan_untuk_view = tanggal_indo($dt['tgl_permintaan']);
    $tgl_permintaan = $dt['tgl_permintaan'];
    $unit = $dt['unit'];
    $user_id = $dt['user_id'];
    $nama_barang = $dt['nama_brg'];
    $jumlah_barang = $dt['jumlah'];
    $bendahara = $dt['bendahara'];
    $id_sementara = $dt['id_sementara'];
    $bendahara_id = $dt['bendahara_id'];
    $path_foto = $dt['path_foto'];
    ?>
    <?php

    ?>
    <section class="content">
        <!--    --><?php //echo $id_sementara;?><!--::-->
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="text-center">Details Informasi Penyerahaan Barangg</h3>
                    </div>
                    <form method="POST" action="uploadbuktipenyerahan_table.php"  class="form-horizontal"
                          enctype="multipart/form-data">
                        <input class="hidden" type="number" id="id_sementara" name="id_sementara" value="<?php echo $id_sementara; ?>">

                        <input class="hidden" type="text" name="unit" value="<?php echo $unit; ?>">
                        <input class="hidden" type="text" name="tgl_permintaan" value="<?php echo $tgl_permintaan_untuk_view; ?>">
                        <input class="hidden" type="text" name="user_id" value="<?php echo $user_id; ?>">
                        <input class="hidden" type="text" name="bendahara_id" value="<?php echo $bendahara_id; ?>">
                        <div class="box-body">
                            <div class="form-group ">
                                <label for="username" class="col-sm-offset-1 col-sm-3 control-label">Tgl Pengajuan</label>

                                <div class="col-sm-4">
                                    <input readonly="readonly"  required type="text"  class="form-control" value="<?php echo tanggal_indo($tgl_permintaan); ?>">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="nama_barang" class="col-sm-offset-1 col-sm-3 control-label">Nama Barang</label>
                                <div class="col-sm-4">
                                    <input readonly="readonly" required type="text"  class="form-control" value="<?php echo $nama_barang?>">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="jumlah_barang" class="col-sm-offset-1 col-sm-3 control-label">Jumlah Barang</label>
                                <div class="col-sm-4">
                                    <input readonly="readonly" required type="text"  class="form-control" value="<?php echo $jumlah_barang?>">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="bendahara" class="col-sm-offset-1 col-sm-3 control-label">Penggunaz</label>
                                <div class="col-sm-4">
                                    <?php
                                    $query_get_nama_pemohon = mysqli_query($koneksi, "Select nama_lengkap from `user` where id_user='$user_id'");

                                    ?>
                                    <input readonly="readonly" required type="text"  class="form-control" value="<?php echo mysqli_fetch_assoc($query_get_nama_pemohon)['nama_lengkap']; ?>">
                                </div>
                            </div>

                            <div class="form-group ">
                                <center>
                                    <!--metode melakukan load loading preview photo yang telah terupload sebelumnya menggunakan SERVER NAME-->
                                    <?php
                                    $base_url = $_SERVER['SERVER_NAME']."/sibaper";
                                    //echo $_SERVER['SERVER_NAME']; die;
                                    ?>
                                    <?php if($path_foto!=null){ ?>
                                        <img src="<?php echo "https://" . $base_url ; ?>/<?php echo $path_foto?>" id="uploadPreview" style="width: 180px; height: 190px;" /><br>
                                    <?php } else if ($path_foto==null){
                                        $path_foto = "assets/file/no_photo.jpg";
                                        ?>
                                        <img src="<?php echo "https://" . $base_url ; ?>/<?php echo $path_foto?>" id="uploadPreview" style="width: 180px; height: 190px;" /><br>
                                    <?php } ?>
                                    <input type="file" name="gambar" id="fileToUpload" onchange="PreviewImage()"><br>
                                </center>
                                <!--                            <input type="text" name="test" id="" value="budi">-->

                            </div>


                            <div class="form-group">
                                <input type="submit"
                                       name="simpanbuktipenyerahan" id="simpanbuktipenyerahan"
                                       class="btn btn-primary col-sm-offset-4 "
                                       value="Simpanze" >
                                &nbsp;
                                <!--index.php?p=detilpermintaan&unit=Undar&tgl=2022-10-31&user_id_pemohon=23&bendahara_id=21-->
                                <input type="reset" class="btn btn-danger" value="Batal">

                                <a href="index.php?p=detilpermintaan_table&unit=<?php echo $unit;?>&tgl=<?php echo $tgl_permintaan;?>&user_id_pemohon=<?php echo $user_id?>&bendahara_id=<?php echo $bendahara_id;?>" style="margin:10px;"
                                   class="btn btn-success"><i class='fa fa-backward'> Kembali</i></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script !src="">
            function PreviewImage() {
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("fileToUpload").files[0]);
                var size_gambar = document.getElementById("fileToUpload").files[0].size;
                if(size_gambar <= ((5*1024)*1024) ){
                    oFReader.onload = function (oFREvent)
                    {
                        document.getElementById("uploadPreview").src = oFREvent.target.result;
                    };
                } else {
                    alert("Maaf Size Foto Terlalu Besar, Size max : 300Kb");
                }

            };
        </script>
    </section>
    <?php

}

?>



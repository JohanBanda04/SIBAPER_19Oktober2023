<?php
include '../fungsi/koneksi.php';
include '../fungsi/fungsi.php';

$id_sementara = isset($_GET['id_sementara'])? $_GET['id_sementara']:'';

$get_data_untuk_detail = mysqli_query($koneksi,"select * from sementara inner join 
stokbarang on sementara.kode_brg=stokbarang.kode_brg where sementara.id_sementara='$id_sementara' ");

while ($dt = mysqli_fetch_array($get_data_untuk_detail)){
    $tgl_permintaan = $dt['tgl_permintaan'];
    $nama_barang = $dt['nama_brg'];
    $jumlah_barang = $dt['jumlah'];
    $bendahara = $dt['bendahara'];
    $id_sementara = $dt['id_sementara'];
}

//echo "<script>window.location='index.php?p=terima_dan_upload_gambar.php&id_sementara=$id_sementara'</script>";
?>
<section class="content">
<!--    --><?php //echo $id_sementara;?><!--::-->
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">sDetail Informasi Permintaan</h3>
                </div>
                <form method="post"  action="uploadbukti.php"  class="form-horizontal" enctype="multipart/form-data">
                    <input class="hidden" type="text" name="id_sementara" value="<?php echo $id_sementara; ?>">
                    <div class="box-body">
                        <div class="form-group ">
                            <label for="username" class="col-sm-offset-1 col-sm-3 control-label">Tgl Pengajuan</label>

                            <div class="col-sm-4">
                                <input readonly="readonly"  required type="text"  class="form-control" value="<?php echo $tgl_permintaan?>">
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
                            <label for="bendahara" class="col-sm-offset-1 col-sm-3 control-label">Bendahara</label>
                            <div class="col-sm-4">
                                <input readonly="readonly" required type="text"  class="form-control" value="<?php echo $bendahara?>">
                            </div>
                        </div>

                        <div class="form-group ">
                            <center>
                                    <img id="uploadPreview" style="width: 150px; height: 150px;" /><br>
                                    <input type="file" name="gambar" id="fileToUpload" onchange="PreviewImage()"><br>
                            </center>
<!--                            <input type="text" name="test" id="" value="budi">-->

                        </div>





                        <div class="form-group">
                            <input type="submit" name="simpan" class="btn btn-primary col-sm-offset-4 " value="Simpan" >
                            &nbsp;
                            <input type="reset" class="btn btn-danger" value="Batal">
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
            if(size_gambar <= 387057){
                oFReader.onload = function (oFREvent)
                {
                    document.getElementById("uploadPreview").src = oFREvent.target.result;
                };
            } else {
                alert("Size max : 300Kb");
            }

        };
    </script>
</section>

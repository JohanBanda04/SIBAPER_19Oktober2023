<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
$error = "";


?>

<section class="content">
    <div class="row">
        <div class="col-sm-5 col-xs-12">
            <!--Kolom Sebelah Kiri-->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Form Permintaan Barang</h3>
                </div>
                <form method="post" id="tes" action="add-proses.php" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group ">
                            <label for="nama_brg" class="a col-sm-3 control-label">Nama</label>
                            <div class="col-sm-3">
                                <input type="text" readonly value="<?= $_SESSION['username']; ?>" class="form-control"
                                       name="unit">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="instansi" class=" col-sm-3 control-label">Role</label>
                            <div class="col-sm-5">
                                <input id="instansi" type="text" readonly value="<?= $_SESSION['jabatan']; ?>"
                                       class="form-control" name="instansi">
                            </div>
                            <span class="col-sm-7"> <?php echo $error; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="jenis_brg" class=" col-sm-3 control-label">Jenis Barang</label>
                            <div class="col-sm-6">
                                <select id="jenis_brg" required="isikan dulu" class="form-control" name="id_jenis">
                                    <option value="">--Pilih Jenis Barang--</option>
                                    <?php
                                    include "../fungsi/koneksi.php";
                                    $queryJenis = mysqli_query($koneksi, "select * from jenis_barang");
                                    if (mysqli_num_rows($queryJenis)) {
                                        while ($row = mysqli_fetch_assoc($queryJenis)):
                                            ?>
                                            <option value="<?= $row['id_jenis']; ?>"><?= $row['jenis_brg']; ?></option>
                                        <?php endwhile;
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <!--di getData.php telah ditentukan value dan nama barang yg ditampilkan-->
                            <label for="nama_brg" class="col-sm-3 control-label">Nama Barang</label>
                            <div class="col-sm-6">
                                <select id="nama_brg" required="isikan dulu" class="form-control" name="kode_brg">
                                    <option value="">--Pilih Nama Barang--</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stok" class="col-sm-3 control-label">Stok Tersedia</label>
                            <div class="col-sm-3">
<!--                                <input name="stok" id="stok" disabled value="----" type="text" class="form-control">-->
                                <input name="stok" id="stok" readonly value="----" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stok" class=" col-sm-3 control-label">Jumlah</label>
                            <div class="col-sm-3">
                                <!--definiskan jumlah minimal barang-->
                                <input min="0" name="jumlah" id="jumlah" type="text" onkeyup="sendAjax()"
                                       class="form-control" name="jumlah" required>
                            </div>
                            <span class="col-sm-7"> <?php echo $error; ?></span>
                        </div>


                        <div class="form-group">
                            <input type="submit"
                                   id="simpan"
                                   name="simpan"
                                   class="btn btn-primary col-sm-offset-3 "
                                   value="Simpan">
                            &nbsp;
                            <input type="reset" class="btn btn-danger" value="Batal">
                            <!--                                <a href="index.php?p=datapesanan" style="margin:10px;" class="btn btn-success"><i class='fa fa-backward'>  Kembali</i></a>-->
                            <a href="index.php?p=datapesanan" style="margin:10px;" class="btn btn-success"><i
                                        class='fa fa-backward'> Kembali</i></a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!--Kolom Sebelah Kanan-->
        <div class="col-sm-7 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <!--                    <h3 class="text-center">Data Permintaan Hari Ini</h3>-->
                    <h3 class="text-center">Data Permintaan <?php echo $_SESSION['username'] ?></h3>
                </div>

                <div style="height: 10px">

                </div>

                    <!--status tidak terset-->

                    <table class="table table-responsive">
                        <tr>
                            <th>No</th>
                            <th class="hidden">Id Permintaan</th>
                            <th>Tgl Permintaan</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>


                        <?php
                        $nama_unit = "";
                        $tgl_minta = "";
                        ?>
                        <tr>
                            <?php


                            $sekarang = date("Y-m-d");

                            //cek mulai disini, yg ditampilkan hanya data berstatus "Permintaan Baru"

                            $queryTampil = mysqli_query($koneksi, "SELECT sementara.unit,  
sementara.id_sementara, stokbarang.nama_brg, stokbarang.satuan, sementara.kode_brg, sementara.tgl_permintaan ,
sementara.pemberitahuan_kasub, sementara.acc_kasub,sementara.status_acc,
jumlah FROM sementara INNER JOIN 
stokbarang ON sementara.kode_brg  = stokbarang.kode_brg WHERE sementara.user_id='$_SESSION[user_id]' 
AND status_acc='Permintaan Baru'");
                            $cekdata = intval(mysqli_num_rows($queryTampil));
                            $no = 1;
                            if (mysqli_num_rows($queryTampil) > 0) {
                            while ($row = mysqli_fetch_assoc($queryTampil)){

                            ?>
                            <td><?php echo $no; ?></td>
                            <td class="hidden"><?php echo $row['id_sementara']; ?></td>
                            <td><?= tanggal_indo($row['tgl_permintaan']); ?></td>
                            <td><?php echo $row['kode_brg']; ?></td>
                            <td><?php echo $row['nama_brg']; ?></td>
                            <td><?php echo $row['jumlah']; ?> </td>
                            <td><?php echo $row['satuan'] ?></td>
                            <td>
                                <a href="hapusps.php?id=<?php echo $row['id_sementara']; ?>" class="btn btn-danger"
                                   onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fa fa-remove"></i>
                                </a>

                            </td>


                            <?php
                            $nama_unit = $row['unit'];
                            $tgl_minta = $row['tgl_permintaan'];

                            ?>
                        </tr>
                        <?php $no++;
                    }
                    } else {
                        echo "<tr><td>Tidak ada permintaan barang hari ini</td></tr>";
                    } ?>
                    </table>
                    <div class="box-body">

                        <?php if ($cekdata != 0) { ?>
                            <a class="hide btn btn-success disabled" href="pesan.php">sMinta Barang</a>
                        <?php } else if ($cekdata == 0) { ?>
                            <a class="hide btn btn-success disabled" href="belumpesan.php">Minta Barang</a>
                        <?php } ?>
                        <a class="btn btn-success"
                           style="background-color: #1b860c"
                           href="ajukan_via_kasub.php?unit=<?php echo $nama_unit ?>&tgl_minta=<?php echo $tgl_minta ?>">
                            PPemberitahuan Kasub
                        </a>

                    </div>




            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $("#jenis_brg").change(function () {
            // var jenis = $(this).val();
            var jenis = $('#jenis_brg').val();
            var dataString = 'jenis=' + jenis;
            $.ajax({
                type: "POST",
                url: "getdata.php",
                data: dataString,
                success: function (html) {
                    $("#nama_brg").html(html);
                    $("#stok").val("");
                    $("#jumlah").val("");
                    // $("#nama_brg").html(html);
                    // saat diklik Jenis Barang->Nama Barang dan Stok Tersedia (kosongin)
                }
            });
        });

        $("#nama_brg").change(function () {
            var kode = $(this).val();
            // var kode = $('#nama_brg').val();
            var dataString = 'kode=' + kode;
            $.ajax({
                type: "POST",
                url: "getkode.php",
                data: dataString,
                success: function (html) {
                    $("#stok").val(html);
                }
            });
        });

        $('#cariStatus').click(function () {
            var cari_status = $('#cari_status').val();

            var dataString = 'status=' + cari_status;

            $.ajax({
                type: "POST",
                url: "getstatus.php",
                data: dataString,
                success: function (html) {
                    $("#stok").val(html);
                }
            });
        });


    });


    function cek_stok() {
        var jumlah = $("#jumlah").val();
        var kode_brg = $("#nama_brg").val();
        $.ajax({
            url: 'cekstok.php',
            data: "jumlah=" + jumlah + "&kode_brg=" + kode_brg,
            dataType: 'json',
        }).success(function (data) {


            if (data.hasil == 1) {
                $("#tes").submit(function (e) {
                    e.preventDefault();
                    alert(data.pesan);
                });
            }


        });
    }

    //cek disini untuk jumlah
    //metode ajax kirim multidata
    function sendAjax() {
        setTimeout(
            function () {
                var jumlah = $("#jumlah").val();
                var kode_brg = $("#nama_brg ").val();
                $.ajax({
                    url: 'cekstok.php',
                    data: "jumlah=" + jumlah + "&kode_brg=" + kode_brg,
                    dataType: 'json',
                }).success(function (data) {


                    if (data.hasil == 1) {

                        alert(data.pesan);
                        $("#jumlah").val("");

                    }


                });
            }, 500);
    }
</script>
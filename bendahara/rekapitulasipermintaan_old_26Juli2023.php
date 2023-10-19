<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-left">Rekapitulasi Permintaan Baraang</h3>
                </div>


                <div class="col-md-12">
                    <!--<form method="POST" action='cetak_laprekapitulasipermintaan.php' target="_blank"-->
                    <!--<form method="POST" action='' target="_blank"  class="form-inline">-->
                    <form method="POST" class="form-inline">
                        <div class="form-group">
                            <label> Dari Tanggal </label>
                            <input value="<?php echo date('Y-m-d'); ?>" type="date" id="tanggala" class="form-control"
                                   name="tanggala" required>
                        </div>
                        <div class="form-group">
                            <label> Sampai Tanggal </label>
                            <input value="<?php echo date('Y-m-d'); ?>" type="date" id="tanggalb" class="form-control"
                                   name="tanggalb" required>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <select name="kode_barang" class="form-control" id="">
                                    <!--// disini pakai metode filter berdasarkan jenis barang , filter by jenis barang SUKSES-->
                                    <option value="" class="text-center">--Jenis Barang--</option>
                                    <?php
                                    $query_get_brg = mysqli_query($koneksi, "select id_kode_brg,kode_brg,nama_brg from stokbarang");

                                    while ($item = mysqli_fetch_array($query_get_brg)) { ?>

                                        <option <?php if ($_SESSION['sesi_kode_barang_lengkap'] == $item['kode_brg']) { ?>
                                            selected
                                        <?php } ?> value="<?php echo $item['kode_brg'] ?>" class="text-center">
                                            <?php echo $item['nama_brg']; ?>
                                        </option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">&emsp;
                            <input type='submit' name="tampilkan" value="Viewt" class='btn btn-success'>
                        </div>
                        <!--untuk enter-->
                        <div style="margin-top: 20px">

                        </div>
                        <div class="form-group hidden">

                            <input type='submit' name="POST" value="Cetakz" class='btn btn-success'>


                        </div>


                    </form>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="datapesanan" class="table text-center">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Permintaan</th>
                                <th>Instansi</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include "../fungsi/koneksi.php";
        include "../fungsi/fungsi.php";

        $_SESSION['sesi_jenis_barang'] = "";
        $_SESSION['sesi_kode_barang'] = "";
        $_SESSION['sesi_kode_barang_lengkap'] = "";
        //PASTE DISINI
        if (isset($_POST['tampilkan'])) {
            //echo "tampilkan"; die;
            $tanggala = $_POST["tanggala"];
            $tanggalb = $_POST["tanggalb"];
            $kode_barang = $_POST["kode_barang"] ?? "";
//            $unit = $_POST["unit"];
            $_SESSION['sesi_kode_barang_lengkap'] = $_POST['kode_barang'];

            if(isset($_SESSION['sesi_kode_barang_lengkap'])){
                if($_SESSION['sesi_kode_barang_lengkap']!=""){
                    echo "sesi kode barang terset dan ADA isi:".$_SESSION['sesi_kode_barang_lengkap'];
                    $nama_barang = $_SESSION['sesi_kode_barang_lengkap'];
                    //BENAHI DISINI
                } else if($_SESSION['sesi_kode_barang_lengkap']==""){
                    echo "sesi kode barang terset dan TIDAK ADA isis:".$_SESSION['sesi_kode_barang_lengkap'];
                    $nama_barang = "Semua Jenis Barang";
                }
            } else if(!isset($_SESSION['sesi_kode_barang_lengkap'])){
                echo "sesi kode barang TIDA terset dan TIDAK ADA isi:".$_SESSION['sesi_kode_barang_lengkap'];
                $nama_barang = "Semua Jenis Barang";
            }
            //BENAHI DISINI LANJUTKAN

//            if($_POST['kode_barang']!=""){
//                $get_nama_brg = mysqli_query($koneksi,"select * from stokbarang where kode_brg='$_POST[kode_barang]'");
//                while($item = mysqli_fetch_array($get_nama_brg)){
//                    $nama_barang = $item['nama_brg'];
//                }
//
//                $_SESSION['nama_barang'] = $nama_barang;
//            } else if ($_POST['kode_barang']==""){
//                $_SESSION['nama_barang'] = "Semua Jenis Barang";
//            }


//            echo "<br> test : ".$_SESSION['nama_barang']??""."<br>";

            $_SESSION['tanggala'] = $tanggala;
            $_SESSION['tanggalb'] = $tanggalb;

            $kode_barang = $_POST['kode_barang'] ?? "";
            $_SESSION["sesi_kode_barang_lengkap"] = $_POST['kode_barang'] ?? "";

            echo $tanggala . "::";
            echo $tanggalb . "::";
            // LANJUTKAN DISINI CUY
            echo "kode brg cuy::" . $kode_barang . "::";
        }

        ?>
        <div class="col-sm- col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="form-group">
                        <!-- Untuk Cetak -->

                        <?php

//                        $query_get_id_user = mysqli_query($koneksi,"select * from user where username='$unit'");
//                        while($item = mysqli_fetch_array($query_get_id_user)){
//                            $id_user = $item['id_user'];
//                        }
                        //                echo $id_user;
                        ?>
                        <div class="col-md-12">
                            <form method="POST" action='cetak_lap_detilpermintaan.php' target="_blank" class="form-inline">
                                <div class="form-group">
                                    <label> Periodet</label>
                                    <input readonly type="text"  value="<?php echo $id_user; ?>"
                                           id="user_id" class="hide form-control hidden"
                                           name="user_id" >
                                    <input readonly type="text"  value='<?= ($tanggala??''); ?>'
                                           id="tanggala" class="form-control"
                                           name="tanggala" required>
                                </div>
                                <div class="form-group">
                                    <label> s/d </label>
                                    <input readonly type="text"  value='<?= ($tanggalb??''); ?>'
                                           id="tanggalb" class="form-control"
                                           name="tanggalb" required>
                                </div>&emsp;
                                <div class="form-group">
                                    <label>  Jenis Brg </label>

                                    <input readonly type="text"  value='<?= $nama_barang??'';?>'
                                           id="unit" class="form-control"
                                           name="unit" required>
                                </div>

                                <!--lampiran post-->
                                <?php if(isset($_SESSION['sesi_kode_barang_lengkap'])){
                                    if($_SESSION['sesi_kode_barang_lengkap']!=""){
                                        ?>
                                        <div class="form-group hidden">
                                            <label>  Kode Barang </label>
                                            <input readonly type="text"  value='<?= $_SESSION['sesi_kode_barang_lengkap']; ?>'
                                                   id="kode_brg_lengkap" class="form-control" name="kode_brg_lengkap" required>
                                        </div>
                                        <?php
                                    } else if($_SESSION['sesi_kode_barang_lengkap']==""){
                                        ?>
                                        <div class="form-group hidden">
                                            <label>  Kode Barang </label>
                                            <input readonly type="text"  value=''
                                                   id="kode_brg_lengkap" class="form-control" name="kode_brg_lengkap" required>
                                        </div>
                                        <?php
                                    }
                                } else if (!isset($_SESSION['sesi_kode_barang_lengkap'])){ ?>
                                    <div class="form-group hidden">
                                        <label>  Kode Barang </label>
                                        <input readonly type="text"  value=''
                                               id="kode_brg_lengkap" class="form-control" name="kode_brg_lengkap" required>
                                    </div>
                                    <?php

                                }?>

                                <div class="form-group">

                                    <input type='submit' name="POST" value="Cetakt" class='btn btn-success'>


                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Untuk Cetak -->
                </div>
                <table class="table table-responsive" id="rekapitulasipermintaan_operator">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Permintaan</th>
                        <th>Nama</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>

</section>
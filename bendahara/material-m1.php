<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

//echo $_GET['id_jenis']."::";
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    //die($id = $_GET['id']);
    $id = $_GET['id'];
    echo $id;

    if ($_GET['aksi'] == 'edit') {
        header("location:?p=edit-m1&id=$id");
    } else if ($_GET['aksi'] == 'hapus') {
        header("location:?p=hapusmaterial-m1&id=$id");
    }
}

if (isset($_GET['id_jenis']) ? $_GET['id_jenis'] : '') {
    $id_jenis = $_GET['id_jenis'];
    $query = mysqli_query($koneksi, "SELECT * FROM stokbarang WHERE id_jenis='$id_jenis' ");

    $query_get_nama_kategori = mysqli_query($koneksi, "select * from jenis_barang where id_jenis='$id_jenis'");

    while ($dt = mysqli_fetch_array($query_get_nama_kategori)) {
        $nama_kategori = $dt['jenis_brg'];
    }


} else {
    $query = mysqli_query($koneksi, "SELECT * FROM stokbarang");
}


?>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Olah Data Stok Baraang <span
                                style="font-weight: bold"><?php echo $nama_kategori; ?></span></h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <!--untuk jarak kanan-->
                        <div class="col-md-2" style="margin-right: 20px">
                            <a href="index.php?p=tambahmaterial-m1" class=" btn btn-primary"><i class="fa fa-plus"></i>
                                Tambah Data Stok</a><br>
                        </div>

                        <div hidden class="form-group">
                            <div class="col-sm-3">
                                <select name="kode_barang" class="form-control">
                                    <option value="" class="text-center">--Jenis Barang--</option>
                                    <!--contoh selected barang agar tetap terselect ketika sudah disubmit-->
                                    <?php
                                    $query_get_brg = mysqli_query($koneksi,"select id_kode_brg,kode_brg,nama_brg from stokbarang");
                                    while($item = mysqli_fetch_array($query_get_brg)){

                                        ?>
                                        <option <?php
                                        if($_SESSION["sesi_kode_barang_lengkap"]==$item['kode_brg']) { ?>
                                            selected
                                        <?php }
                                        ?> value="<?php echo $item['kode_brg']?>"
                                           class="text-center">
                                            <?php echo $item['nama_brg'] ;?>
                                        </option>
                                        <?php
                                    }
                                    ?>


                                </select>
                            </div>
                            <div class="form-group" style="margin-top: 10px">&emsp;
                                <input type='submit' name="tampilkan" value="Lihat" class='btn btn-success'>
                            </div>
                        </div>



<!--                        <div class="col-md-2">-->
<!--                            <a href="index.php?p=tambahmaterial-m1" class=" btn btn-primary"><i class="fa fa-plus"></i>-->
<!--                                Tambah Data Stok</a><br>-->
<!--                        </div>-->

                        <!--lanjutkan disini-->
                        <div class="col-md-2 pull-right">
                            <a target="_blank" href="cetakstok.php?idjenis=<?= $id_jenis; ?>" class="btn btn-success">
                                <i class="fa fa-print"></i>
                                Cetak Data Stoks
                            </a>
                            <br>
                        </div>

                        <div hidden class="col-md-2 pull-right">
                            <a target="_blank" href="material-m1-excel.php" class="btn btn-warning">
                                <i class="fa fa-print"></i>
                                Download Excel
                            </a>
                            <br>
                        </div>
                        <br><br>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center" id="material">
                            <thead>
                            <tr>
                                <th>No</th>

                                <th>Kode Barang</th>
                                <th>Nama Barang</th>

                                <!--harga disembunyikan-->
                                <th hidden >Harga Barang</th>
                                <th>Satuan</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Sisa</th>
                                <th>Keterangan</th>
                                <th>Operator</th>

                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--            <tr>-->
                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)):

                                    ?>
                                    <tr>
                                        <td> <?= $no; ?> </td>

                                        <td> <?= $row['kode_brg']; ?> </td>
                                        <td style="text-align: left;"> <?= $row['nama_brg']; ?> </td>

                                        <!--harga disembunyikan-->
                                        <td hidden > <?= number_format($row['hargabarang']); ?> </td>
                                        <td > <?= $row['satuan']; ?> </td>

                                        <td> <?= $row['stok']; ?> </td>
                                        <td> <?= $row['keluar']; ?> </td>
                                        <td> <?= $row['sisa']; ?> </td>
                                        <td> <?= $row['keterangan']; ?> </td>
                                        <td> <?= $row['bendahara']; ?> </td>


                                        <td>
                                            <a href="?p=material-m1&aksi=edit&id=<?= $row['kode_brg']; ?>">
                      <span data-placement='top' data-toggle='tooltip' title='Update'>
                          <button class="btn btn-info">Update</button>
                      </span>
                                            </a>

                                            <a href="?p=material-m1&aksi=hapus&id=<?= $row['kode_brg']; ?>">
                      <span data-placement='top' data-toggle='tooltip' title='Hapus'>
                          <button class="btn btn-danger"
                                  onclick="return confirm('Yakin ingin menghapus ?')">Hapus</button>
                      </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $no++; endwhile;
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        $("#material").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script> 
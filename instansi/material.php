<?php

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if (isset($_GET['id_jenis'])) {
    $id_jenis = $_GET['id_jenis'];
    $query = mysqli_query($koneksi, "SELECT * FROM stokbarang WHERE id_jenis='$id_jenis' ");

    $jenis_brg = "";
    $jenisBarang = mysqli_query($koneksi, "SELECT jenis_brg FROM jenis_barang WHERE id_jenis='$id_jenis' ");
    if (mysqli_num_rows($jenisBarang)) {
        while ($dt = mysqli_fetch_assoc($jenisBarang)) {
            $jenis_brg = $dt['jenis_brg'];
        }
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
                    <h3 class="text-center">Data Stok Barang <?= $jenis_brg; ?></h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table text-center" id="material">
                            <thead style="background-color: #b6eee0">
                            <tr>
                                <th style="color: black">No</th>
                                <th style="color: black">Kode Barang</th>
                                <th style="color: black">Nama Barang</th>
                                <th style="color: black">Satuan</th>
                                <th style="color: black">Keluar</th>
                                <th style="color: black">STOK</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                $total_keluar = 0;
                                $total_stock = 0;
                                ?>

                                <?php
                                $no = 1;
                                if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)):
                                ?>
                                <td> <?= $no; ?> </td>
                                <td> <?= $row['kode_brg']; ?> </td>
                                <td style="text-align: left;" ;> <?= $row['nama_brg']; ?> </td>
                                <td> <?= $row['satuan']; ?> </td>
                                <td> <?= $row['keluar']; ?> </td>
                                <td> <?= $row['stok']; ?> </td>
                                <?php $total_keluar += $row['keluar']; ?>
                                <?php $total_stock += $row['stok']; ?>
                            </tr>
                            <?php $no++;
                            endwhile;
                            } ?>
                            </tbody>
                            <tfoot class="bg-carrot-900 text-white p-2">
                            <td style="background-color: #b6eee0; " colspan="4"
                                class="text-center font-semibold border border-green-400 p-2">
                            <span style="color: rgba(0,0,0,1); font-weight: bold"
                                  class="border border-double bg-carrot-500 p-1 rounded-lg">
                                Grand Total
                            </span>
                            </td>
                            <td style="font-weight: bold;background-color: #b6eee0" colspan="1"
                                class="text-center font-semibold border border-green-400 p-2">
                          <span style="color: #000000; font-weight: bold"
                                class="border border-double bg-carrot-500 p-1 rounded-lg">
                                <?= $total_keluar ?>
                          </span>
                            </td>
                            <td style="font-weight: bold;background-color: #b6eee0" colspan="1"
                                class="text-center font-semibold border border-green-400 p-2">
                          <span style="color: #000000; font-weight: bold"
                                class="border border-double bg-carrot-500 p-1 rounded-lg">
                                <?= $total_stock ?>
                          </span>
                            </td>
                            </tfoot>
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
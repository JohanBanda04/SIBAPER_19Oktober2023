<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$tgl_satu_bulan_lalu = date("Y-m-d", strtotime("-1 month"));
if (isset($_GET['aksi']) && isset($_GET['tgl'])) {
    $tgl = $_GET['tgl'];
    echo $tgl;
    if ($_GET['aksi'] == 'detil') {
        header("location:?p=detil&tgl=$tgl");
    }
}

$query_group_by_tgl = mysqli_query($koneksi,"select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");





?>
<!--Isi Utama dari menu Data Permintaan Barang (Side Instansi)-->
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">iData Permintaan Barang </h3>
                </div>


                <div class="box-body">
                    <a href="index.php?p=formpesan" style="margin:10px 15px; background-color: #486055" class="btn btn-success">
                        <i class='fa fa-plus' style="color: white; font-weight: bold">
                            Form Permintaan Barang
                        </i>
                    </a>
                    <div class="table-responsive">
                        <table class="table text-center" id="datapesanan_table">
                            <thead style="background-color: #b6eee0">
                            <tr>
                                <th style="color: black">No</th>
                                <th style="color: black">Tanggal Permintaan</th>
                                <th style="color: black">Jumlah Permintaan</th>
                                <th style="color: black">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($query_group_by_tgl)) {
                                while ($row = mysqli_fetch_assoc($query_group_by_tgl)):
                                ?>
                                <td> <?= $no; ?> </td>
                                <td> <?= tanggal_indo($row['tgl_permintaan']); ?> </td>
                                <td> <?= $row['jumlah_permintaan']; ?> </td>
                                <td>
                                    <!--error disini, saat klik detail permintaan, tidak di redirect-->
<!--                                    <a href="?p=datapesanan&aksi=detil&tgl=--><?//= $row['tgl_permintaan']; ?><!--">-->
                                    <a href="?p=detil&tgl=<?= $row['tgl_permintaan']; ?>">
                                                <span style="font-weight: bold" data-placement='top'
                                                      data-toggle='tooltip' title='Detail Permintaan'>
                                                    <button class="btn btn-info" style="font-weight: bold">Detail Permintaan</button>
                                                </span>
                                    </a>

                                    <!--dibawah ini hanya sebagai acuan utk mencontoh format penulisan-->
<!--                                    <a href="?p=detil_datapengeluaran&unit=--><?//= $row['unit'];?><!--&tgl=--><?//= $row['tgl_permintaan']; ?><!--"><span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'><button class="btn btn-info">Detail Barang</button></span></a>-->
                                </td>
                            </tr>

                            <?php $no++;
                            endwhile;
                            } else {
                                echo "<tr><td colspan=9>Tidak ada Data.</td></tr>";
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
        $("#datapesanan_table").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>


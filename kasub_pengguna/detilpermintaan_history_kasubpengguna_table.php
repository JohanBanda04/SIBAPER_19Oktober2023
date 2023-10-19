<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if (isset($_GET['unit']) && isset($_GET['user_id']) && isset($_GET['tgl_permintaan'])) {
    $unit = $_GET['unit'];
    $user_id = $_GET['user_id'];
    $tgl_permintaan = $_GET['tgl_permintaan'];

    if(isset($_GET['kode_brg_lengkap'])){
        if($_GET['kode_brg_lengkap']!=""){
            //echo "<br> get kode barang DISET dan ADA ISINYA =".$_GET['kode_brg_lengkap']."<br>";
            $query = mysqli_query($koneksi, "select * from (sementara inner join stokbarang on 
sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' and user_id='$user_id' and 
sementara.kode_brg='$_GET[kode_brg_lengkap]' and
tgl_permintaan='$tgl_permintaan' and status_acc not IN ('Permintaan Baru','Pengajuan Kasub')");

        } else if($_GET['kode_brg_lengkap']==""){
            //echo "<br> get kode barang DISET dan TIDAK ADA ISINYA <br>";
            $query = mysqli_query($koneksi,"select * from (sementara inner join stokbarang on 
sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' and user_id='$user_id' and 
tgl_permintaan='$tgl_permintaan' and status_acc not IN ('Permintaan Baru','Pengajuan Kasub')");
        }
    } else if(!isset($_GET['kode_brg_lengkap'])){
        //echo "<br> get kode barang TIDAK DISET dan TIDAK ADA ISINYA CUY <br>";
        $query = mysqli_query($koneksi,"select * from (sementara inner join stokbarang on 
sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' and user_id='$user_id' and 
tgl_permintaan='$tgl_permintaan' and status_acc not IN ('Permintaan Baru','Pengajuan Kasub')");
    }

    $query_old_v1 = mysqli_query($koneksi, "select * from (sementara inner join stokbarang on 
sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' and user_id='$user_id' and 
tgl_permintaan='$tgl_permintaan' and status_acc not IN ('Permintaan Baru','Pengajuan Kasub')");


}


?>


<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php
                    $get_nama_pemohon = mysqli_query($koneksi, "Select nama_lengkap from `user` where id_user='$user_id'");

                    ?>
                    <h3 class="text-center">History Permintaan <b><?php echo mysqli_fetch_assoc($get_nama_pemohon)['nama_lengkap']; ?></b></h3><br>
                    <h4 class="text-center" style="font-weight: bold"><?php echo tanggal_indo($tgl_permintaan) ?></h4>
                </div>
                <div class="box-body">
                    <!--                    p=history_kasub&pa=history_kasub_pengguna-->
                    <a href="index.php?p=history_kasub_table&pa=history_kasub_pengguna" style="margin:10px;"
                       class="btn btn-success"><i
                                class='fa fa-backward'> Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center" id="detilpermintaan_subbidang">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Sementara</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                            </thead>


                            <tbody>
                            <!--                            <tr>-->
                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)):


                                    if ($row['status_acc'] != null) {
                                        ?>
                                        <tr>
                                        <!--jika belum disetujui-->
                                        <td> <?= $no; ?> </td>
                                        <td> <?= $row['id_sementara']; ?> </td>
                                        <td> <?= $row['kode_brg']; ?> </td>
                                        <td> <?= $row['nama_brg']; ?> </td>
                                        <td> <?= $row['satuan']; ?> </td>
                                        <td> <?= $row['jumlah']; ?> </td>
                                        <td> <?php if ($row['status_acc'] == "tidak_setuju") {
                                                echo ucwords(str_replace("_", " ", $row['status_acc']));
                                            } else if ($row['status_acc'] == 'setuju') {
                                                echo ucwords($row['status_acc']);
                                            } else {
                                                echo $row['status_acc'];
                                            } ?> </td>


                                    <?php } ?>

                                    </tr>

                                    <?php $no++;

                                endwhile;
                            }  ?>
                            </tbody>
                        </table>

                        <script>
                            $(document).ready(function () {
                                $("#setujui").click(function () {
                                    document.getElementById('setujui').style.visibility = "hidden";
                                });
                            });

                            function showStuff(id, text, btn) {
                                document.getElementById(id).style.display = 'block';
                                // hide the lorem ipsum text
                                document.getElementById(text).style.display = 'none';
                                // hide the link
                                btn.style.display = 'none';
                            }

                            function klikLah(id, btn) {
                                const buttons = document.getElementById('a_setujui');
                                const sembunyi = document.getElementById('sembunyi');
                                document.getElementById(id).style.display = 'block';
                                // hide the lorem ipsum text
                                // document.getElementById(text).style.display = 'none';
                                // hide the link
                                // btn.style.display = 'none';
                                buttons.style.display = 'none';
                                sembunyi.style.visibility = "visible";
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" !src="">
        hiddenTidakDisetujui = function (id) {
            $(this).css('visibility', 'hidden');
            alert(id);
        };
        kirimNote = function (id) {
            alert(id);
        };
    </script>
</section>

<script>

    $(function () {
        $("#detilpermintaan_subbidang").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>
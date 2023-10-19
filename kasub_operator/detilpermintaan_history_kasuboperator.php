<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if(isset($_GET['unit']) && isset($_GET['user_id']) && isset($_GET['tgl_permintaan'])){
    $unit = $_GET['unit'];
    $user_id = $_GET['user_id'];
    $tgl_permintaan = $_GET['tgl_permintaan'];

    $query_old_1 = mysqli_query($koneksi,"select * from (sementara inner join stokbarang on 
sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' and user_id='$user_id' and 
tgl_permintaan='$tgl_permintaan' and status_acc not in ('Permintaan Baru','Pengajuan Kasub')");

    $query = mysqli_query($koneksi,"select * from (sementara inner join stokbarang on 
sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' and user_id='$user_id' and 
tgl_permintaan='$tgl_permintaan' and status_acc in ('Setuju Kasub Bendahara','Tidak Setuju Kasub Bendahara',
'Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')");

}



?>


<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Historyi Permintaan <?php echo $unit; ?></h3><br>
                    <h4 class="text-center"><?php echo tanggal_indo($tgl_permintaan)?></h4>
                </div>
                <div class="box-body">
                    <!--index.php?p=history_kasub_operator&pa=history_kasub_operator-->
                    <!--index.php?p=history_kasub_operator&pa=history_kasub_operator-->
                    <a href="index.php?p=history_kasub_operator&pa=history_kasub_operator" style="margin:10px;" class="btn btn-success"><i
                            class='fa fa-backward'> Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Bendahara</th>
                                <th>Id Sementara</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                            </thead>


                            <tbody>
                            <tr>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)):


                                if($row['status_acc']!=null){?>
                                    <!--jika belum disetujui-->
                                    <td> <?= $no; ?> </td>
                                    <td> <?= $row['bendahara']; ?> </td>
                                    <td> <?= $row['id_sementara']; ?> </td>
                                    <td> <?= $row['kode_brg']; ?> </td>
                                    <td> <?= $row['nama_brg']; ?> </td>
                                    <td> <?= $row['satuan']; ?> </td>
                                    <td> <?= $row['jumlah']; ?> </td>
                                    <td> <?=$row['status_acc']?> </td>



                                <?php } ?>

                            </tr>

                            <?php $no++;

                            endwhile;
                            } else {
                                echo "<tr><td colspan=9>Tidak ada permintaan material teknik.</td></tr>";
                            } ?>
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
                                const buttons  = document.getElementById('a_setujui');
                                const sembunyi  = document.getElementById('sembunyi');
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
        hiddenTidakDisetujui=function(id){
            $(this).css('visibility', 'hidden');
            alert(id);
        };
        kirimNote=function (id) {
            alert(id);
        };
    </script>
</section>
<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";


if(isset($_GET['unit']) && isset($_GET['user_id'])){
    $unit= $_GET['unit'];
    $user_id= $_GET['user_id'];
    $tgl_permintaan= $_GET['tgl_permintaan'];

//    echo $user_id.'-';
//    echo $unit.'-';
//    echo $tgl_permintaan;

//    $query = mysqli_query($koneksi,"select * from sementara");
}



$query_bk = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' AND user_id='$user_id' AND 
        status_acc='Pengajuan Kasub'");

$query = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
        AND user_id='$user_id' AND status_acc in('Pengajuan Kasub','tidak_setuju','setuju')");


?>


<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">KKonfirmasi Permintaan <?php echo $unit; ?></h3><br>
                    <center>
                        <span style="font-weight: bold; font-size: 25px"><?php echo tanggal_indo($tgl_permintaan);?></span>
                    </center>
                </div>
                <div class="box-body">
                    <a href="index.php?p=datapermintaan" style="margin:10px;" class="btn btn-success"><i
                                class='fa fa-backward'> Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Sementara</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
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
                                    <td> <?= $row['id_sementara']; ?> </td>
                                    <td> <?= $row['kode_brg']; ?> </td>
                                    <td> <?= $row['nama_brg']; ?> </td>
                                    <td> <?= $row['satuan']; ?> </td>
                                    <td> <?= $row['jumlah']; ?> </td>
                                    <td> <?=$row['status_acc']?> </td>

                                    <td>

                                        <?php


                                        $_SESSION['acc_kasub_temp'] = $row['acc_kasub'];

                                        ?>


                                        <?php
                                            if($row['status_acc'] != 'Pengajuan Kasub') { ?>
                                                <a id="a_setujui_fake" class=""
                                                   href="#">
                                        <span id="span_setujui_fake" data-placement='top' data-toggle='tooltip' title='Setujui'>
                                            <button id="button_setujui_fake"
                                                    class="btn btn-success disabled">
                                                Setujui
                                            </button>

                                        </span>
                                                </a>

                                                <a id="a_tidaksetuju_fake"
                                                   href="#" >
                                        <span  id="span_tidaksetujui_fake" data-placement='top' data-toggle='tooltip' title='Tidak Setuju'>
                                            <button id="tidaksetuju_fake"
                                                    class="btn btn-danger disabled">
                                                Tidak Setuju
                                            </button>

                                        </span>
                                                </a>
                                            <?php } else if ($row['status_acc'] == 'Pengajuan Kasub'){?>
<!--                                                <a id="a_setujui" class=""-->
<!--                                                   href="setuju.php?id_sementara=--><?//= $row['id_sementara']; ?><!--&unit=--><?//= $unit; ?><!--&tgl=--><?//= $tgl; ?><!--&status_acc=setuju">-->

                                                    <a id="a_setujui" class=""
                                                       href="setuju.php?id_sementara=<?php echo $row['id_sementara'];?>&user_id=<?php echo $row['user_id']?>&unit=<?php echo $row['unit'];?>&tgl_permintaan=<?php echo $row['tgl_permintaan'];?>">
                                        <span id="span_setujui" data-placement='top' data-toggle='tooltip' title='Setujui'>
                                            <button id="button_setujui"
                                                    class="btn btn-success  ">
                                                Setujui
                                            </button>

                                        </span>
                                                </a>


                                                <a id="a_tidak_setujui" class=""
                                                   href="index.php?p=alasan_tidak_setuju&id_sementara=<?php echo $row['id_sementara'];?>">
                                        <span id="alasan_tidak_setuju" data-placement='top' data-toggle='tooltip' title='Alasan Tidak Setuju'>
                                            <button id="alasan_tidak_setuju"
                                                    class="btn btn-danger  ">
                                                STidak Setujui
                                            </button>

                                        </span>
                                                </a>

<!--                                                <a id="a_tidaksetuju[--><?//= $row['id_sementara']; ?><!--]"-->
<!--                                                   href="tidaksetuju.php?id_sementara=--><?//= $row['id_sementara']; ?><!--&unit=--><?//= $unit; ?><!--&tgl=--><?//= $tgl; ?><!--&status_acc=tidak_setuju">-->
<!--                                        <span data-placement='top' data-toggle='tooltip' title='Tidak Setuju'>-->
<!--                                            <button id="tidaksetuju"-->
<!--                                                    class="btn btn-danger  ">-->
<!--                                                Tidak Setuju-->
<!--                                            </button>-->
<!---->
<!--                                        </span>-->
<!--                                                </a>-->
                                                <div class="alasan hidden">
                                                    <input type="text"  placeholder="Alasan"
                                                           id="alasan_tidak_setuju[<?=$row['id_sementara']?>]"
                                                           name="alasan_tidak_setuju[]">
                                                    <button id="btn_alasan[<?=$row['id_sementara']?>]" onclick="kirimNote(<?=$row['id_sementara']?>)">Update</button>
                                                    </div>
                                            <?php }
                                        ?>


                                        <?php
                                        $id_sementara = "" ;
                                        $tgl_permintaan = "";
                                        ?>


                                    </td>

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


<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";



if(isset($_GET['unit']) && isset($_GET['user_id'])){
    $unit= $_GET['unit'];
    $user_id= $_GET['user_id'];
    $tgl_permintaan= $_GET['tgl_permintaan'];



//    $query = mysqli_query($koneksi,"select * from sementara");
}

$query_bk = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id, sementara.bendahara FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' AND user_id='$user_id' AND status!=1");

$query = mysqli_query($koneksi, "SELECT sementara.id_sementara,sementara.tgl_permintaan, 
sementara.bendahara,sementara.bendahara_id,
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc,
 sementara.user_id FROM sementara
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg
WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' 
AND user_id='$user_id' 
AND status_acc in('Pengajuan Kasub Bendahara','Setuju Kasub Bendahara','Tidak Setuju Kasub Bendahara')");


?>


<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">kKonfirmasi Permintaan <?php echo $unit; ?></h3>
                </div>
                <div class="box-body">
                    <a href="index.php?p=datapermintaan&pas=permintaanbarang" style="margin:10px;" class="btn btn-success"><i
                                class='fa fa-backward'> Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Sementara</th>
                                <th>dBendahara Brg</th>
                                <th class="hide">Pemohon Brg</th>
                                <th class="hide">Id Pemohon</th>
                                <th class="hide">Tgl Permintaan</th>
<!--                                <th>Kode Barang</th>-->
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
                                    <td id="no"> <?= $no; ?> </td>
                                    <td id="id_sementara"> <?= $row['id_sementara']; ?> </td>

                                    <?php if($row['bendahara']=='' || $row['bendahara']==null) { ?>
                                        <td> Belum Ada </td>
                                    <?php } else { ?>
                                        <td> <?= $row['bendahara']; ?> </td>
                                    <?php } ?>
                                    <td id="unit" class="hide"> <?= $row['unit']; ?> </td>
                                    <td id="user_id" class="hide"> <?= $row['user_id']; ?> </td>
                                    <td id="tgl_permintaan" class="hide"> <?= $row['tgl_permintaan']; ?> </td>
<!--                                    <td> --><?//= $row['kode_brg']; ?><!-- </td>-->
                                    <td> <?= $row['nama_brg']; ?> </td>
                                    <td> <?= $row['satuan']; ?> </td>
                                    <td> <?= $row['jumlah']; ?> </td>
                                    <td> <?=$row['status_acc']?> </td>

                                    <td>

                                        <?php


                                        $_SESSION['acc_kasub_temp'] = $row['acc_kasub'];

                                        ?>


                                        <?php
                                        if($row['status_acc'] != 'Pengajuan Kasub Bendahara') { ?>
                                            <a id="a_setujui_fake" class=""
                                               href="">
                                        <span id="span_setujui_fake" data-placement='top' data-toggle='tooltip' title='Setujui'>
                                            <button id="button_setujui_fake"
                                                    class="btn btn-success disabled">
                                                Setujui
                                            </button>

                                        </span>
                                            </a>

                                            <a id="a_tidaksetuju_fake"
                                               href="">
                                        <span  id="span_tidaksetujui_fake" data-placement='top' data-toggle='tooltip' title='Tidak Setuju'>
                                            <button id="tidaksetuju_fake"
                                                    class="btn btn-danger disabled">
                                                Tidak Setuju
                                            </button>

                                        </span>
                                            </a>


                                        <?php } else if ($row['status_acc'] == 'Pengajuan Kasub Bendahara'){?>
                                            <!--                                                <a id="a_setujui" class=""-->
                                            <!--                                                   href="setuju.php?id_sementara=--><?//= $row['id_sementara']; ?><!--&unit=--><?//= $unit; ?><!--&tgl=--><?//= $tgl; ?><!--&status_acc=setuju">-->

                                            <a style="" id="a_setujui" class=""
                                               href="setuju.php?id_sementara=<?php echo $row['id_sementara'];?>&user_id=<?php echo $row['user_id']?>&unit=<?php echo $row['unit'];?>&tgl_permintaan=<?php echo $row['tgl_permintaan'];?>">
                                        <span style="" id="span_setujui" data-placement='top' data-toggle='tooltip' title='Setujui'>
                                            <button id="bt_setuju"
                                                    class="btn btn-success  ">
                                                Setujui
                                            </button>

                                        </span>
                                            </a>
                                            <form style="" method="post" action="alasan_tidak_setuju_kasub_operator.php">
                                                <input class="hidden" type="text" name="unit" id="unit" value="<?php echo $row['unit']; ?>">
                                                <input class="hidden" type="text" name="id_sementara" id="id_sementara" value="<?php echo $row['id_sementara']; ?>">
                                                <input data-toggle="tooltip" title="Tidak Setuju"
                                                       onclick="return confirm('Berikan Catatan Tidak Setuju?')"
                                                       type="submit" id="alasan_tidak_setuju_kasub_operator"
                                                       name="alasan_tidak_setuju_kasub_operator"
                                                       style="margin-left: 3px"
                                                       class="btn btn-danger col-sm-offset-3"
                                                       value="Tidak Setuju">



                                            </form>
<!--                                            <a id="a_tidak_setuju"-->
<!--                                               href="tidaksetuju.php?id_sementara=--><?php //echo $row['id_sementara'];?><!--&user_id=--><?php //echo $row['user_id']?><!--&unit=--><?php //echo $row['unit'];?><!--&tgl_permintaan=--><?php //echo $row['tgl_permintaan'];?><!--">-->
<!--                                        <span data-placement='top' data-toggle='tooltip' title='Tidak Setujus'>-->
<!--                                            <button id="bt_tidaksetuju"-->
<!--                                                    class="btn btn-danger bt-no-acc">-->
<!--                                                Tidak SSetuju-->
<!--                                            </button>-->
<!---->
<!--                                        </span>-->
<!--                                            </a>-->

                                            <div class="input-no-acc-<?php echo $row['id_sementara'];?> hide col-sm-4">
                                                <input type="text" value="" placeholder="Alasan Penolakan" class="form-control" name="kode_brg" >
                                                <!--                                                <input id="bt_setuju" type="text" value="" placeholder="Alasan Penolakan" class="form-control" name="" >-->
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
</section>

<script type="text/javascript">
    function TidakSetuju(){
        let TidakSetuju = document.getElementById('TidakSetuju');
        TidakSetuju.click(function(){

            var id_sementara = $('#id_sementara').val();
            var unit = $('#unit').val();
            var user_id = $('#user_id').val();
            var tgl_permintaan = $('#tgl_permintaan').val();
            // var dataString = 'id_sementara='+id_sementara+"&unit="+unit+"&user_id="+user_id+"&tgl_permintaan="+tgl_permintaan;
            $.ajax({
                type: "POST",
                url: "get_id_sementara.php",
                data: 'id_sementara='+id_sementara+"&unit="+unit+"&user_id="+user_id+"&tgl_permintaan="+tgl_permintaan,
                success: function (html) {
                    // $("#nama_brg").html(html);
                }
            });
        });
    }
    $(document).ready(function(){


        // let bt_tidaksetuju = document.getElementById('bt_tidaksetuju');
        //
        // bt_tidaksetuju.addEventListener('click',(ev)=>{
        //     let bt_setuju = document.getElementById('bt_setuju');
        //     let HTMLString = "<input id='' type='text' value='' placeholder='Alasan Penolakan' class='form-control'>";
        //     bt_setuju.outerHTML = HTMLString;
        //     let HTMLStrings =  "<div id='content'> <b> This text is inserted by setting the element.innerHTML. At </b>" + new Date();
        // });

    });
</script>


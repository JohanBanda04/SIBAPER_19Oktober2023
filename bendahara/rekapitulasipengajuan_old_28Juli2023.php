<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-left">CCek Rekapitulasi Pengajuan Barang</h3>
                </div>


                <div class="col-md-12">
<!--                    <form method="POST" action='cetak_laprekapitulasipengajuan.php' target="_blank" class="form-inline">-->
                    <form method="POST" class="form-inline">
                        <div class="form-group">
                            <label> Dari Tanggal </label>
                            <input value="<?php echo date('Y-m-d') ?>" type="date" id="tanggala" class="form-control"
                                   name="tanggala" required>
                        </div>
                        <div class="form-group">
                            <label> Sampai Tanggal </label>
                            <input value="<?php echo date('Y-m-d'); ?>" type="date" id="tanggalb" class="form-control"
                                   name="tanggalb" required>
                        </div>
                        <div class="form-group">

                            <!--                        <input type='submit' name="POST" value="Cetak" class='btn btn-success'>-->
                            <input type='submit' name="tampilkan" value="View" style="margin-left: 20px"
                                   class='btn btn-success'>


                        </div>
                    </form>
                </div>

            </div>
        </div>

        <?php
        include "../fungsi/koneksi.php";
        include "../fungsi/fungsi.php";

        if(isset($_POST["tampilkan"])){
            echo "tampilkan"; die;
        }
        ?>
    </div>
</section>
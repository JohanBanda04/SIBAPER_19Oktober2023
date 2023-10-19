<?php
include "../fungsi/koneksi.php";
$data_subbagAll = mysqli_query($koneksi,"select * from subbidang");
//echo "<pre>"; print_r($data_subbagAll); die;
$array_subbag = array();
$counter = 0;
$total = 0;
foreach ($data_subbagAll as $key=>$val){
    //echo $val['nama_subbidang']."<br>";
    $req_brg_by_subbag = mysqli_query($koneksi,"select * from `sementara` where id_subbidang='$val[id_subbidang]'");

    $req_brg_by_subbag_selesai_only = mysqli_query($koneksi,"select * from `sementara` where id_subbidang='$val[id_subbidang]' and `status_acc` = 'Selesai'");

    $req_brg_by_subbag_belum_selesai_only = mysqli_query($koneksi,"select * from `sementara` where id_subbidang='$val[id_subbidang]' and `status_acc` != 'Selesai'");

    $nama_subbag[$counter] = $val['nama_subbidang'];
    $id_subbag[$counter] = $val['id_subbidang'];

    //echo mysqli_num_rows($req_brg_by_subbag)."<br>";
    $subbag_reqbrg[$counter] = mysqli_num_rows($req_brg_by_subbag);

    $selesai_only[$counter] = mysqli_num_rows($req_brg_by_subbag_selesai_only);
    $belum_selesai_only[$counter] = mysqli_num_rows($req_brg_by_subbag_belum_selesai_only);

    //echo $req_brg_by_subbag['id_sementara'];
    //$subbag_reqbrg[$counter] = $req_brg_by_subbag->num_rows();

    $subbag_id[$counter] = $val['id_subbidang'];
    $total += mysqli_num_rows($req_brg_by_subbag);

    array_push($array_subbag,(object)[
        "id_subbag" => $val['id_subbidang'],
        "nama_subbag" => $val['nama_subbidang'],
        "jumlah_req_barang" => mysqli_num_rows($req_brg_by_subbag),
    ]);

    $counter ++;
}
//die;

$data['zona_subbag_list_ii'] = $nama_subbag;
$data['id_subbag_list_ii'] = $id_subbag;
$data['array_subbag'] = $array_subbag;
$data['realisasi_reqbrg_total'] = $subbag_reqbrg;

$data['selesai_only'] = $selesai_only;
$data['belum_selesai_only'] = $belum_selesai_only;

$data['subbag_id'] = $subbag_id;
$data['total'] = $total;
//die;
//echo "<pre>"; print_r($data['zona_subbag_list_ii']); die;
//echo "<pre>"; print_r($data['realisasi_reqbrg_total']); die;
?>
<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
    <div class="row">
        <!--cekcok-->
        <?php
        include "../fungsi/koneksi.php";
        $getUsers = mysqli_query($koneksi,"select count(nama_lengkap) as jml from user");
        ?>
        <div class="col-lg-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-red" style="border-radius: 20px">
                <div class="inner">
                    <p>
                        <font size="5px">
                            <b>
                                Data Pengguna
                                <span class="" style="border-radius: 20px; width: 100%; padding: 5px">
                        <?php
                        $dt = mysqli_fetch_assoc($getUsers);
                        echo " : ".$dt['jml'];
                        ?>
                    </span>
                            </b>
                        </font>
                    </p>
                    <p>Olah Data Pengguna</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="index.php?p=user&pa=DataUser" class="small-box-footer" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; ">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>



        <!-- ./col -->

        <?php
        include "../fungsi/koneksi.php";
        $getPermintaanUnvalid = mysqli_query($koneksi, "SELECT COUNT(status) as jml FROM permintaan WHERE status=0");
        ?>
        <div class="col-lg-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue" style="border-radius: 20px">
                <div class="inner">
                    <p>
                        <font size="5px"><b> Permintaan Barang
                                <span class="" style=" border-radius: 20px; width: 100%; padding: 5px">
                        <?php
                        $dt = mysqli_fetch_assoc($getPermintaanUnvalid);
                        echo " : ".$dt['jml'];
                        ?>
                    </span>
                            </b>
                        </font>
                    </p>
                    <p>Olah Data Permintaan Barang </p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="index.php?p=datapermintaan_table&pas=permintaanbarang" class="small-box-footer" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; ">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green" style="border-radius: 20px">
                <div class="inner">
                    <p><font size="5px"><b>Data Pengajuan Barang</b></font></p>
                    <p>Olah Data Pengajuan Barang </p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="index.php?p=datapengajuan_table&pas=datapengajuan" class="small-box-footer" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; ">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-yellow" style="border-radius: 20px">
                <div class="inner">
                    <p><font size="5px"><b>Data Stok Barang</b></font></p>
                    <p>Olah Data Stok Barang</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="index.php?p=material-m1&id_jenis=1&pas=atk" class="small-box-footer" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; ">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>


  <!-- ./col -->


      <div class="row">
          <div class="col-md-12">
              <div class="realisasi-card card" style="border-radius: 20px 20px 20px 20px; margin: 10px;">
                  <div class="card-body">
                      <!--grafik data paling awal bar chart zona daerah-->
                      <canvas id="bar_chart_zona_subbag" height="175">tes</canvas>
                  </div>
              </div>
          </div>
      </div>
      <div class="c-content-accordion-1 c-theme dashboard-all">
          <div class="panel-group" id="accordion" role="tablist">
              <?php
              //echo "<pre>"; print_r($array_satker) ;die;
              //echo "<pre>"; print_r($zona_satker_list_ii) ; die;
              ?>
              <?php
              $isFirst = true;
              foreach ($data['array_subbag'] as $key=>$val) {
                  //echo $val->nama_subbag."<br>";
                  ?>
                    <div class="panel" >
                        <div style=""
                             class="panel-heading dipa-accordion-btn" role="tab"
                             id="heading<?php echo $val->id_subbag; ?>" style="color: white">
                            <h4 class="panel-title">
                                <a class="c-font-bold c-font-19" data-toggle="collapse"
                                   data-parent="#accordion"
                                   href="#collapse<?php echo $val->id_subbag; ?>"
                                   aria-expanded="true"
                                   aria-controls="collapse<?php echo $val->id_subbag;?>">
                                    <?php echo $val->nama_subbag; ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?php echo $val->id_subbag; ?>"
                             class="panel-collapse collapse <?php if ($isFirst){ ?> in <?php }?>"
                             role="tabpanel"
                             aria-labelledby="heading<?php echo $val->id_subbag; ?>">
                            <div class="panel-body c-font-18">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="realisasi-card card">
                                            <div class="card-body">
                                                <div class="penyerapan-chart row">
                                                    <div class="col-md-5">
                                                        <canvas id="chart_penyerapan<?php echo $val->id_subbag; ?>"></canvas>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="dashboard-progress">
                                                            <div class="progress-title" style="color: white">
                                                                TOTAL PERMINTAAN BARANG
                                                            </div>
                                                            <div style="color: white" class="text-white progress-angka">
                                                                <?php
                                                                $req_brg_by_subbag = mysqli_query($koneksi,"select * from `sementara` where id_subbidang='$val->id_subbag'");

                                                                $req_brg_by_subbag_selesai = mysqli_query($koneksi,"select * from `sementara` where `id_subbidang`='$val->id_subbag' and `status_acc` = 'Selesai'");

                                                                $req_brg_by_subbag_belum_selesai = mysqli_query($koneksi,"select * from `sementara` where `id_subbidang`='$val->id_subbag' and `status_acc` !='Selesai'");

                                                                if((mysqli_num_rows($req_brg_by_subbag_selesai) + mysqli_num_rows($req_brg_by_subbag_belum_selesai)) > 0){
                                                                    $persentase_total = (mysqli_num_rows($req_brg_by_subbag) * 100) / (mysqli_num_rows($req_brg_by_subbag_selesai) + mysqli_num_rows($req_brg_by_subbag_belum_selesai)) ;

                                                                } else {
                                                                    $persentase_total = (mysqli_num_rows($req_brg_by_subbag) * 100) / (1) ;
                                                                }

                                                                $persentase_total_formatted = number_format($persentase_total,2,",","");

//                                                                if($persentase_total_formatted=='nan'){
//                                                                    $persentase_total_formatted = 0;
//                                                                }

                                                                echo mysqli_num_rows($req_brg_by_subbag) ." DOKUMEN"." (".$persentase_total_formatted." %)";
                                                                ?>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped" role="progressbar"
                                                                     style="<?php if ($persentase_total_formatted==0){ ?>
                                                                             width: 0%;
                                                                     <?php } else if($persentase_total_formatted > 0 ) { ?>
                                                                             width: 100%;
                                                                     <?php } ?>" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!--PERMINTAAN SELESAI-->
                                                        <div class="dashboard-progress">
                                                            <div class="progress-title" style="color: white">
                                                                TOTAL PERMINTAAN BARANG (SELESAI)
                                                            </div>
                                                            <div style="color: white" class="text-white progress-angka">
                                                                <?php
                                                                $req_brg_by_subbag = mysqli_query($koneksi,"select * from `sementara` where id_subbidang='$val->id_subbag'");

                                                                $req_brg_by_subbag_selesai = mysqli_query($koneksi,"select * from `sementara` where `id_subbidang`='$val->id_subbag' and `status_acc` = 'Selesai'");

                                                                $req_brg_by_subbag_belum_selesai = mysqli_query($koneksi,"select * from `sementara` where `id_subbidang`='$val->id_subbag' and `status_acc` != 'Selesai'");

                                                                if((mysqli_num_rows($req_brg_by_subbag_selesai) + mysqli_num_rows($req_brg_by_subbag_belum_selesai)) > 0){
                                                                    $persentase_total_selesai = (mysqli_num_rows($req_brg_by_subbag_selesai) * 100) / (mysqli_num_rows($req_brg_by_subbag_selesai) + mysqli_num_rows($req_brg_by_subbag_belum_selesai)) ;

                                                                } else {
                                                                    $persentase_total_selesai = (mysqli_num_rows($req_brg_by_subbag_selesai) * 100) / (1) ;
                                                                }

                                                                $persentase_total_selesai_formatted = number_format($persentase_total_selesai,2,",","");

                                                                //                                                                if($persentase_total_formatted=='nan'){
                                                                //                                                                    $persentase_total_formatted = 0;
                                                                //                                                                }

                                                                echo mysqli_num_rows($req_brg_by_subbag_selesai) ." DOKUMEN"." (".$persentase_total_selesai_formatted." %)";
                                                                ?>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-success progress-bar-striped " role="progressbar"
                                                                     aria-valuenow="<?php echo $persentase_total_selesai;  ?>"
                                                                     aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persentase_total_selesai; ?>%">
                                                                    <span class="sr-only"></span>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <!--PERMINTAAN BELUM SELESAI-->
                                                        <div class="dashboard-progress">
                                                            <div class="progress-title" style="color: white">
                                                                TOTAL PERMINTAAN BARANG (BELUM SELESAI)
                                                            </div>
                                                            <div style="color: white" class="text-white progress-angka">
                                                                <?php
                                                                $req_brg_by_subbag = mysqli_query($koneksi,"select * from `sementara` where id_subbidang='$val->id_subbag'");

                                                                $req_brg_by_subbag_selesai = mysqli_query($koneksi,"select * from `sementara` where `id_subbidang`='$val->id_subbag' and `status_acc` = 'Selesai'");

                                                                $req_brg_by_subbag_belum_selesai = mysqli_query($koneksi,"select * from `sementara` where `id_subbidang`='$val->id_subbag' and `status_acc` != 'Selesai'");

                                                                if((mysqli_num_rows($req_brg_by_subbag_selesai) + mysqli_num_rows($req_brg_by_subbag_belum_selesai)) > 0){
                                                                    $persentase_total_belum_selesai = (mysqli_num_rows($req_brg_by_subbag_belum_selesai) * 100) / (mysqli_num_rows($req_brg_by_subbag_selesai) + mysqli_num_rows($req_brg_by_subbag_belum_selesai)) ;

                                                                } else {
                                                                    $persentase_total_belum_selesai = (mysqli_num_rows($req_brg_by_subbag_belum_selesai) * 100) / (1) ;
                                                                }

                                                                $persentase_total_belum_selesai_formatted = number_format($persentase_total_belum_selesai,2,",","");

                                                                //                                                                if($persentase_total_formatted=='nan'){
                                                                //                                                                    $persentase_total_formatted = 0;
                                                                //                                                                }

                                                                echo mysqli_num_rows($req_brg_by_subbag_belum_selesai) ." DOKUMEN"." (".$persentase_total_belum_selesai_formatted." %)";
                                                                ?>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-danger progress-bar-striped " role="progressbar"
                                                                     aria-valuenow="<?php echo $persentase_total_belum_selesai;  ?>"
                                                                     aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persentase_total_belum_selesai; ?>%">
                                                                    <span class="sr-only"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              <?php
                  $isFirst=false;
              }
              //die;
              ?>
          </div>
      </div>
</section>

 <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
 <script>
     var subbag_id = <?php echo json_encode($data['subbag_id']);  ?>;
     console.log("subbag_id " + subbag_id);
     const realisasi_reqbrg_total = <?php echo json_encode($data['realisasi_reqbrg_total']); ?>;
     console.log(realisasi_reqbrg_total);

     const selesai_only = <?php echo json_encode($data['selesai_only']); ?>;
     console.log("selesai only : " + selesai_only);

     const belum_selesai_only = <?php echo json_encode($data['belum_selesai_only']); ?>;
     console.log("belum selesai only : " + belum_selesai_only);

     const total = <?php echo json_encode($data['total']); ?>;
     console.log(total);

     subbag_id.forEach(myFunction);
     function myFunction(value, key){
        //console.log("myFunction " + value);
        var kode_subbag = key;

         /*belum dipake*/
         var options = {
             tooltips : {
                 enabled:true
             },
             plugins: {
                 datalabels: {
                     formatter: (value, ctx) => {
                         // console.log(ctx);
                         let sum = 0;
                         let dataArr = ctx.chart.data.datasets[0].data;
                         //console.log(ctx.chart.data);
                         dataArr.map(data => {
                             sum += data;
                         });

                         //sum = realisasi_satker_total[kode_satker] + sisa_satker_aktual[kode_satker];
                     }
                 },
                 legend: {
                     labels:{
                         font:{
                             size: 24,
                         },
                     }
                 },
             },

         };

         var ctx = document.getElementById('chart_penyerapan' + value).getContext('2d');
         //console.log(value);
         var chart_penyerapan = new Chart(ctx,{
             type: "pie",
             data: {
                 labels: ['Permintaan Barang Selesai', 'Permintaan Barang Belum Selesai'],
                 datasets: [{
                     /*cuky*/
                     data: [selesai_only[key],belum_selesai_only[key]],
                     backgroundColor: [
                         'rgba(0, 172, 172, 1)',
                         'rgba(234, 66, 114, 1)'
                     ],
                     borderColor: [
                         'rgba(45, 53, 60, 1)',
                         'rgba(45, 53, 60, 1)'
                     ],
                     borderWidth: 2
                 }]
             },
             options: {
                 tooltips : {
                     enabled:true
                 },
                 plugins: {
                     datalabels: {
                         formatter: (value, ctx) => {
                             console.log(ctx.chart.data);
                             let sum = 0;
                             let dataArr = ctx.chart.data.datasets[0].data;
                             //console.log(ctx.chart.data);
                             dataArr.map(data => {
                                 sum += data;
                             });

                             //sum = realisasi_satker_total[kode_satker] + sisa_satker_aktual[kode_satker];
                         }
                     },
                     legend: {
                         labels:{
                             font:{
                                 size: 24,
                             },
                         },

                     },
                     labels:{
                         render: 'label',
                         precision: 1,
                         arc: false,
                         position: 'border',
                         fontColor:[
                             'rgba(255,26,104,1)',
                             'rgba(54,162,235,1)',
                             'rgba(255,206,86,1)',
                         ],
                     },
                 },

             }
         });

     }
 </script>
 <script>
     var zona_subbag_list = <?php echo json_encode($data['zona_subbag_list_ii']);  ?>;
     var id_subbag_list = <?php echo json_encode($data['id_subbag_list_ii']);  ?>;
     //console.log(zona_subbag_list);
     //console.log(id_subbag_list);
     var nama_zona_subbag = [];
     var persen_realisasi = [];

     zona_subbag_list.forEach(fungsi);
     function fungsi(val, key) {
         console.log(val);
         nama_zona_subbag[key] = val;
         /*kukus*/
         let realisasi = realisasi_reqbrg_total[key];

         persen_realisasi[key] = (Math.round(((realisasi / total) * 100) * 100) / 100).toFixed(2)
     }

     const labels = nama_zona_subbag;
     const ctx = document.getElementById('bar_chart_zona_subbag');
     const myChart = new Chart(ctx,{
         type : 'bar',
         data : {
             labels : nama_zona_subbag,
             datasets : [{
                 label: 'Presentase Permintaan Barang (%)',
                 data: persen_realisasi,//[100,2,4,5,6,7,8,9,10,11,12,13,14,5.5,16,17,18,19,20,21,22,23,24,25], //[100.0,75.6,87.8,100.0,91.6,84.9,74.4,86.2,71.7,86.8,83.0,78.5,75.9,85.5,91.6,89.5,94.9,84.0,64.7,90.3,67.9,90.2,80.8,88.4,92.3]
                 backgroundColor: 'rgba(54, 162, 235, 0.2)',
                 borderColor: 'rgba(54, 162, 235, 1)',
                 borderWidth: 1
             }],
         },
         options:{
             legend: {
                 labels: {
                     fontColor: '#dbdbdb',


                 },



             },
             scales: {
                 yAxes: [{
                     display: true,
                     ticks: {
                         fontColor: 'white'
                     }
                 }],
                 xAxes: [{
                     ticks: {
                         autoSkip: false,
                         maxRotation: 90,
                         minRotation: 90,
                         padding: 20,
                         fontColor: 'white'
                     }
                 }]
             },
             plugins: {
                 datalabels: {
                     anchor: 'center',
                     align: 'top',
                     formatter: (value, ctx) => {
                         return value + " %";
                     },
                     color: '#ffffff',

                 }
             },


         }
     });
 </script>
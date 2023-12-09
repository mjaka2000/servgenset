<?php $this->load->view('template/head'); ?>
<?php $this->load->view('admin/template/nav'); ?>
<?php $this->load->view('admin/template/sidebar'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard <small>Control Panel</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div id="loading">
            <img src="<?= base_url(); ?>assets/style/loading.gif" alt="loading" width="50%">
        </div>
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <h2 align="center">Selamat Datang, <strong><?= $this->session->userdata('name') ?></strong> sebagai Administrator!</h2>
            <div class="row">


                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php if (!empty($dataUser)) { ?>
                                <h3><?= $dataUser ?></h3>
                            <?php } else { ?>
                                <h3>0</h3>
                            <?php } ?>
                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <?php if (!empty($dataGenset)) { ?>
                                <h3><?= $dataGenset ?></h3>
                            <?php } else { ?>
                                <h3>0</h3>
                            <?php } ?>
                            <p>Genset</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <?php if (!empty($dataServGenset)) { ?>
                                <h3><?= $dataServGenset ?></h3>
                            <?php } else { ?>
                                <h3>0</h3>
                            <?php } ?>
                            <p>Perbaikan Genset</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <?php if (!empty($dataStokSparepart)) { ?>
                                <h3><?= $dataStokSparepart ?></h3>
                            <?php } else { ?>
                                <h3>0</h3>
                            <?php } ?>
                            <p>Stok Sparepart</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <?php if (is_array($count)) { ?>
                            <?php foreach ($count as $c) : ?>
                                <div class="alert alert-warning alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <a href="<?= base_url(); ?>admin/tabel_sparepart" style="text-decoration: none; color: black;"><strong> <?= $c->nama_sparepart; ?></strong><span> sisa <strong><?= $c->stok; ?></strong></span><br>
                                        <small style="color: red;">Segera lakukan pembelian untuk menambah stok</small></a>
                                    <!-- </li> -->
                                </div>
                            <?php endforeach ?>
                        <?php } ?>
                        <!-- ./col -->
                    </div>
                </div>

                <!-- <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Grafik Pendapatan <?= $label ?></h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="PendapatanChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div> -->

            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>
<?php $this->load->view('template/footer'); ?>

<?php $this->load->view('admin/template/script') ?>
<script>
    //* Script untuk menampilkan loading
    document.onreadystatechange = function() {
        if (document.readyState !== "complete") {
            document.querySelector(
                "body").style.visibility = "hidden";
            document.querySelector(
                "#loading").style.visibility = "visible";
        } else {
            document.querySelector(
                "#loading").style.display = "none";
            document.querySelector(
                "body").style.visibility = "visible";
        }
    };
</script>
<script>
    $(function() {
        //-------------
        //- LINE CHART -
        //--------------

        var ctx = document.getElementById('PendapatanChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    if (count($pendapatanChart) > 0) {
                        foreach ($pendapatanChart as $pd) {
                            echo "'" . date('d-m-Y', strtotime($pd->tanggal_masuk)) . "',";
                        }
                    }
                    ?>
                ],
                datasets: [{
                    label: 'Jumlah Pendapatan',
                    backgroundColor: '#ADD8E6',
                    borderColor: '##93C3D2',
                    data: [
                        <?php
                        if (count($pendapatanChart) > 0) {
                            foreach ($pendapatanChart as $data) {
                                echo $data->total . ", ";
                            }
                        }
                        ?>
                    ]
                }]
            },
        });

        // var ctx = document.getElementById("lineChart").getContext('2d');
        // var myChart = new Chart(ctx, {
        //   type: 'line',
        //   data: {
        //     labels: ["Pendapatan", "Bulan"],
        //     datasets: [{
        //       label: '',

        //       xAxis: {
        //         categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
        //       },
        //       yAxis: {
        //         title: {
        //           text: '(Rp)'
        //         },
        //         data: [
        //           <?php foreach ($pendapatanChart as $pd) { ?>
        //             <?= $pd->total; ?>
        //           <?php } ?>
        //         ],

        //       },
        //       borderColor: [
        //         'rgba(255,99,132,1)',
        //         'rgba(54, 162, 235, 1)'
        //       ],
        //       borderWidth: 1
        //     }]
        //   },
        //   options: {
        //     scales: {
        //       yAxes: [{
        //         ticks: {
        //           beginAtZero: true
        //         }
        //       }]
        //     }
        //   }
        // });
    })
</script>
</body>

</html>
<?php $this->load->view('template/head'); ?>
<?php $this->load->view('admin/template/nav'); ?>
<?php $this->load->view('admin/template/sidebar'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Stok Sparepart</h1>
                    <ul class="navbar-nav" style="width: 100px;">
                        <li class=" dropdown" style="width: 50px;">
                            <a href="#" data-toggle="dropdown">
                                <i class="far fa-bell"></i>
                                <?php if (empty($num)) { ?>
                                    <span></span>
                                <?php } else { ?>
                                    <span class="badge badge-warning"><?= $num; ?></span>
                                <?php } ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-lg">
                                <span class="dropdown-header" style="background-color: #2596be; color: white;">You have <?= $num; ?> notifications</span>
                                <div class="dropdown-divider"></div>
                                <!-- inner menu: contains the actual data -->

                                <?php if (is_array($count)) { ?>
                                    <?php foreach ($count as $c) : ?>
                                        <!-- <li style="background-color: ghostwhite;color: white;"> -->
                                        <a href="#" class="dropdown-item">
                                            <strong> <?= $c->nama_sparepart; ?></strong><span> sisa <strong><?= $c->stok; ?></strong></span><br>
                                            <small style="color: red;">Segera lakukan pembelian untuk menambah stok</small>
                                        </a>
                                        <!-- </li> -->
                                    <?php endforeach ?>
                                <?php } ?>


                                <div class="dropdown-divider"></div>
                                <a href="#" style="background-color: #2596be;" class="dropdown-item dropdown-footer"></a>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.col -->

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Stok Sparepart</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
        <div id="loading">
            <img src="<?= base_url(); ?>assets/style/loading.gif" alt="loading" width="50%">
        </div>
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Data Stok Sparepart
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->flashdata('msg_sukses')) { ?>
                                <div class="alert alert-success alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Berhasil!</strong><br> <?= $this->session->flashdata('msg_sukses'); ?>
                                </div>
                            <?php } ?>
                            <a href="<?= base_url('admin/tambah_data_sparepart'); ?>" style="margin-bottom:10px;" type="button" class="btn btn-sm btn-primary" name="tambah_data"><i class="fa fa-plus mr-2" aria-hidden="true"></i>Tambah Data</a>

                            <table id="mytable" class="table table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width :10px">No.</th>
                                        <th>Nama Sparepart</th>
                                        <th>Tanggal Beli</th>
                                        <th>Tempat Beli</th>
                                        <th>Stok</th>
                                        <th style="width:10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    // $list_data = isset($_POST['list_data']) ? $_POST['list_data'] : '';
                                    if (is_array($list_sparepart)) { ?>
                                        <?php foreach ($list_sparepart as $dt) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $dt->nama_sparepart; ?></td>
                                                <td><?= $dt->tanggal_beli; ?></td>
                                                <td><?= $dt->tempat_beli; ?></td>
                                                <td><?= $dt->stok; ?></td>
                                                <td><a href="<?= base_url('admin/update_sparepart/' . $dt->id_sparepart); ?>" type="button" class="btn btn-sm btn-info" name="btn_edit"><i class="fa fa-edit mr-2"></i></a>
                                                    <a href="<?= base_url('admin/hapus_sparepart/' . $dt->id_sparepart); ?>" type="button" class="btn btn-sm btn-danger btn-delete" name="btn_delete"><i class="fa fa-trash mr-2"></i></a>
                                                    <!-- <a href="<?= base_url('admin/'); ?>" type="button" class="btn btn-xs btn-warning" name="btn_detail"><i class="fa fa-info-circle mr-2"></i></a> -->
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php } else { ?>
                                        <td colspan="9" align="center"><strong>Data Kosong</strong></td>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
<script type="text/javascript">
    $('.btn-delete').on('click', function() {
        var getLink = $(this).attr('href');
        Swal.fire({
            title: 'Hapus Data',
            text: 'Yakin ingin menghapus data?',
            type: 'warning',
            confirmButtonColor: '#d9534f',
            showCancelButton: true,
        }).then(result => {
            //jika klik ya maka arahkan ke proses.php
            if (result.isConfirmed) {
                window.location.href = getLink
            }
        })
        return false;
    }); //* Script untuk memuat sweetalert hapus data
</script>
</body>

</html>
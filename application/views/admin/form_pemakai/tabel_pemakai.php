<?php $this->load->view('template/head'); ?>
<?php $this->load->view('admin/template/nav'); ?>
<?php $this->load->view('admin/template/sidebar'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Pemakai</h1>
                </div><!-- /.col -->

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Pemakai</li>
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
                            Data Pemakai
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->flashdata('msg_sukses')) { ?>
                                <div class="alert alert-success alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Berhasil!</strong><br> <?= $this->session->flashdata('msg_sukses'); ?>
                                </div>
                            <?php } ?>
                            <!-- <a href="<?= base_url('admin/tambah_data_pemakai'); ?>" style="margin-bottom:10px;" type="button" class="btn btn-sm btn-primary" name="tambah_data"><i class="fa fa-plus mr-2" aria-hidden="true"></i>Tambah Data</a> -->
                            <button data-toggle="modal" data-target="#staticAddPemakai" class="btn btn-info btn-sm"><i class="fa fa-plus mr-2" aria-hidden="true"></i>Tambah Data</button>

                            <!-- <div class="table-responsive"> -->
                            <table id="tablepakai" class="table table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width :10px">No.</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No. HP</th>
                                        <th>Tanggal Update</th>
                                        <th style="width:10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    // $list_data = isset($_POST['list_data']) ? $_POST['list_data'] : '';
                                    if (is_array($list_pemakai)) { ?>
                                        <?php foreach ($list_pemakai as $dt) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $dt->nama; ?></td>
                                                <td><?= $dt->alamat; ?></td>
                                                <td><?= $dt->no_hp; ?></td>
                                                <td><?= $dt->tgl_update; ?></td>
                                                <td>
                                                    <button type="button" data-toggle="modal" data-target="#staticEditPemakai<?= $dt->id_pemakai; ?>" class="btn btn-info btn-sm"><i class="fa fa-edit mr-2"></i></button>
                                                    <!-- <a href="<?= base_url('admin/update_data_pemakai/' . $dt->id_pemakai); ?>" type="button" class="btn btn-sm btn-info" name="btn_edit"><i class="fa fa-edit mr-2"></i></a> -->
                                                    <a href="<?= base_url('admin/hapus_pemakai/' . $dt->id_pemakai); ?>" type="button" class="btn btn-sm btn-danger btn-delete" name="btn_delete"><i class="fa fa-trash mr-2"></i></a>
                                                    <!-- <a href="<?= base_url('admin/'); ?>" type="button" class="btn btn-xs btn-warning" name="btn_detail"><i class="fa fa-info-circle mr-2"></i></a> -->
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php } else { ?>
                                        <td colspan="9" align="center"><strong>Data Kosong</strong></td>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="modal fade" id="staticAddPemakai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="staticBackdropLabel">Laporan Pendapatan Bulanan</h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= base_url('admin/proses_tambah_pemakai'); ?>" method="post" role="form">

                                        <div class="form-group">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="no_hp" class="form-label">No. HP</label>
                                            <input type="text" maxlength="13" name="no_hp" class="form-control" id="no_hp" placeholder="Masukkan No. HP" required onkeypress='return (event.charCode > 47 && event.charCode < 58)'>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat" class="form-label">Tanggal Update</label>
                                            <input type="date" name="tgl_update" class="form-control" id="tgl_update" placeholder="Tanggal Update" required>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check mr-2"></i> Submit</button>
                                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($list_pemakai as $op) : ?>
                        <div class="modal fade" id="staticEditPemakai<?= $op->id_pemakai; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="staticBackdropLabel">Laporan Pendapatan Bulanan</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= base_url('admin/proses_update_pemakai'); ?>" method="post" role="form">
                                            <div class="form-group">
                                                <input type="hidden" name="id" value="<?= $op->id_pemakai; ?>">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama" required value="<?= $op->nama; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat" required value="<?= $op->alamat; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="no_hp" class="form-label">No. HP</label>
                                                <input type="text" maxlength="13" name="no_hp" class="form-control" id="no_hp" placeholder="Masukkan No. HP" required onkeypress='return (event.charCode > 47 && event.charCode < 58)' value="<?= $op->no_hp; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat" class="form-label">Tanggal Update</label>
                                                <input type="date" name="tgl_update" class="form-control" id="tgl_update" placeholder="Tanggal Update" required value="<?= $op->tgl_update; ?>">
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-print mr-2"></i> Cetak</button>
                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
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
    $(function() {
        $('#tablepakai').DataTable({
            // 'paging': true,
            // 'lengthChange': false,
            // 'searching': faslse,
            // 'ordering': false,
            // 'info': true,
            'responsive': true,
            'autoWidth': false
        })
    }); //* Script untuk memuat datatable
</script>
<!-- <script>
    //setting datatables
    $('#tablepakai').DataTable({
        // "language": {
        //     "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        // },
        "autoWidth": false,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            //panggil method ajax list dengan ajax
            "url": '<?= base_url('admin/ajax_list_pakai'); ?>',
            "type": "POST"
        }
    });
</script> -->
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

<script type="text/javascript">
    // $('#tablepakai').on('click', '.btn-delete', function() {
    //     var getLink = $(this).attr('href');
    //     // var id = $(this).data('id_pemakai');
    //     Swal.fire({
    //         title: 'Hapus Data',
    //         text: 'Yakin ingin menghapus data?',
    //         type: 'warning',
    //         confirmButtonColor: '#d9534f',
    //         showCancelButton: true,
    //     }).then(result => {
    //         if (result.isConfirmed) {
    //             window.location.href = getLink
    //         }
    //     })
    //     return false;
    // });

    //* Script untuk memuat sweetalert hapus data
</script>
</body>

</html>
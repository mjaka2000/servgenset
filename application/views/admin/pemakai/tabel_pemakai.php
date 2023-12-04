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
                            <a href="<?= base_url('admin/tambah_data_pemakai'); ?>" style="margin-bottom:10px;" type="button" class="btn btn-sm btn-primary" name="tambah_data"><i class="fa fa-plus mr-2" aria-hidden="true"></i>Tambah Data</a>

                            <!-- <div class="table-responsive"> -->
                            <table id="tablepakai" class="table table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width :10px">No.</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No. HP</th>
                                        <th>No. KTP</th>
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
                                                <td><?= $dt->nama_pemakai; ?></td>
                                                <td><?= $dt->alamat_pemakai; ?></td>
                                                <td><?= $dt->no_hp_pemakai; ?></td>
                                                <td><?= $dt->noktp_pemakai; ?></td>
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
<?php $this->load->view('template/head'); ?>
<?php $this->load->view('admin/template/nav'); ?>
<?php $this->load->view('admin/template/sidebar'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Genset</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/tabel_genset'); ?>">Data Genset</a></li>
                        <li class="breadcrumb-item active">Edit Data Genset</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="width: 30%; margin-left: 35%;">
                        <div class="card-header">
                            Edit Data Genset
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->flashdata('msg_sukses')) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Berhasil!</strong><br> <?= $this->session->flashdata('msg_sukses'); ?>
                                </div>
                            <?php } ?>
                            <?php if (validation_errors()) { ?>
                                <div class="alert alert-warning alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Perhatian!</strong><br> <?php echo validation_errors(); ?>
                                </div>
                            <?php } ?>

                            <form action="<?= base_url('admin/proses_updategenset'); ?>" method="post" role="form" enctype="multipart/form-data">
                                <?php foreach ($data_genset as $d) { ?>

                                    <div class="form-group">
                                        <input type="hidden" name="id_genset" value="<?= $d->id_genset; ?>">
                                        <label for="kode_genset" class="form-label">Nomor Genset</label>
                                        <input type="text" name="kode_genset" class="form-control" id="kode_genset" placeholder="Kode Genset" required value="<?= $d->kode_genset; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_genset" class="form-label">Nama Genset</label>
                                        <input type="text" name="nama_genset" class="form-control" id="nama_genset" placeholder="Nama Genset" required value="<?= $d->nama_genset; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="daya" class="form-label">Daya (KVA)</label>
                                        <input type="text" name="daya" class="form-control" id="daya" placeholder="Daya" required onkeypress='return (event.charCode > 47 && event.charCode < 58)' value="<?= $d->daya; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga" class="form-label">Harga</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input type="text" name="harga" class="form-control" id="harga" placeholder="Harga" required onkeypress='return (event.charCode > 47 && event.charCode < 58)' value="<?= $d->harga; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="stok_gd" class="form-label">Unit Digudang</label>
                                        <input type="text" name="stok_gd" class="form-control" id="stok_gd" placeholder="Stok Digudang" required onkeypress='return (event.charCode > 47 && event.charCode < 58)' value="<?= $d->stok_gd; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="stok_pj" class="form-label">Unit Disewakan</label>
                                        <input type="text" name="stok_pj" class="form-control" id="stok_pj" placeholder="Stok Dipinjam" required onkeypress='return (event.charCode > 47 && event.charCode < 58)' value="<?= $d->stok_pj; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="gambar_genset" class="form-label">Gambar Genset</label>
                                        <input type="file" name="gambar_genset" class="form-control" id="gambar_genset">
                                        <input type="hidden" name="gambar_genset_old" value="<?= $d->gambar_genset; ?>">
                                    </div>

                                    <hr>
                                    <div class="form-group" align="center">
                                        <a href="<?= base_url('admin/tabel_genset'); ?>" type="button" class="btn btn-sm btn-default" name="btn_kembali"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
                                        <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-eraser mr-2"></i>Reset</button>
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check mr-2"></i>Submit</button>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>
<?php $this->load->view('template/footer'); ?>

<?php $this->load->view('admin/template/script') ?>

</body>

</html>
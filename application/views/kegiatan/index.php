<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                <?=$title?>
            </h2>
        </div>

        <div class="row clearfix">
            <!-- Form Kegiatan -->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>
                                        <?= $edit_kegiatan == null ? 'Tambah Kegiatan' : 'Edit Kegiatan' ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <form method="POST" action="<?= $edit_kegiatan == null ? base_url(). 'kegiatan/add' : base_url(). 'kegiatan/update/'.$edit_kegiatan['id'] ?>"">
                                <div class="
                                form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="email_address" class="form-control" name="nama" value="<?= $edit_kegiatan == null ? '' : $edit_kegiatan['nama'] ?>"
                                        required>
                                    <label class="form-label">Nama</label>
                                </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="password" class="form-control" name="tema" value="<?= $edit_kegiatan == null ? '' : $edit_kegiatan['tema'] ?>"
                                    required>
                                <label class="form-label">Tema</label>
                            </div>
                        </div>
                        <h2 class="card-inside-title">Pelaksanaan</h2>
                        <div class="form-group">
                            <div id="bs_datepicker_container" class="form-line focused">
                                <input type="text" class="form-control" placeholder="Tanggal Pelaksanaan" name="pelaksanaan"
                                    value="<?= $edit_kegiatan == null ? '' : date('d/m/Y', strtotime($edit_kegiatan['pelaksanaan'])) ?>"
                                    require>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary m-t-15 waves-effect" value="<?= $edit_kegiatan == null ? 'TAMBAH' : 'SUNTING' ?> "
                            name="submit" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Form Kegiatan -->
        <!-- Daftar Kegiatan -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Daftar Kegiatan
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tema</th>
                                        <th>Pelaksanaan</th>
                                        <th>Ketua Panitia</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kegiatan as $event) { ?>
                                    <tr>
                                        <td>
                                            <?= $event['nama'] ?>
                                        </td>
                                        <td>
                                            <?= $event['tema'] ?>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($event['pelaksanaan'])) ?>
                                        </td>
                                        <td></td>
                                        <td>
                                            <a href="<?= base_url().'kegiatan/edit/'.$event['id'] ?>" class="btn btn-warning waves-effect">Sunting</a>
                                            <a href="<?= base_url().'kegiatan/delete/'.$event['id'] ?>" class="btn btn-danger waves-effect">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Daftar Kegiatan -->
    </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                <?=$title?>
            </h2>
        </div>

        <!-- Select Periode -->
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Periode Kepengurusan
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <form method="POST" action="<?= base_url(). 'kegiatan/periode'?>">
                                <div class="col-sm-8">
                                    <select class="form-control show-tick" name="id_periode">
                                        <option value="">-- Pilih Periode Kepengurusan --</option>
                                        <?php foreach ($periode as $PERIODE) { ?>
                                        <option value=" <?= $PERIODE['id_periode'] ?> "
                                            <?= $id_periode != null && $id_periode == $PERIODE['id_periode'] ? 'selected' :'' ?>>
                                            <?= $PERIODE['tahun_periode'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary m-t-15 waves-effect" value="TERAPKAN"
                                        name="terapkan" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SELECT PERIODE -->

        <!-- Form Kegiatan -->
        <?php if (($id_periode != null && $id_role == 1) || $edit_kegiatan != null ) { ?>
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
                        <form method="POST"
                            action="<?= $edit_kegiatan == null ? base_url(). 'kegiatan/add' : base_url(). 'kegiatan/update/'.$edit_kegiatan['id_kegiatan'] ?>">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">Periode</h2>
                                    <select class="form-control show-tick" name="id_periode">
                                        <?php foreach ($periode as $PERIODE) { ?>
                                        <?php if ($id_periode != null && $id_periode == $PERIODE['id_periode']) { ?>
                                        <option value=" <?= $PERIODE['id_periode'] ?> "
                                            <?= $id_periode != null && $id_periode == $PERIODE['id_periode'] ? 'selected' :'' ?>>
                                            <?= $PERIODE['tahun_periode'] ?>
                                        </option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="email_address" class="form-control" name="nama_kegiatan"
                                        value="<?= $edit_kegiatan == null ? '' : $edit_kegiatan['nama_kegiatan'] ?>"
                                        required>
                                    <label class="form-label">Nama</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="password" class="form-control" name="tema_kegiatan"
                                        value="<?= $edit_kegiatan == null ? '' : $edit_kegiatan['tema_kegiatan'] ?>"
                                        required>
                                    <label class="form-label">Tema</label>
                                </div>
                            </div>
                            <h2 class="card-inside-title">Pelaksanaan</h2>
                            <div class="form-group">
                                <div id="bs_datepicker_container" class="form-line focused">
                                    <input type="text" class="form-control" placeholder="Tanggal Pelaksanaan"
                                        name="pelaksanaan_kegiatan"
                                        value="<?= $edit_kegiatan == null ? '' : date('d/m/Y', strtotime($edit_kegiatan['pelaksanaan_kegiatan'])) ?>"
                                        require>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary m-t-15 waves-effect"
                                value="<?= $edit_kegiatan == null ? 'TAMBAH' : 'SUNTING' ?> " name="submit" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php }  ?>

        <!-- #END# Form Kegiatan -->
        <!-- Daftar Kegiatan -->
        <div class="row clearfix">
            <?php if ($id_periode != null) { ?>
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
                                        <!-- <th>Ketua Panitia</th> -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kegiatan as $event) { ?>
                                    <tr>
                                        <td>
                                            <?= $event['nama_kegiatan'] ?>
                                        </td>
                                        <td>
                                            <?= $event['tema_kegiatan'] ?>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($event['pelaksanaan_kegiatan'])) ?>
                                        </td>
                                        <!-- <td></td> -->
                                        <td>
                                            <a href="<?= base_url().'kegiatan/edit/'.$event['id_kegiatan'] ?>"
                                                class="btn btn-warning waves-effect"
                                                <?= $event['id_sie'] != 1 && $id_role != 1 ? 'hidden' : '' ?>>Sunting</a>
                                            <a href="<?= base_url().'kegiatan/delete/'.$event['id_kegiatan'] ?>"
                                                class="btn btn-danger waves-effect"
                                                <?= $id_role != 1 ? 'hidden' : '' ?>>Hapus</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php }  ?>
        </div>
        <!-- #END# Daftar Kegiatan -->
    </div>
    </div>
</section>
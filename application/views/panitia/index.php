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
                            <form method="POST" action="<?= base_url(). 'panitia/periode'?>">
                                <div class="col-sm-8">
                                    <select class="form-control show-tick" name="id_periode">
                                        <option value="">-- Pilih Periode Kepengurusan --</option>
                                        <?php foreach ($data_periode as $PERIODE) { ?>
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
            <?php if ($data_kegiatan != null) { ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Kegiatan
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <form method="POST" action="<?= base_url(). 'panitia/kegiatan'?>">
                                <div class="col-sm-8">
                                    <select class="form-control show-tick" name="id_kegiatan">
                                        <option value="">-- Pilih Kegiatan --</option>
                                        <?php foreach ($data_kegiatan as $KEGIATAN) { ?>
                                        <option value=" <?= $KEGIATAN['id_kegiatan'] ?> "
                                            <?= $id_kegiatan != null && $id_kegiatan == $KEGIATAN['id_kegiatan'] ? 'selected' :'' ?>>
                                            <?= $KEGIATAN['nama_kegiatan'] ?>
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
            <?php } ?>
        </div>
        <!-- END SELECT PERIODE -->

        <!-- Form Panitia -->
        <?php if (($id_periode != null && $id_kegiatan != null && ($id_role == 1 || $id_role == 3)) || $edit_panitia != null ) { ?>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-6">
                                <h2>
                                    <?= $edit_panitia == null ? 'Tambah Panitia' : 'Edit Panitia' ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <form method="POST"
                            action="<?= $edit_panitia == null ? base_url(). 'panitia/add' : base_url(). 'panitia/update/'.$edit_panitia['id_panitia'] ?>">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">Periode</h2>
                                    <select class="form-control show-tick" name="id_periode">
                                        <?php foreach ($data_periode as $PERIODE) { ?>
                                        <?php if ($id_periode != null && $id_periode == $PERIODE['id_periode']) { ?>
                                        <option value=" <?= $PERIODE['id_periode'] ?> "
                                            <?= $id_periode != null && $id_periode == $PERIODE['id_periode'] ? 'selected' :'' ?>>
                                            <?= $PERIODE['tahun_periode'] ?>
                                        </option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            

                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">Kegiatan</h2>
                                    <select class="form-control show-tick" name="id_kegiatan">
                                        <?php foreach ($data_kegiatan as $KEGIATAN) { ?>
                                        <?php if ($id_kegiatan != null && $id_kegiatan == $KEGIATAN['id_kegiatan']) { ?>
                                        <option value=" <?= $KEGIATAN['id_kegiatan'] ?> "
                                            <?= $id_kegiatan != null && $id_kegiatan == $KEGIATAN['id_kegiatan'] ? 'selected' :'' ?>>
                                            <?= $KEGIATAN['nama_kegiatan'] ?>
                                        </option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            
                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">Member dan Pengurus</h2>
                                    <select class="form-control show-tick" name="id_member">
                                        <option value="">-- Pilih Member atau Pengurus --</option>
                                        <?php foreach ($data_calon_panitia as $CALON) { ?>
                                        <option value=" <?= $CALON['id_member'] ?> "
                                            <?= $id_member != null && $id_member == $CALON['id_member'] ? 'selected' :'' ?>>
                                            <?= $CALON['nama_member'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">Sie</h2>
                                    <select class="form-control show-tick" name="id_sie">
                                        <option value="">-- Pilih Sie --</option>
                                        <?php foreach ($data_sie as $SIE) { ?>
                                        <option value=" <?= $SIE['id_sie'] ?> "
                                            <?= $id_sie != null && $id_sie == $SIE['id_sie'] ? 'selected' :'' ?>>
                                            <?= $SIE['nama_sie'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">Jabatan</h2>
                                    <input name="jabatan_panitia" type="radio" id="radio_1" value="0" <?= $edit_panitia['jabatan_panitia'] == 0 ? 'checked' : ''?>/>
                                    <label for="radio_1">Koordinator</label>
                                    <input name="jabatan_panitia" type="radio" id="radio_2" value="1" <?= $edit_panitia['jabatan_panitia'] == 1 ? 'checked' : ''?>/>
                                    <label for="radio_2">Anggota</label>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary m-t-15 waves-effect"
                                value="<?= $edit_panitia == null ? 'TAMBAH' : 'SUNTING' ?> " name="submit" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php }  ?>
        <!-- #END# Form Panitia -->

        <!-- Daftar Panitia -->
        <div class="row clearfix">
            <?php if ($id_periode != null && $data_panitia != null) { ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Daftar Panitia Kegiatan <?= $data_panitia[0]['nama_kegiatan'] ?>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Sie</th>
                                        <th>Jabatan</th>
                                        <th>Nama</th>
                                        <!-- <th>Ketua Panitia</th> -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_panitia as $PANITIA) { ?>
                                    <tr>
                                        <td>
                                            <?= $PANITIA['nama_sie'] ?>
                                        </td>
                                        <td>
                                            <?= $PANITIA['jabatan_panitia'] == 0 ? 'Koordinator' : 'Anggota' ?>
                                        </td>
                                        <td>
                                            <?= $PANITIA['nama_member'] ?>
                                        </td>
                                        <!-- <td></td> -->
                                        <td>
                                            <a href="<?= base_url().'panitia/edit/'.$PANITIA['id_panitia'] ?>"
                                                class="btn btn-warning waves-effect"
                                                <?= $id_role == 1 || $id_role == 3 ? '' : 'hidden' ?>>Sunting</a>
                                            <a href="<?= base_url().'panitia/delete/'.$PANITIA['id_panitia'] ?>"
                                                class="btn btn-danger waves-effect"
                                                <?= $id_role == 1 || $id_role == 3 ? '' : 'hidden' ?>>Hapus</a>
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
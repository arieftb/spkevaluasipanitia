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
                            <form method="POST" action="<?=base_url() . 'kriteria/periode'?>">
                                <div class="col-sm-8">
                                    <select class="form-control show-tick" name="id_periode">
                                        <option value="">-- Pilih Periode Kepengurusan --</option>
                                        <?php foreach ($data_periode as $PERIODE) {?>
                                        <option value=" <?=$PERIODE['id_periode']?> "
                                            <?=$id_periode != null && $id_periode == $PERIODE['id_periode'] ? 'selected' : ''?>>
                                            <?=$PERIODE['tahun_periode']?>
                                        </option>
                                        <?php }?>
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

            <!-- Form Tambah Kriteria Baru -->
            <?php if ($id_role == 1) {?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-12">
                                <h2>
                                    <?=$edit_kriteria == null ? 'Tambah Kriteria Baru' : 'Edit Kriteria ' . $edit_kriteria['nama_kriteria']?>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <form method="POST"
                            action="<?=$edit_kriteria == null ? base_url() . 'kriteria/add' : base_url() . 'kriteria/update/' . $edit_kriteria['id_kriteria']?>">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="name_kriteria" class="form-control" name="name_kriteria"
                                        value="<?=$edit_kriteria == null ? '' : $edit_kriteria['nama_kriteria']?>"
                                        required>
                                    <label class="form-label">Nama Kriteria</label>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary m-t-15 waves-effect"
                                value="<?=$edit_kriteria == null ? 'TAMBAH' : 'SUNTING'?> " name="submit" />
                        </form>
                    </div>
                </div>
            </div>
            <?php }?>
            <!-- Form Tambah Kriteria Baru -->
        </div>

        <!-- Form Sisipkan Kriteria -->
        <?php if ($id_role == 1) {?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-6">
                                <h2>
                                    Sisipkan Kriteria Pada Periode Ini
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <form method="POST" action="<?=base_url() . 'kriteria/insert/' . $id_periode?>">
                            <input type="hidden" id="id_periode" class="form-control" name="id_periode"
                                value="<?=$id_periode?>" required />
                            <div class="demo-checkbox">
                                <?php $i = 1;?>
                                <?php foreach ($data_kriteria as $KRITERIA) {?>
                                <input type="checkbox" id="md_checkbox_2<?=$i?>" class="filled-in chk-col-blue"
                                    name="kriteria[]" value="<?=$KRITERIA['id_kriteria']?>" />
                                <label for="md_checkbox_2<?=$i?>"><?=$KRITERIA['nama_kriteria']?></label>
                                <a href="<?=base_url() . 'kriteria/edit/' . $KRITERIA['id_kriteria'] . '/' . $id_periode?>"
                                    class="btn btn-info waves-effect"><i class="material-icons">edit</i>
                                </a>
                                <?php $i++;?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php }?>
                            </div>
                            <input type="submit" class="btn btn-primary m-t-15 waves-effect" value="Sisipkan"
                                name="submit" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <!-- Form Sisipkan Kriteria -->
    </div>
</section>
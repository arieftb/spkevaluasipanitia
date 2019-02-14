<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?=$title?></h2>
        </div>

        <!-- Top Form -->
        <div class="row clearfix">
            <!-- Pemilihan Periode -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Periode Kepengurusan
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <form method="POST" action="<?=base_url() . 'penilaian/periode'?>">
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
            <!-- Pemilihan Periode -->
            <!-- Pemilihan Kegiatan -->
            <?php if ($data_kegiatan != null) {?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Kegiatan
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <form method="POST" action="<?=base_url() . 'penilaian/kegiatan'?>">
                                <div class="col-sm-8">
                                    <select class="form-control show-tick" name="id_kegiatan">
                                        <option value="">-- Pilih Kegiatan --</option>
                                        <?php foreach ($data_kegiatan as $KEGIATAN) {?>
                                        <option value=" <?=$KEGIATAN['id_kegiatan']?> "
                                            <?=$id_kegiatan != null && $id_kegiatan == $KEGIATAN['id_kegiatan'] ? 'selected' : ''?>>
                                            <?=$KEGIATAN['nama_kegiatan']?>
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
            <?php }?>
            <!-- Pemilihan Kegiatan -->
        </div>
        <!-- Top Form -->

        <!-- Form Penilaian Panitia Perkriteria -->
        <?php if ($id_role != null && $id_role == 4 && $data_panitia != null && $data_kriteria != null && $data_nilai == null) {?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Nilai Panitia
                        </h2>
                        <h6>
                            (0-100)
                        </h6>
                    </div>
                    <div class="body">
                        <!-- <div class="row clearfix"> -->
                        <form method="POST" action="<?=base_url() . 'penilaian/nilai'?>">
                            <input type='hidden' name='id_periode' value='<?=$id_periode?>' id="id_panitia"
                                class="form-control" required></input>
                            <input type='hidden' name='id_kegiatan' value='<?=$id_kegiatan?>' id="id_kegiatan"
                                class="form-control" required></input>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <?php for ($i = 0; $i < sizeof($data_panitia) + 1; $i++) {?>
                                            <th>
                                                <?php if ($i != 0) {?>
                                                <input type='hidden' name='id_panitia[]'
                                                    value='<?=$data_panitia[$i - 1]['id_panitia']?>' id="id_panitia"
                                                    class="form-control" required></input>
                                                <?php }?>
                                                <?=$i == 0 ? '' : $data_panitia[$i - 1]['nama_member']?>
                                            </th>
                                            <?php }?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data_kriteria as $KRITERIA) {?>
                                        <tr>
                                            <td>
                                                <input type='hidden' name='id_kriteria[]'
                                                    value='<?=$KRITERIA['id_kriteria']?>' id="id_kriteria"
                                                    class="form-control" required></input>
                                                <?=$KRITERIA['nama_kriteria']?>
                                            </td>
                                            <?php for ($i = 0; $i < sizeof($data_panitia); $i++) {?>
                                            <td>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="number" id="nilai_kriteria" class="form-control"
                                                            name="nilai_kriteria[]" required>
                                                    </div>
                                                </div>
                                            </td>
                                            <?php }?>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary m-t-15 waves-effect" value="TERAPKAN"
                                        name="terapkan" />
                                </div>
                        </form>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <!-- Form Penilaian Panitia Perkriteria -->

        <!-- Table Penilaian Panitia Per Sie Per Kriteria -->
        <?php if ($id_role != null && $id_role == 5 && $data_panitia != null && $data_kriteria != null && $data_nilai != null && !empty($data_nilai)) {?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Nilai Panitia
                        </h2>
                        <h6>
                            (0-100)
                        </h6>
                    </div>
                    <div class="body">
                        <!-- <div class="row clearfix"> -->
                        <form method="POST" action="<?=base_url() . 'penilaian/update'?>">
                            <input type='hidden' name='id_periode' value='<?=$id_periode?>' id="id_panitia"
                                class="form-control" required></input>
                            <input type='hidden' name='id_kegiatan' value='<?=$id_kegiatan?>' id="id_kegiatan"
                                class="form-control" required></input>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <?php for ($i = 0; $i < sizeof($data_panitia) + 1; $i++) {?>
                                            <th>
                                                <?php if ($i != 0) {?>
                                                <input type='hidden' name='id_panitia[]'
                                                    value='<?=$data_panitia[$i - 1]['id_panitia']?>' id="id_panitia"
                                                    class="form-control" required></input>
                                                <?php }?>
                                                <?=$i == 0 ? '' : $data_panitia[$i - 1]['nama_member']?>
                                            </th>
                                            <?php }?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data_kriteria as $KRITERIA) {?>
                                        <tr>
                                            <td>
                                                <input type='hidden' name='id_kriteria[]'
                                                    value='<?=$KRITERIA['id_kriteria']?>' id="id_kriteria"
                                                    class="form-control" required></input>
                                                <?=$KRITERIA['nama_kriteria']?>
                                            </td>
                                            <?php foreach ($data_nilai as $NILAI) {?>
                                            <?php if ($NILAI['id_kriteria'] == $KRITERIA['id_kriteria']) {?>
                                            <td>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="number" id="nilai_kriteria" class="form-control"
                                                            name="nilai_kriteria[]"
                                                            value="<?=$NILAI['nilai_penilaian']?>" required>
                                                    </div>
                                                </div>
                                            </td>
                                            <?php }?>
                                            <?php }?>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary m-t-15 waves-effect" value="PERBAHARUI"
                                        name="update" />
                                </div>
                            </div>
                        </form>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <!-- Table Penilaian Panitia Per Sie Per Kriteria -->

        <!-- Table Penilaian Semua Panitia Per Kriteria -->
        <?php if ($id_role != 4 && $data_nilai_table != null && !empty($data_nilai_table)) {?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Nilai Panitia
                        </h2>
                        <h6>
                            (0-100)
                        </h6>
                    </div>
                    <div class="body">
                        <!-- <div class="row clearfix"> -->
                        <form method="POST" action="<?=base_url() . 'penilaian/process'?>">
                            <input type='hidden' name='id_kegiatan' value='<?=$id_kegiatan?>' id="id_kegiatan"
                                class="form-control" required></input>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <?php for ($i = 0; $i < sizeof($data_nilai_table[0]); $i++) {?>
                                            <th><?=$data_nilai_table[0][$i]?></th>
                                            <?php }?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 1; $i < sizeof($data_nilai_table); $i++) {?>
                                        <tr>
                                            <?php for ($j = 0; $j < sizeof($data_nilai_table[$i]); $j++) {?>
                                            <td><?=$data_nilai_table[$i][$j]?></td>
                                            <?php }?>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary m-t-15 waves-effect" value="PROSES"
                                        name="process" />
                                </div>
                            </div>
                        </form>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <!-- Table Penilaian Semua Panitia Per Kriteria -->

        <!-- Table Penilaian Semua Panitia Per Kriteria Berpasangan-->
        <?php if ($id_role == 3 && $data_nilai_perkriteria != null && !empty($data_nilai_perkriteria)) {?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Proses Perhitungan
                        </h2>
                    </div>
                    <div class="body">
                        <!-- <div class="row clearfix"> -->
                        <?php for ($i = 0; $i < sizeof($data_nilai_perkriteria); $i++) {?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <?php for ($j = 0; $j < sizeof($data_nilai_perkriteria[$i][0]); $j++) {?>
                                        <th><?=$data_nilai_perkriteria[$i][0][$j]?></th>
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($j = 1; $j < sizeof($data_nilai_perkriteria[$i]); $j++) {?>
                                    <tr>
                                        <?php for ($l = 0; $l < sizeof($data_nilai_perkriteria[$i][$j]); $l++) {?>
                                        <td><?=$data_nilai_perkriteria[$i][$j][$l]?></td>
                                        <?php }?>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <?php for ($j = 0; $j < sizeof($data_nilai_normalisasi[$i][0]); $j++) {?>
                                        <th><?=$data_nilai_normalisasi[$i][0][$j]?></th>
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($j = 1; $j < sizeof($data_nilai_normalisasi[$i]); $j++) {?>
                                    <tr>
                                        <?php for ($l = 0; $l < sizeof($data_nilai_normalisasi[$i][$j]); $l++) {?>
                                        <td><?=$data_nilai_normalisasi[$i][$j][$l]?></td>
                                        <?php }?>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>

                        <?php }?>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <!-- Table Penilaian Semua Panitia Per Kriteria Berpasangan-->
    </div>
</section>
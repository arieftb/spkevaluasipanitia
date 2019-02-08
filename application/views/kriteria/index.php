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
                                    <?= $data_kriteria_detail == null || empty($data_kriteria_detail) ? 'Sisipkan Kriteria Pada Periode Ini ' : 'Kriteria Yang Di Sisipkan Pada Periode Ini' ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php if($data_kriteria_detail != null && !empty($data_kriteria_detail)) { ?>
                                    <a href="<?=base_url() . 'kriteria/reset/'.$id_periode ?>"
                                        class="btn btn-danger waves-effect">Reset
                                    </a>
                                    <?php } ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <form method="POST"
                            action="<?= $data_kriteria_detail == null || empty($data_kriteria_detail) ? base_url() . 'kriteria/insert/' . $id_periode : base_url() . 'kriteria/process/' . $id_periode ?>">
                            <input type="hidden" id="id_periode" class="form-control" name="id_periode"
                                value="<?=$id_periode?>" required />
                            <div class="demo-checkbox">
                                <?php $i = 0;?>
                                <?php foreach ($data_kriteria as $KRITERIA) {?>
                                <?php if ($data_kriteria_detail != null && !empty($data_kriteria_detail) && isset($data_kriteria_detail[$i])) { ?>
                                <input type="hidden" id="id_kriteria" class="form-control" name="id_kriteria[]"
                                    value="<?=$data_kriteria_detail[$i]['id_kriteria']?>" required />
                                <?php } ?>

                                <input type="checkbox" id="md_checkbox_2<?=$i?>" class="filled-in chk-col-blue"
                                    name="kriteria[]" value="<?=$KRITERIA['id_kriteria']?>"
                                    <?= $data_kriteria_detail == null || empty($data_kriteria_detail) ? '' : 'disabled' ?>
                                    <?= $data_kriteria_detail != null && !empty($data_kriteria_detail) && isset($data_kriteria_detail[$i]) ? $KRITERIA['id_kriteria'] == $data_kriteria_detail[$i]['id_kriteria'] ?  'checked': '' : '' ?> />
                                <label for="md_checkbox_2<?=$i?>"><?=$KRITERIA['nama_kriteria']?></label>
                                <a href="<?=base_url() . 'kriteria/edit/' . $KRITERIA['id_kriteria'] . '/' . $id_periode?>"
                                    class="btn btn-info waves-effect"
                                    <?= $data_kriteria_detail == null || empty($data_kriteria_detail) ? '' : 'hidden' ?>><i
                                        class="material-icons">edit</i>
                                </a>
                                <?php $i++;?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php }?>
                            </div>

                            <input type="submit" class="btn btn-primary m-t-15 waves-effect"
                                value="<?= $data_kriteria_detail == null || empty($data_kriteria_detail) ? 'Sisipkan' : 'Process' ?>"
                                name="submit" />

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <!-- Form Sisipkan Kriteria -->

        <!-- Form Input Nilai Perbandingan -->
        <?php if ($id_role == 1 && $data_pasangan != null) { ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Perbandingan
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            Keterangan Nilai Perbandingan
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nilai</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            1
                                        </td>
                                        <td>
                                            Sama Dengan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            2
                                        </td>
                                        <td>
                                            Mendekati sedikit lebih penting dari
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            3
                                        </td>
                                        <td>
                                            Sedikit lebih penting dari
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            4
                                        </td>
                                        <td>
                                            Mendekati lebih penting dari
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            5
                                        </td>
                                        <td>
                                            Lebih penting dari
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            6
                                        </td>
                                        <td>
                                            Mendekati sama penting dari
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            7
                                        </td>
                                        <td>
                                            Sangat penting dari
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            8
                                        </td>
                                        <td>
                                            Mendekati mutlak dari
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            9
                                        </td>
                                        <td>
                                            Mutlak sangat penting dari
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <br /><br />
                        <div class="table-responsive">
                            Nilai Perbandingan
                            <form method="post" action="<?= base_url() . 'kriteria/compare/'.$id_periode ?>">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="12%">Kriteria</th>
                                            <th width="70%">Nilai</th>
                                            <th width="13%">Kriteria</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $k = 0 ?>
                                        <?php foreach ($data_pasangan as $PASANGAN) { ?>
                                        <input type="hidden" id="<?= $PASANGAN['id_kriteria_pasangan'] ?>"
                                            class="form-control" name="id_kriteria_pasangan[]"
                                            value="<?= $PASANGAN['id_kriteria_pasangan'] ?>" required />
                                        <tr>
                                            <td>
                                                <?= $PASANGAN['nama_kriteria_1'] ?>
                                            </td>
                                            <td>
                                                <?php for ($i=-9; $i < 10; $i++) { 
                                                    if ($i != 0 && $i != -1) { ?>
                                                <input name="nilai_pasang<?= $k ?>" type="radio"
                                                    id="radio_<?= $k ?><?= $i ?>" value="<?= $i ?>" required
                                                    <?= $i < 1 ? $PASANGAN['nilai_pasangan_1'] == abs($i) ? 'checked' : '' : ''?>
                                                    <?= $i > 1 ? $PASANGAN['nilai_pasangan_2'] == abs($i) ? 'checked' : '' : ''?>
                                                    <?= $i == 1 ? $PASANGAN['nilai_pasangan_2'] == abs($i) ? 'checked' : '' : ''?> />
                                                <label for="radio_<?= $k ?><?= $i ?>"><?= abs($i) ?></label>
                                                <?php }
                                                } ?>
                                            </td>
                                            <td>
                                                <?= $PASANGAN['nama_kriteria_2'] ?>
                                            </td>
                                        </tr>
                                        <?php  $k++ ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if (!empty($data_pasangan)) { ?>
                                <?php if ($data_pasangan[0]['nilai_pasangan_1'] == 0 || $data_pasangan[0]['nilai_pasangan_2'] == 0 ) { ?>
                                <input type="submit" class="btn btn-primary m-t-15 waves-effect" value="Bandingkan"
                                    name="Compare" />
                                <?php } ?>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- Form Input Nilai Perbandingan -->

        <!-- Table Matrix Nilai Perbandingan -->
        <?php if ($data_matrix_perbandingan != null && !empty($data_pasangan)) { ?>
        <div class='row clearfix'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Matrix Nilai Perbandingan
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <?php for ($i=0; $i < sizeof($data_matrix_perbandingan[0]) ; $i++) {  ?>
                                        <th><?= $data_matrix_perbandingan[0][$i] ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i=1; $i < sizeof($data_matrix_perbandingan) ; $i++) { ?>
                                    <tr>
                                        <?php for ($j=0; $j < sizeof($data_matrix_perbandingan[$i]); $j++) { ?>
                                        <td><?= $data_matrix_perbandingan[$i][$j] ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- Table Matrix Nilai Perbandingan -->

        <!-- Table Matrix Normalisasi -->
        <?php if ($data_matrix_normalisasi != null && !empty($data_pasangan)) { ?>
        <div class='row clearfix'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Normalisasi
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <?php for ($i=0; $i < sizeof($data_matrix_normalisasi[0]) ; $i++) {  ?>
                                        <th><?= $data_matrix_normalisasi[0][$i] ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i=1; $i < sizeof($data_matrix_normalisasi) ; $i++) { ?>
                                    <tr>
                                        <?php for ($j=0; $j < sizeof($data_matrix_normalisasi[$i]); $j++) { ?>
                                        <td><?= $data_matrix_normalisasi[$i][$j] ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- Table Matrix Normalisasi -->

        <!-- Table Consistency Test -->
        <?php if ($data_consistency_test != null && !empty($data_pasangan)) { ?>
        <div class='row clearfix'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Uji Konsistensi Kriteria
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <tbody>
                                    <?php for ($i=0; $i < sizeof($data_consistency_test); $i++) { ?>
                                    <tr>
                                        <th><?= $data_consistency_test[$i][0] ?></th>
                                        <td><?= $data_consistency_test[$i][1] ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- Table Matrix Normalisasi -->
    </div>
</section>
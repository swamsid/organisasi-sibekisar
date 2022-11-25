<?php
/**
 * Created by PhpStorm.
 * User: tusti
 * Date: 9/28/2018
 * Time: 3:35 PM
 */
?>
<div class="col-md-12">
    <form id="formindikator" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <h6 class="card-subtitle">Silakan lengkapi informasi aspek indikator dibawah ini.</h6>
                <br>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Spirit</label>
                    <div class="controls">
                        <input type="hidden" name="tag" id="tag" value="<?php echo isset($tag)?$tag:'opd'; ?>">
                        <select class="form-control" name="id_aspek" id="id_aspek">
                            <?php
                            if(isset($tag) && $tag=='kab') {
                                $kategori = array(
                                    'K01' => 'Cepat',
                                    'K02' => 'Efektif & Efisien',
                                    'K03' => 'Tanggap',
                                    'K04' => 'Transparan',
                                    'K05' => 'Akuntabel',
                                    'K06' => 'Responsive'
                                );
                            }else{
                                $kategori = array(
                                    'C01' => 'Cepat',
                                    'C02' => 'Efektif & Efisien',
                                    'C03' => 'Tanggap',
                                    'C04' => 'Transparan',
                                    'C05' => 'Akuntabel',
                                    'C06' => 'Responsive'
                                );
                            }
                            foreach ($kategori as $key => $value){
                                $selected = '';
                                echo '<option value="'.$key.'" '. $selected.' >'. $value.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Bobot Spirit<small><em>Note: Isikan bobot spirit</em></small></label>
                    <div class="controls">
                        <input type="number" class="form-control" id="nilai_maks" name="nilai_maks" required>
                    </div>
                </div>
                <div class="form-group" >
                    <label>PD Pengampu</label>
                    <div class="controls">
                        <input type="hidden" name="opd_pengampu" id="opd_pengampu">
                        <select name="id_opd"  id="id_opd" class="form-control select2"  style="width:100%">
                            <option value="">- Pilih PD Pengampu -</option>
                            <?php
                            if(isset($unit)) {
                                foreach ($unit as $key) {
                                    echo '<option value="' . $key->id_unit . '">' . $key->unit . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group hide" style="display:none">
                    <label>Periode</label>
                    <div class="controls">
                        <select class="form-control" name="periode" id="periode">
                            <?php
                            $periode = array(
                                'tahunan' => 'Tahunan',
                                'triwulan' => 'Triwulan'
                            );
                            foreach ($periode as $key => $value){
                                $selected = '';
                                echo '<option value="'.$key.'" '. $selected.' >'. $value.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama <small><em>Note: Isikan nama indikator</em></small></label>
                    <div class="controls">
                        <input type="hidden" name="id_indikator" id="id_indikator">
                        <input type="text" class="form-control" id="indikator" name="indikator" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Bobot <small><em>Note: Isikan bobot indikator</em></small></label>
                    <div class="controls">
                        <input type="number" class="form-control" id="bobot" name="bobot" required>
                    </div>
                </div>

                <div class="form-group">

                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_aktif" id="is_aktif" value="1">
                            <label class="custom-control-label" for="is_aktif">Aktif?</label>
                        </div>

                    </div>

                </div>

                <div class="pull-right">
                    <a href="<?php echo base_url('module/master/indikator') ?>" class="btn btn-white btn-cons btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-cons btn-biodata">Simpan</button>
                </div>

            </div>

        </div>
    </form>
</div>
<div id="tmp-indikator" style="display: none"></div>

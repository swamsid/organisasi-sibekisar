<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Penilaian </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Penilaian <?php echo (isset($label)?$label:'') ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
    </div>
    <div class="card" id="divDataEvaluasi">
        <div class="card-body" >
            <h4 class="card-title">Penilaian <?php echo (isset($label)?$label:'') ?></h4>
            <input type="hidden" id="tmp-indikator" value="<?php echo (isset($id_indikator)?$id_indikator:'') ?>">
            <input type="hidden" id="tag" value="<?php echo (isset($tag)?$tag:'opd') ?>">
            <div class="row">
                <div class="col-12">
                    <blockquote class="blockquote blockquote-primary">
                        <form id="frmsearch" class="forms-sample form-horizontal">
                            <div class="form-group"><label>Filter pencarian</label></div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>Tahun</label>
                                    <select name="tahun" class="form-control">
                                        <?php
                                        $year = date('Y');
                                        $min = $year - 10;
                                        $max = $year;
                                        for( $i=$max; $i>=$min; $i-- ){
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php
                                if(isset($indikator)) {
                                    $aspek = array();
                                    foreach ($indikator as $key):
                                        $temp = array(
                                            "id_aspek" => $key->id_aspek,
                                            "aspek" => $key->aspek,
                                            'icon' => $key->icon
                                        );
                                        if (!in_array($temp, $aspek)) array_push($aspek, $temp);
                                    endforeach;
                                }

                                ?>


                            </div>
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <label class="col-md-12">Indikator</label>
                                    <div class="col-md-12">
                                    <select name="id_indikator" id="id_indikator_cmb" class="form-control select2"  width="100%">
                                        <option value="">- Semua Indikator -</option>
                                        <?php
                                        if(isset($indikator)) {
                                            foreach ($indikator as $key) {
                                                if($key->is_aktif==1) echo '<option value="' . $key->id_indikator . '#'.$key->nilai_maks.'#'.number_format($key->bobot / 100, 2).'">' .  $key->indikator  . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    if($_SESSION['user']->id_role==1 or ($_SESSION['user']->id_role==2 && $_SESSION['user']->id_unit==6))
                                    {
                                        echo '<br><button type="button" id="sync-serapan" class="btn btn-danger">Sinkronisasi Serapan Anggaran</button>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </blockquote>
                    <div class="row" id="divFormEvaluasi">
                        <div class="col-md-12 example-wrap">

                            <blockquote class="blockquote blockquote-primary">
                                <h4>Form Penilaian</h4>
                                <form id="formEvaluasi" enctype="multipart/form-data" method="post" class="forms-sample form-horizontal">
                                    <input type="hidden" name="id_indikator">
                                    <input type="hidden" name="tahun" id="tahun">
                                    <input type="hidden" name="id_role" id="id_role" value="<?php echo $_SESSION['user']->id_role ?>">
                                    <input type="hidden" name="id_opd" id="id_opd" value="<?php  echo $_SESSION['user']->id_unit ?>">

                                    <div class="form-group row">
                                        <div class="col" style="display: none">
                                            <label>Bulan <small>*mulai</small></label>
                                            <div class="col-md-12">
                                                <select name="bulan_mulai" class="form-control select2" id="bulan_mulai">
                                                    <?php
                                                    $namaBulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

                                                    $noBulan = 1;
                                                    for($index=0; $index<12; $index++){
                                                        echo '<option value="'.$noBulan.'">'.$namaBulan[$index].'</option>';
                                                        $noBulan++;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col" style="display:none">
                                            <label>Bulan <small>*selesai</small></label>
                                            <div class="col-md-12">
                                                <select name="bulan_selesai" class="form-control select2" id="bulan_selesai">
                                                    <?php
                                                    $namaBulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

                                                    $noBulan = 1;
                                                    for($index=0; $index<12; $index++){
                                                        echo '<option value="'.$noBulan.'">'.$namaBulan[$index].'</option>';
                                                        $noBulan++;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group div-data">
                                        <table class="table table-hover table-responsive table-striped" width="100%">
                                            <tr>
                                                <th width="10%">Perangkat daerah</th>
                                                <th>Nilai Awal</th>
                                                <th width="15%">Nilai Konversi</th>
                                            </tr>
                                            <?php
                                            $enable=false;
                                            foreach($unit as $key){
                                               /* if(!empty($_SESSION['user']->id_unit)) {
                                                    if (($key->id_opd == $_SESSION['user']->id_unit) && $_SESSION['user']->id_role != 1 && !empty($_SESSION['user']->id_unit)) $enable = true;
                                                    else $enable = false;
                                                }else $enable = true;*/
                                                 ?>
                                                <tr>
                                                    <td class="text-bold text-black"><b><?php echo strtoupper($key->unit);?></b>
                                                        <input type="hidden" name="id_unit[]"
                                                               id="<?php echo $key->id_unit ?>"
                                                               value="<?php echo $key->id_unit ?>">
                                                        <input type="hidden"
                                                               name="periode<?php echo $key->id_unit ?>" class="periode"
                                                               id="periode<?php echo $key->id_unit ?>"
                                                               value="<?php //echo $key->periode ?>">
                                                        <input type="hidden" class="bobot"
                                                               name="bobot<?php echo $key->id_unit ?>"
                                                               id="bobot<?php echo $key->id_unit ?>"
                                                               value="<?php //echo number_format($key->bobot / 100, 2) ?>">
                                                        <input type="hidden"
                                                               name="nilai_maks<?php echo $key->id_unit ?>" class="nilai_maks"
                                                               id="nilai_maks<?php echo $key->id_unit ?>"
                                                               value="<?php //echo $key->nilai_maks ?>">
                                                        <input type="hidden"
                                                               name="is_verify<?php echo $key->id_unit ?>"
                                                               id="is_verify<?php echo $key->id_unit ?>"
                                                               value="<?php //echo $key->is_verify ?>">
                                                        <input type="hidden"
                                                               name="user_verifikasi<?php echo $key->id_unit ?>"
                                                               id="user_verifikasi<?php echo $key->id_unit ?>"
                                                               value="<?php //echo $key->user_verifikasi ?>">
                                                        <input type="hidden"
                                                               name="catatan_verifikasi<?php echo $key->id_unit ?>"
                                                               id="catatan_verifikasi<?php echo $key->id_unit ?>"
                                                               value="<?php //echo $key->catatan_verifikasi ?>">
                                                        <input type="hidden"
                                                               name="waktu_verifikasi<?php echo $key->id_unit ?>"
                                                               id="waktu_verifikasi<?php echo $key->id_unit ?>"
                                                               value="<?php //echo $key->waktu_verifikasi ?>">
                                                    </td>
                                                    <td><input type="text" step="any"
                                                               name="nilai_awal<?php echo $key->id_unit ?>"
                                                               id="nilai_awal<?php echo $key->id_unit ?>"
                                                               class="form-control nilai_awal" <?php //echo ($enable?'':'readonly') ?>></td>
                                                    <td><input type="number" step="any" max="100"
                                                               name="nilai_konversi<?php echo $key->id_unit ?>"
                                                               id="nilai_konversi<?php echo $key->id_unit ?>"
                                                               class="form-control nilai_konversi" <?php //echo ($enable?'':'readonly') ?>></td>

                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                    <div class="form-group"><?php
                                        if ($_SESSION['user']->id_role==1 or ($_SESSION['user']->id_role==2 && !empty($_SESSION['user']->id_unit))){
                                            echo '<button type="submit" class="btn btn-primary">Simpan</button>';
                                        }
                                        ?>
                                        <button type="button" class="btn btn-default btn-cancel">Cancel</button>
                                    </div>
                                </form>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="card" >
        <div class="card-body" >
            <h4 class="card-title">Form Penilaian</h4>

        </div>
    </div>-->
</div>
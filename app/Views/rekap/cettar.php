<div class="content-wrapper">
    <div class="card" id="divDataRekap">
        <div class="card-body" >
            <div class="row">
                <div class="col-md-8">
                    <h4 class="card-title">Rangking <?php echo $label ?></h4>
                </div>
                <div class="col-md-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="text-align: right; border: 0px !important; margin-top: -10px;">
                            <li class="breadcrumb-item"><a href="#">Rangking <?php echo $label ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-12">
                    <blockquote class="blockquote blockquote-primary">
                        <form id="frmsearch" class="forms-sample form-horizontal">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>Tahun</label>
                                    <input type="hidden" id="tag" value="<?php echo (isset($tag)?$tag:'opd') ?>">
                                    <select name="tahun" class="form-control" id="tahun">
                                        <?php
                                            foreach($periode as $key => $p ){
                                                $selected = ($key == (count($periode) - 1)) ? 'selected' : '';
                                                echo '<option value="'.$p->id_periode.'" '.$selected.'>'.$p->tahun_periode.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label><?php echo $label ?></label>
                                    <select name="id_unit" id="id_unit" class="form-control select2"  width="100%">
                                        <option value="">- Semua <?php echo $label ?> -</option>
                                        <?php
                                        if(isset($unit)) {
                                            foreach ($unit as $key) {
                                                echo '<option value="' . $key->id_unit . '">' . $key->unit . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 filter-cettar" style="display:none">
                                    <label>Predikat</label>
                                    <div>
                                    <select name="predikat" id="predikat" class="form-control select2" width="100%">
                                        <?php
                                         $kategori = array(
                                            'SANGAT CETTAR' => 'SANGAT CETTAR','CETTAR'=>'CETTAR',
                                            'CUKUP CETTAR' => 'CUKUP CETTAR',
                                             'KURANG CETTAR' => 'KURANG CETTAR',
                                             'TIDAK CETTAR' => 'TIDAK CETTAR'
                                        );

                                         echo '<option value="">- Semua Predikat -</option>';
                                        foreach ($kategori as $key => $value){
                                            $selected = '';
                                            echo '<option value="'.$key.'" '. $selected.' >'. $value.'</option>';
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>

                                <div class="col-md-4 filter-aspek" style="display:none">
                                    <label>Aspek</label>
                                    <div>
                                    <select name="id_aspek" id="id_aspek" class="form-control select2" width="100%">
                                        <?php
                                        echo '<option value="">- Semua Aspek -</option>';
                                        if(isset($indikator)){
                                            $aspek=array();
                                            foreach ($indikator as $key):
                                                $temp = array(
                                                    "id_aspek" => $key->id_aspek,
                                                    "aspek" => $key->aspek
                                                );
                                                if (!in_array($temp, $aspek)) array_push($aspek, $temp);
                                            endforeach;

                                            foreach($aspek as $row):
                                                $selected = '';
                                                echo '<option value="'.$row['id_aspek'].'" '. $selected.' >'. $row['aspek'].'</option>';
                                            endforeach;
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>



                            </div>
                         </form>
                    </blockquote>
                </div>
                <div class="col-md-12" style="margin-top: 20px;">
                    <div id="chart"></div>

                    <div class="table-responsive" id="div-rekap" style="margin-top: 50px;">
                        <table class="table table-hover table-striped display" id="tableRekap">
                            <thead>
                            <tr>
                                <th>Periode</th>
                                <th><?php echo $label ?></th>
                                <th>Nilai</th>
                                <th>Hasil</th>
                                <th>Predikat</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
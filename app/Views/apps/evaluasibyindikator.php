<div class="content-wrapper" style="margin-top: -20px;">
    <div class="page-header">
        <h3 class="page-title"> 
            Form Penilaian <?php echo (isset($tag) ? 'Kabupaten/Kota' : 'Perangkat Daerah') ?>
        </h3>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Penilaian <?php echo (isset($label)?$label:'') ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Penilaian <?php echo (isset($tag) ? 'Kab/Kota' : 'Perangkat Daerah') ?>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card" id="divDataEvaluasi">
        <div class="card-body" >            
            <input type="hidden" id="tmp-indikator" value="<?php echo (isset($id_indikator)?$id_indikator:'') ?>">
            <input type="hidden" id="tag" value="<?php echo (isset($tag)?$tag:'opd') ?>">

            <div class="row">
                <div class="col-12">
                    <form id="frmsearch" class="forms-sample form-horizontal">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tahun Periode</label>
                                    <select name="tahun" id="tahun-periode" class="form-control">
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        Indikator
                                        (<span style="font-size: 8pt;">Indikator menyesuaikan dengan tahun periode yang dipilih</span>)
                                    </label>
                                    <select name="id_indikator" id="id_indikator_cmb" class="form-control select2"  width="100%">
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 text-right">
                                <?php
                                if($_SESSION['user']->id_role==1 or ($_SESSION['user']->id_role==2 && $_SESSION['user']->id_unit==6))
                                {
                                    echo '<br><button type="button" id="sync-serapan" class="btn btn-danger">Sinkronisasi Serapan Anggaran</button>';
                                }
                                ?>
                            </div>
                        </div>
                    </form>

                    <div class="row" id="divFormEvaluasis" style="margin-top: 10px;">
                        <div class="col-md-12 example-wrap">
                            <blockquote class="blockquote blockquote-primary" style="border: 2px solid #ddd !important; border-radius: 10px;">
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
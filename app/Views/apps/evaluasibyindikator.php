<div class="content-wrapper" style="margin-top: -20px;">
    <div class="page-header">
        <h3 class="page-title"> 
            Form Penilaian <?php echo $tag == 'opd' ? 'Perangkat Daerah' : 'Kabupaten/Kota' ?>
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
            <input type="hidden" id="tag" value="<?php echo ($tag) ? $tag : 'opd' ?>">

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

                            <!-- <div class="col-md-4 text-right">
                                <?php
                                if($_SESSION['user']->id_role==1 or ($_SESSION['user']->id_role==2 && $_SESSION['user']->id_unit==6))
                                {
                                    echo '<br><button type="button" id="sync-serapan" class="btn btn-danger">Sinkronisasi Serapan Anggaran</button>';
                                }
                                ?>
                            </div> -->
                        </div>
                    </form>

                    <div class="row" style="padding: 0px 10px;">
                        <div class="col-md-12" id="lock-info" style="background: var(--primary); color: white; padding: 10px 20px; font-size: 10pt; border-radius: 10px; display: none; margin-bottom: 10px;">
                            <b>Read Only !</b> Periode ini sudah dikunci, Nilai yang sudah tersimpan tidak bisa diedit.
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <blockquote class="blockquote blockquote-primary" style="border: 2px solid #ddd !important; border-radius: 10px;">
                                <form id="formEvaluasi" enctype="multipart/form-data" method="post" class="forms-sample form-horizontal">
                                    <input type="hidden" name="id_indikator" id="id_indikator" readonly>
                                    <input type="hidden" name="tahun" id="tahun" readonly>
                                    <input type="hidden" name="periode" id="periode" readonly>
                                    <input type="hidden" name="periode_status" id="periode_status" readonly>
                                    <input type="hidden" name="nilai_maks" id="nilai_maks" readonly>
                                    <input type="hidden" name="bobot" id="bobot" readonly>
                                    <input type="hidden" name="id_role" id="id_role" value="<?php echo $_SESSION['user']->id_role ?>">
                                    <input type="hidden" name="id_opd" id="id_opd" value="<?php  echo $_SESSION['user']->id_unit ?>">

                                    <div class="form-group div-data" style="border-bottom: 2px solid #eee; padding-bottom: 20px;">
                                        <table class="table table-hover table-striped" id="table-data" style="margin-bottom: 20px;">
                                            <thead>
                                                <tr>
                                                    <th width="60%" style="font-weight: bold;">
                                                        Nama 
                                                        Perangkat Daerah
                                                    </th>
                                                    <th width="20%" class="text-center" style="font-weight: bold;">
                                                        Nilai Awal
                                                    </th>
                                                    <th class="text-center" style="font-weight: bold;">
                                                        Nilai Konversi
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td colspan="3" class="text-center" id="data-text-info">Pilih indikator menggunakan pilihan diatas</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="form-group"><?php
                                        if ($_SESSION['user']->id_role==1 or ($_SESSION['user']->id_role==2 && !empty($_SESSION['user']->id_unit))){
                                            echo '<button type="button" id="submit-form" class="btn btn-primary btn-hide-first" style="display: none; padding: 10px 15px; font-size: 9pt">Simpan</button>';
                                        }
                                        ?>
                                        <button type="button" class="btn btn-default btn-cancel btn-hide-first cancel" style="display: none; padding: 10px 15px; font-size: 9pt">Cancel</button>
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
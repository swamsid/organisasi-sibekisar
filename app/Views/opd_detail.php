<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SIBEKISAR, CETTAR">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Sibekisar - Sistem Integrasi Bersama Kinerja Implementasi Budaya CETTAR</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/bootstraps.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/font-awesome.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/vendors/datatables/rg/jquery.dataTables.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/main.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/owl-carousel.css") ?>">
    <link rel="shortcut icon" href="<?php echo base_url("assets/images/favicon.ico") ?>">
    <script>
        base_url = "<?php echo base_url(); ?>";
    </script>
    <style>
        #layout{
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 999;
            text-align: center;;
            /* display: none; */
            margin-top: -20vh;
        }

        #layout .konten{
            position: fixed;
            top: 50%;
            left: 50%;
            color: white;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    </style>
</head>

<body>
<div id="layout">
    <div class="konten">
        Menyiapkan Data, Harap Tunggu ...
    </div>
</div>

<?php echo view('header') ?>
<div class="left-image-decor"></div>
<section class="section" style="margin-top:10%!important;">
    <div class="container">
        <div class="row">
            <div class="card col-md-12">
                <div class="card-body">
                    <input type="hidden" id="tag" value="<?php echo (isset($tag) ? $tag : 'opd') ?>">
                    <?php if ($unit->kategori_unit == 'opd') { ?>
                        <img src="<?php base_url('uploads/logo_pd' . $unit->logo) ?>" class="img img-thumbnail">
                    <?php } else { ?>
                        <img src="<?php base_url('uploads/logo_kab' . $unit->logo) ?>" class="img img-thumblail">
                    <?php } ?>
                    <h4 class="card-title"><?php echo ($unit->nama_unit ? ucwords(strtolower($unit->nama_unit)) : $unit->unit) ?></h4>

                    <div class="row">

                        <div class="col-lg-12 col-md-12">
                            <hr>
                            <!--<div align="center" class="text-center">
                            <img src="<?php /*echo base_url($unit->foto_pejabat) ?>" class="img img-thumbnail img-rounded center" style="border-radius: 50%;" width="80px">
                            <br><small>Kepala <?php echo $unit->unit ?></small><br>
                            <b><?php echo $unit->pejabat */ ?></b>
                        </div>
                        <hr>-->
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <!-- <img src="<?php //echo base_url($unit->foto) 
                                                    ?>" class="img img-thumbnail">-->
                                    <img src="<?php echo ($unit->foto_pejabat == 1 ? base_url('assets/images/foto/' . $unit->id_unit . '.jpg') : file_url($unit->foto_pejabat)); ?>" class="img img-thumbnail center">
                                    <br><small><?php
                                                if ($unit->kategori_unit == 'kab') echo (substr($unit->unit, 0, 4) == 'Kota' ? 'Walikota' : 'Bupati') . ' ' . (substr($unit->unit, 0, 4) == 'Kota' ? str_replace('Kota', '', $unit->unit) : str_replace('Kabupaten', '', $unit->unit));
                                                else echo $unit->nm_jabatan . ' ' . $unit->unit;
                                                ?></small><br>
                                    <b><?php echo $unit->pejabat ?></b>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    <?php
                                    if ($unit->kategori_unit == 'opd') {
                                    ?>
                                        <b>Tugas</b> 
                                        <div style="margin-top: 10px;"> 
                                            <?php echo ($unit->tugas ? $unit->tugas : '-') ?>
                                        </div>
                                        <?php $misi = str_replace([";"], "&&&", $unit->fungsi) ?>
                                        <hr>
                                        <b>Fungsi</b> 
                                        <div style="margin-top: 10px;">
                                            <table width="100%">
                                                <tbody>
                                                    <?php 
                                                        echo ($misi == '') ? '---' : '';
                                                        
                                                        $num = 1;
                                                        foreach(explode('&&&', $misi) as $key => $data){
                                                            if($data != '')
                                                                echo '<tr><td width="3%" style="vertical-align: top; padding-bottom: 10px;">'.$num.'. </td>';
                                                                echo '<td style=" padding-bottom: 10px;">'.str_replace('"', '', $data).'</td></tr>';

                                                            $num++;
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                    <?php 
                                        } else {
                                            if($unit->tujuan == '') { 
                                    ?>
                                        <b>Visi</b> 
                                        <div style="margin-top: 10px;"> 
                                            <?php echo ($unit->tugas ? $unit->tugas : '-') ?>
                                        </div>
                                        <?php $misi = str_replace([";"], "&&&", $unit->fungsi) ?>
                                        <hr>
                                        <b>Misi</b> 
                                        <div style="margin-top: 10px;">
                                            <table width="100%">
                                                <tbody>
                                                    <?php 
                                                        echo ($misi == '') ? '---' : '';
                                                        
                                                        $num = 1;
                                                        foreach(explode('&&&', $misi) as $key => $data){
                                                            if($data != '')
                                                                echo '<tr><td width="3%" style="vertical-align: top; padding-bottom: 10px;">'.$num.'. </td>';
                                                                echo '<td style=" padding-bottom: 10px;">'.str_replace('"', '', $data).'</td></tr>';

                                                            $num++;
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php   } else { ?>

                                        <?php $tujuan = str_replace([";"], "&&&", $unit->tujuan) ?>

                                        <b>Tujuan</b> 
                                        <div style="margin-top: 10px;">
                                            <table width="100%">
                                                <tbody>
                                                    <?php 
                                                        echo ($tujuan == '') ? '---' : '';
                                                        
                                                        $num = 1;
                                                        foreach(explode('&&&', $tujuan) as $key => $data){
                                                            if($data != '')
                                                                echo '<tr><td width="3%" style="vertical-align: top; padding-bottom: 10px;">'.$num.'. </td>';
                                                                echo '<td style=" padding-bottom: 10px;">'.str_replace('"', '', $data).'</td></tr>';

                                                            $num++;
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                    <?php 
                                            }
                                        }
                                    ?>
                                    <b>Alamat : </b>
                                    <div style="margin-top: 10px;">
                                        <div>
                                            <i class="fa fa-map-marker fa-fw"></i> &nbsp;<?php echo $unit->alamat ?><br>
                                        </div>

                                        <div style="padding-left: 30px;">
                                            Telp. <?php echo $unit->telp ?>, Fax. <?php echo $unit->fax ?>
                                        </div>

                                        <div style="margin-top: 30px;">
                                            <i class="fa fa-link fa-fw"></i> &nbsp;<a href="<?php echo $unit->website ?>" target="_blank"><?php echo $unit->website ?></a>
                                        </div>

                                        <div>
                                            <i class="fa fa-envelope fa-fw"></i> &nbsp;<?php echo $unit->email ?>
                                        </div>

                                        <div>
                                            <?php
                                                if ($unit->kategori_unit == 'opd') {
                                            ?>
                                                <br>
                                                <?php if ($unit->medsos_ig) { ?> <a href="http://instagram.com/<?php echo str_replace('@', '', $unit->medsos_ig) ?>" target="_blank"><i class="fa fa-instagram"></i> <?php echo $unit->medsos_ig ?>
                                                    </a>&nbsp;<?php } ?>
                                                    <?php if ($unit->medsos_fb) { ?><a href="http://facebook.com/<?php echo str_replace('@', '', $unit->medsos_fb) ?>" target="_blank"><i class="fa fa-facebook-square"></i> <?php echo $unit->medsos_fb ?>
                                                        </a>&nbsp;<?php } ?>
                                                        <?php if ($unit->medsos_twitter) { ?><a href="http://twitter.com/<?php echo str_replace('@', '', $unit->medsos_twitter) ?>" target="_blank"><i class="fa fa-twitter-square"></i> <?php echo $unit->medsos_twitter ?>
                                                            </a><?php }
                                                        } 
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card col-md-12" style="margin-top:20px">
                <div class="card-body" >
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Rapor CETTAR</h4>
                        </div>
                        <div class="col-md-4 text-right" style="padding-top: 8px; padding-right: 0px;">
                            <b>Tahun Periode</b>                                    
                        </div>
                        <div class="col-md-2">
                            <form id="frmsearch" class="forms-sample form-horizontal">
                                <div class="form-group">
                                    <input type="hidden" id="id_unit" value="<?php echo $unit->id_unit ?>">
                                    <select name="tahun" class="form-control" id="tahun">
                                        <?php
                                            foreach($dataPeriode as $key => $dPeriode){
                                                if(isset($_GET['t']))
                                                    $selected = ($dPeriode->id_periode == $_GET['t']) ? 'selected' : '';
                                                else
                                                    $selected = ($key == (count($dataPeriode) - 1)) ? 'selected' : '';


                                                echo '<option value="'.$dPeriode->id_periode.'" '.$selected.'>'.$dPeriode->tahun_periode.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-12" style="margin-top: 20px;">
                            <div class="table-responsive" id="div-spirit">
                                <table class="table table-hover table-striped display" id="tableSpirit">
                                    <thead>
                                    <tr>
                                        <th>Periode</th>
                                        <th>Perangkat Daerah</th>
                                        <th>Nilai</th>
                                        <th>Hasil</th>
                                        <th>Predikat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div id="chart"></div>

                            <div class="table-responsive" id="div-rekap">
                                <table class="table table-hover table-striped display" id="tableRekap">
                                    <thead>
                                    <tr>
                                        <th>Periode</th>
                                        <th>Perangkat Daerah</th>
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

            <div class="card proj-progress-card col-md-12" style="margin-top: 30px; padding: 20px;">
                <div class="card-block">
                    <div class="row" id="progress-aspek"></div>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- ***** Welcome Area End ***** -->

<!-- ***** Footer Start ***** -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="sub-footer">
                    <p>Copyright &copy; 2021 | Biro Organisasi Pemerintah Propinsi Jawa Timur</p>
                </div>
            </div>
        </div>
    </div>
</footer>


<!-- jQuery -->
<script src="<?php echo base_url("assets/landing/js/jquery-2.1.0.min.js") ?>"></script>

<!-- Bootstrap -->
<script src="<?php echo base_url("assets/landing/js/popper.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/bootstrap.min.js") ?>"></script>

<!-- Global Init -->
<script src="<?php echo base_url("assets/landing/js/owl-carousel.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/scrollreveal.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/waypoints.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/jquery.counterup.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/imgfix.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/custom.js") ?>"></script>

<script src="<?php echo base_url("assets/vendors/datatables/rg/jquery.dataTables.min.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables/rg/dataTables.rowsGroup.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/highchart/highcharts.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/highchart/highcharts-3d.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/opd_detail.js") ?>"></script>
</body>
</html>
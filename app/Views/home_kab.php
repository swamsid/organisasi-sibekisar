<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SIBEKISAR, CETTAR">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Sibekisar - Sistem Integrasi Bersama Kinerja Implementasi Budaya CETTAR</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/landing/css/font-awesome.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/main.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/landing/css/owl-carousel.css") ?>">
    <link rel="shortcut icon" href="<?php echo base_url("assets/images/favicon.ico") ?>">
    <script>
        base_url = "<?php echo base_url(); ?>";
    </script>
</head>

<body>

<?php echo view('header') ?>
<!-- ***** Welcome Area Start ***** -->
<div class="left-image-decor"></div>
<section class="section" style="margin-top:10%!important;">
    <div class="container">
        <div class="center-heading">
            <h2> Top 10 Kabupaten/Kota <em>Tercettar</em></h2>
            <!-- <p>SIBEKISAR berusaha untuk menilai budaya kerja Kabupaten/Kota melalui aspek dari CETTAR, sehingga diperlukan pengukuran terhadap masing-masing aspek yang terdapat dalam CETTAR.</p>-->
        </div>
        <div class="row  mobile-bottom-fix-big"  data-scroll-reveal="enter left move 30px over 0.6s after 0.1s">
            <div class="col-lg-12 col-md-12 col-sm-12"
                 style="top:0px!important">
                <input type="hidden" name="tahun" id="tahun" value="<?php echo (date("Y")-1) ?>">

                <div id="chart"></div>

            </div>
            <div class="col-md-12">
                <a href="<?php echo base_url("read/detail/spirit/kab")?>" class="pull-right second-button btn-xs">
                    Selengkapnya
                </a>
            </div>
        </div>

        <div class="row mobile-bottom-fix" style="padding-top:20px!important">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" data-scroll-reveal="enter right move 30px over 0.6s after 0.1s">
                <div class="features-item row">
                    <div class="col-md-4">
                        <div class="features-icon">
                            <img src="<?php echo base_url("assets/landing/images/fast-time1.png") ?>" alt="">
                            <div class="text">
                                <h4>ter <b>"CEPAT"</b></h4>
                                <h3><span class="text-danger text-bold lbl-tercepat"><?php echo strToUpper($cepat->unit) ?></span> </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="chartTercepat"></div>
                    </div>
                    <div class="col-md-12">
                        <a href="<?php echo base_url("read/detail/cepat/kab")?>" class="pull-right second-button btn-xs">
                            Selengkapnya
                        </a>
                    </div>
                </div>


            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" data-scroll-reveal="enter right move 30px over 0.6s after 0.1s" style="padding-top: 25px">
                <div class="features-item row">
                    <div class="col-md-4">
                        <div class="features-icon"><img src="<?php echo base_url("assets/landing/images/time-management1.png") ?>" alt="">
                            <div class="text">
                                <h4>ter <b>"EFEKTIF & EFISIEN"</b></h4>
                                <h3><span class="text-danger text-bold lbl-terefektif"><?php echo strToUpper($efektif->unit) ?></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="chartTerefektif"></div>
                    </div>
                    <div class="col-md-12">
                        <a href="<?php echo base_url("read/detail/efektif/kab")?>" class="pull-right second-button btn-xs">
                            Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" data-scroll-reveal="enter right move 30px over 0.6s after 0.1s" style="padding-top: 25px">
                <div class="features-item row">
                    <div class="col-md-4">
                        <div class="features-icon"><img src="<?php echo base_url("assets/landing/images/clock1.png") ?>" alt="">
                            <div class="text">
                                <h4>ter <b>"TANGGAP"</b></h4>
                                <h3><span class="text-danger text-bold lbl-tertanggap"><?php echo strToUpper($tanggap->unit) ?></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="chartTertanggap"></div>
                    </div>
                    <div class="col-md-12">
                        <a href="<?php echo base_url("read/detail/tanggap/kab")?>" class="pull-right second-button btn-xs">
                            Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" data-scroll-reveal="enter right move 30px over 0.6s after 0.1s" style="padding-top: 25px">
                <div class="features-item row">
                    <div class="col-md-4">
                        <div class="features-icon">
                            <img src="<?php echo base_url("assets/landing/images/user1.png") ?>" alt="">
                            <div class="text">
                                <h4>ter <b>"TRANSPARAN"</b></h4>
                                <h3><span class="text-danger text-bold lbl-tertransparan"><?php echo strToUpper($transparan->unit) ?></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="chartTertransparan"></div>
                    </div>
                    <div class="col-md-12">
                        <a href="<?php echo base_url("read/detail/transparan/kab")?>" class="pull-right second-button btn-xs">
                            Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" data-scroll-reveal="enter right move 30px over 0.6s after 0.1s" style="padding-top: 25px">
                <div class="features-item row">
                    <div class="col-md-4">
                        <div class="features-icon">
                            <img src="<?php echo base_url("assets/landing/images/accounting1.png") ?>" alt="">
                            <div class="text">
                                <h4>ter <b>"AKUNTABEL"</b></h4>
                                <h3><span class="text-danger text-bold lbl-terakuntabel"><?php echo strToUpper($akuntabel->unit) ?></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="chartTerakuntabel"></div>
                    </div>
                    <div class="col-md-12">
                        <a href="<?php echo base_url("read/detail/akuntabel/kab")?>" class="pull-right second-button btn-xs">
                            Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" data-scroll-reveal="enter right move 30px over 0.6s after 0.1s" style="padding-top: 25px">
                <div class="features-item row">
                    <div class="col-md-4">
                        <div class="features-icon">
                            <img src="<?php echo base_url("assets/landing/images/rocket1.png") ?>" alt="">
                            <div class="text">
                                <h4>ter <b>"RESPONSIF"</b></h4>
                                <h3><span class="text-danger text-bold lbl-terresponsif"><?php echo strToUpper($responsif->unit) ?></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="chartTerresponsif"></div>
                    </div>
                    <div class="col-md-12">
                        <a href="<?php echo base_url("read/detail/responsif/kab")?>" class="pull-right second-button btn-xs">
                            Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ***** Features Big Item End ***** -->

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

<!-- Plugins -->
<script src="<?php echo base_url("assets/landing/js/owl-carousel.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/scrollreveal.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/waypoints.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/jquery.counterup.min.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/imgfix.min.js") ?>"></script>

<!-- Global Init -->
<script src="<?php echo base_url("assets/vendors/highchart/highcharts.js") ?>"></script>
<script src="<?php echo base_url("assets/vendors/highchart/highcharts-3d.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/custom.js") ?>"></script>
<script src="<?php echo base_url("assets/landing/js/home_kab.js") ?>"></script>

</body>
</html>
<!-- ***** Preloader Start ***** -->
<div id="preloader">
    <div class="jumper">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- ***** Preloader End ***** -->
<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a class="logo" href="<?php  echo base_url('home') ?>">
                        <img src="<?php echo base_url("assets/images/logo-sibekisar.png") ?>" alt="logo" style="width: 180px" />
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li class="scroll-to-section"><a href="<?php  echo base_url('home') ?>" >Home</a></li>
                        <li class="scroll-to-section"><a href="<?php echo base_url('read/tentang') ?>" >Tentang</a></li>
                        <li class="scroll-to-section"><a href="<?php echo base_url('read/opd') ?>" >Perangkat Daerah</a></li>


                        <!--<li class="scroll-to-section"><a href="<?php //echo base_url('home/kab') ?>" class="menu-item">Kab/Kota</a>
                         </li>-->
                         <li class="submenu">
                             <a href="javascript:;">Kab/Kota</a>
                             <ul>
                                 <li><a href="<?php echo base_url('home/kab') ?>">Rekap</a></li>
                                 <li><a href="<?php echo base_url('read/kab') ?>">Raport</a></li>
                             </ul>
                         </li>
                        <li class="scroll-to-section"><a href="<?php echo base_url('auth') ?>" >Login</a></li>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->
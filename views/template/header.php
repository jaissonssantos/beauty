<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>

<div id="wrapper">
    
    <!-- Top Navigation -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header"> 
            <a class="navbar-toggle hidden-sm hidden-md hidden-lg" 
            href="javascript:void(0)" 
            data-toggle="collapse" 
            data-target=".navbar-collapse">
                <i class="ti-menu"></i>
            </a>
            <div class="top-left-part">
                <a class="logo" href="<?=($_SESSION['congresso_gestor'] == 1 ? '/administrador/dashboard' : '/office/dashboard')?>">
                    <b>
                        <img src="assets/images/common/icon-dashboard.svg" alt="home" />
                    </b>
                    <div class="title">
                        <span class="hidden-xs">Congresso</span>
                        <span class="hidden-xs">Jurídico</span>
                        <span class="hidden-xs">OAB ACRE</span>
                    </div>
                </a>
            </div>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- End Top Navigation -->
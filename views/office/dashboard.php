<?php
    if (!isset(
        $_SESSION['labella_uid'],
        $_SESSION['labella_nome'],
        $_SESSION['labella_email'],
        $_SESSION['labella_empresa'],
        $_SESSION['labella_profissao']
    )) {
        header('Location: /login');
    }
?>
<!-- Bootstrap Core CSS -->
<link href="assets/template/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/template/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
<!-- animation CSS -->
<link href="assets/template/css/animate.css" rel="stylesheet">
<!-- Menu CSS -->
<link href="assets/template/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
<!-- Page plugins css -->
<link href="assets/template/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="assets/template/css/style.min.css" rel="stylesheet">
<!-- color CSS -->
<link href="assets/template/css/colors/red.css" id="theme" rel="stylesheet">
<!-- fullcalendar CSS -->
<link href="assets/css/fullcalendar.min.css" rel="stylesheet">
<link href="assets/css/scheduler.min.css" rel="stylesheet">
<link href="assets/css/calendar.css" rel="stylesheet">
<!-- Autocomplete CSS -->
<link href="assets/css/autocomplete.min.css" rel="stylesheet">

<?php require_once 'views/template/header.php'; ?>
<?php require_once 'views/template/left.php'; ?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Meu painel</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="#">Agendamentos</a></li>
                    <li class="active">Meu painel</li>
                </ol>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="calendar-box p-b-20">
                    <div id="calendar"></div>
                    <div id="calendar-loading" class="text-center hidden">
                        <img src="assets/images/common/loading.gif">
                        <p>Aguarde um pouco, estamos processando...</p>
                    </div>
                </div>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

    </div><!-- end col -->
</div><!-- /.row -->

<div class="tooltip-calendar hidden">
    <div class="modal-header ">
        <button type="button" 
            class="close tooltipClose" aria-hidden="true">×</button>
    </div>
    <div class="modal-body card">
        <form id="tooltipCalendar" name="tooltipCalendar" class="form-horizontal">
            
            <button type="button" id="schedule" 
                class="btn btn-sm btn-mark">
                    <i class="fa fa-plus"></i> Novo compromisso
            </button>

            <p></p>

            <button type="button" id="block" 
                class="btn btn-sm btn-default">
                    <i class="fa fa-lock"></i> Bloquear horário
            </button>
        </form>
    </div>
</div><!--  /.tooltip-calendar -->

<?php require_once 'views/template/rigth.php'; ?>
<?php require_once 'views/template/footer.php'; ?>

<!-- javascripts -->
<script type="text/javascript" src="javascripts/office/dashboard.js"></script>
<script type="text/javascript" src="javascripts/office/global.js"></script>
<script type="text/javascript" src="javascripts/functions.js"></script>

<!-- Clock Plugin JavaScript -->
<script src="assets/template/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js"></script>

<!-- Javascript Fullcalendar -->
<script type="text/javascript" src="assets/javascript/moment.min.js"></script>
<script type="text/javascript" src="assets/javascript/moment-timezone-with-data.js"></script>
<script type="text/javascript" src="assets/javascript/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="assets/javascript/fullcalendar/scheduler.min.js"></script>
<script type="text/javascript" src="assets/javascript/fullcalendar/pt-br.js"></script>

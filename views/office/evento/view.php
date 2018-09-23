<?php
    /*if (!isset(
        $_SESSION['avaliacao_uid'],
        $_SESSION['avaliacao_nome'],
        $_SESSION['avaliacao_sobrenome'],
        $_SESSION['avaliacao_email'],
        $_SESSION['avaliacao_perfil'],
        $_SESSION['avaliacao_gestor'],
        $_SESSION['avaliacao_estabelecimento']
    ) || $_SESSION['avaliacao_gestor'] == 1) {
        header('Location: /login');
    }*/
?>
<!-- Bootstrap Core CSS -->
<link href="assets/template/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/template/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
<!-- animation CSS -->
<link href="assets/template/css/animate.css" rel="stylesheet">
<!-- Menu CSS -->
<link href="assets/template/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
<!-- morris CSS -->
<link href="assets/template/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
<link href="assets/template/plugins/bower_components/css-chart/css-chart.css" rel="stylesheet">
<!--Owl carousel CSS -->
<link href="assets/template/plugins/bower_components/owl.carousel/owl.carousel.min.css" rel="stylesheet" type="text/css" />
<link href="assets/template/plugins/bower_components/owl.carousel/owl.theme.default.css" rel="stylesheet" type="text/css" />
<!-- Bootstrap Select -->
<link href="assets/template/plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<!-- Switchery -->
<link href="assets/template/plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />
<!-- Page plugins css -->
<link href="assets/template/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
<!-- Date picker plugins css -->
<link href="assets/template/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<!-- Daterange picker plugins css -->
<link href="assets/template/plugins/bower_components/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
<link href="assets/template/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="assets/template/css/style.min.css" rel="stylesheet">
<!-- color CSS -->
<link href="assets/template/css/colors/red.css" id="theme" rel="stylesheet">

<?php require_once 'views/template/header.php'; ?>
<?php require_once 'views/template/left.php'; ?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Visualizar evento</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <!-- <a href="javascript:void(0)" target="_blank" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Atualize seu plano</a> -->
                <ol class="breadcrumb">
                    <li><a href="/office/dashboard">Dashboard</a></li>
                    <li><a href="/office/evento/">Evento</a></li>
                    <li class="active">Novo</li>
                </ol>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-md-12">                
                <div class="white-box">

                    <div class="row">

                        <div class="col-sm-12 col-xs-12">
                            <form id="formView" name="formView">
                                <input type="hidden" id="id" name="id" value="<?=$url_params?>">

                                <div id="error" class="row hidden">
                                    <div class="col-md-12">
                                        <div class="alert alert-warning">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                	
                                	<div class="col-md-3">

                                		<div class="row">
                                			<div class="col-md-12">
		                                		<img src="" id="qrcode" class="img-responsive img-thumbnail m-b-10">
		                                	</div>

		                                	<div id="image"></div>
                                		</div>

                                	</div>

                                	<div class="col-md-9">

                                		<div class="row">
		                                	<div class="col-md-12">
		                                        <div class="form-group">
		                                            <label for="categoria">Categoria</label>
		                                            <div id="categoria"></div> 
		                                        </div>                                
		                                    </div>
		                                </div>
                                		
                                		<div class="row">
		                                    <div class="col-md-12">
		                                        <div class="form-group">
		                                            <label for="nome">Nome do evento</label>
		                                            <div id="nome"></div>  
		                                        </div>                                
		                                    </div>
		                                </div>

		                                <div class="row">
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <label for="local">Local</label>
		                                            <div id="local"></div> 
		                                        </div>                                
		                                    </div>
		                                </div>

		                                <div class="row">
		                                	<div class="col-md-12">
		                                        <div class="form-group">
		                                            <label for="descricao">Descrição</label>
		                                            <div id="descricao"></div> 
		                                        </div>                                
		                                    </div>
		                                </div>

		                                <div class="row">
		                                	<div class="col-md-12">
		                                        <div class="form-group">
		                                            <label for="faixa">Faixa de preço</label>
		                                            <div id="faixa"></div> 
		                                        </div>                                
		                                    </div>
		                                </div>

		                                <div class="row">
		                                	<div class="col-md-12">
		                                        <div class="form-group">
		                                            <label for="pais">País</label>
		                                            <div id="pais"></div> 
		                                        </div>                                
		                                    </div>
		                                </div>

		                                <div class="row">
		                                	<div class="col-md-12">
		                                        <div class="form-group">
		                                            <label for="data">Data</label>
		                                            <div id="data"></div> 
		                                        </div>                                
		                                    </div>
		                                </div>

		                                <div class="row">
		                                	<div class="col-md-12">
		                                        <div class="form-group">
		                                            <label for="termino">Termino da publicação</label>
		                                            <div id="termino"></div> 
		                                        </div>                                
		                                    </div>
		                                </div>

                                	</div>

                                </div>

                            </form><!--/form-->
                        </div><!-- /.col-sm-12 -->

                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" id="cancelar" 
                                    class="btn btn-default waves-effect waves-light">Voltar</button>
                            </div>
                        </div>

                    </div><!-- /.row -->

                </div><!--/.white-box-->
            </div>
        </div><!--/.row -->


    </div><!-- end col -->
</div><!-- /.row -->

<?php require_once 'views/template/footer.php'; ?>

<!--Bootstrap Select -->
<script src="assets/template/plugins/bower_components/bootstrap-select/bootstrap-select.min.js"></script>
<!--Switchery-->
<script src="assets/template/plugins/bower_components/switchery/dist/switchery.min.js"></script>

<!-- javascripts -->
<script type="text/javascript" src="javascripts/functions.js"></script>
<script type="text/javascript" src="javascripts/office/evento/view.js"></script>
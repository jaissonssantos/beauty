<?php
    if (!isset(
        $_SESSION['eventos_uid'],
        $_SESSION['eventos_nome'],
        $_SESSION['eventos_email']
    ) || $_SESSION['eventos_uid'] == 0) {
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
                <h4 class="page-title">Novo evento</h4>
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

                    <h3 class="box-title m-b-0">Formulário</h3>
                    <p class="text-muted m-b-30 font-13"> Preencha o formulário abaixo </p>

                    <div class="row">

                        <div class="col-sm-12 col-xs-12">
                            <form id="formAdd" name="formAdd">
                                <input type="hidden" id="id" name="id" value="<?=$url_params?>">

                                <div id="error" class="row hidden">
                                    <div class="col-md-12">
                                        <div class="alert alert-warning">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="pais">Categoria <abbr>*</abbr></label>
                                            <select class="form-control" id="categoria" name="categoria"></select>
                                        </div>                                  
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nome">Nome <abbr>*</abbr></label>
                                            <input type="text" class="form-control" id="nome" name="nome"> 
                                        </div>                                
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="local">Local <abbr>*</abbr></label>
                                            <input type="text" class="form-control" id="local" name="local"> 
                                        </div>                                
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descricao">Descrição <abbr>*</abbr></label>
                                            <textarea class="form-control" rows="5" id="descricao" name="descricao"></textarea>
                                        </div>                                
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pais">País</label>
                                            <select class="form-control" id="pais" name="pais">
                                                <option value="1">Brazil</option>
                                                <option value="2">Bolívia</option>
                                                <option value="3">Peru</option>
                                            </select>
                                        </div>                                 
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pais">Faixa de preço </label>
                                            <select class="form-control" id="faixa" name="faixa">
                                                <option value="1">$</option>
                                                <option value="2">$$</option>
                                                <option value="3">$$$</option>
                                                <option value="4">$$$$</option>
                                                <option value="5">$$$$$</option>
                                            </select>
                                        </div>                                  
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="data">Data do evento</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="data" name="data" 
                                                    placeholder="DD/MM/AAAA" value="<?=date('d/m/Y')?>">
                                                    <span class="input-group-addon">
                                                        <i class="icon-calender"></i>
                                                    </span> 
                                            </div>
                                        </div>                                
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="termino">Data do encerramento</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="termino" name="termino" 
                                                    placeholder="DD/MM/AAAA" value="<?=date('d/m/Y')?>">
                                                    <span class="input-group-addon">
                                                        <i class="icon-calender"></i>
                                                    </span> 
                                            </div>
                                        </div>                                
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="input-file-now">Foto 01</label>
                                        <input type="text" class="form-control" id="foto1" name="foto1"> 
                                    </div>
                                    <div class="col-md-12">
                                        <label for="input-file-now">Foto 02</label>
                                        <input type="text" class="form-control" id="foto2" name="foto2"> 
                                    </div>
                                    <div class="col-md-12">
                                        <label for="input-file-now">Foto 03</label>
                                        <input type="text" class="form-control" id="foto3" name="foto3"> 
                                    </div>
                                    <div class="col-md-12">
                                        <label for="input-file-now">Foto 04</label>
                                        <input type="text" class="form-control" id="foto4" name="foto4"> 
                                    </div>
                                    <div class="col-md-12">
                                        <label for="input-file-now">Foto 05</label>
                                        <input type="text" class="form-control" id="foto5" name="foto5"> 
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 30px;">
                                        <button type="submit" id="salvar" 
                                            class="btn btn-success waves-effect waves-light m-r-10">Salvar</button>
                                        <button type="button" id="cancelar" 
                                            class="btn btn-inverse waves-effect waves-light">Voltar</button>
                                    </div>
                                </div>


                            </form><!--/form-->
                        </div><!-- /.col-sm-12 -->

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
<!-- Clock Plugin JavaScript -->
<script src="assets/template/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js"></script>
<!-- Color Picker Plugin JavaScript -->
<script src="assets/template/plugins/bower_components/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
<script src="assets/template/plugins/bower_components/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
<script src="assets/template/plugins/bower_components/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script src="assets/template/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="assets/template/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.pt-BR.js"></script>

<!-- javascripts -->
<script type="text/javascript" src="assets/javascript/jquery.mask.js"></script>
<script type="text/javascript" src="assets/javascript/jquery.validate.min.js"></script>
<script type="text/javascript" src="javascripts/functions.js"></script>
<script type="text/javascript" src="javascripts/office/evento/add.js"></script>
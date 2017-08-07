<?php
    if (!isset(
        $_SESSION['congresso_uid'],
        $_SESSION['congresso_nome'],
        $_SESSION['congresso_sobrenome'],
        $_SESSION['congresso_email'],
        $_SESSION['congresso_gestor']
    ) || $_SESSION['congresso_gestor'] == 0) {
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
                <h4 class="page-title">Lotes</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/administrador/dashboard">Dashboard</a></li>
                    <li><a href="/administrador/lote">Lotes</a></li>
                    <li class="active">Editar</li>
                </ol>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-md-12">                
                <div class="white-box">

                    <div id="form-loading" class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <img src="assets/images/common/loading.gif">
                                <p>Aguarde um pouco, estamos processando...</p>
                            </div>
                        </div>
                    </div>

                    <div id="form" class="row hidden">

                        <div class="col-sm-12 col-xs-12">
                            <h3 class="box-title m-b-0">Edição do lote: <span id="editName"></span></h3>
                            <p class="text-muted m-b-30 font-13"> Formulário de edição </p>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <form id="formLote" name="formLote">
                                
                                <div id="error" class="row hidden">
                                    <div class="col-md-12">
                                        <div class="alert alert-warning">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- hidden input -->
                                <input type="hidden" id="id" name="id" value="<?=$url_params?>">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nome">Nome<abbr>*</abbr></label>
                                            <input type="text" class="form-control" id="nome" name="nome"> 
                                        </div>                                
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="box-title m-b-10">Ingresso(s)</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <button id="add" class="btn btn-info btn-sm pull-right" type="button">
                                            <span class="btn-label"><i class="fa fa-plus"></i></span>Adicionar
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div id="itens" class="col-md-12">
                                        <div id="item" class="well" data-id="1">
                                            <input type="hidden" id="ingressoId" 
                                                name="ingressoId[]">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" 
                                                        class="form-control" 
                                                        id="ingressoNome" 
                                                        name="ingressoNome[]" 
                                                        placeholder="Ingresso"> 
                                                    </div>                                
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" 
                                                        class="form-control" 
                                                        id="ingressoQtd" 
                                                        name="ingressoQtd[]" 
                                                        placeholder="Quantidade"> 
                                                    </div> 
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" 
                                                        class="form-control" 
                                                        id="ingressoValor" 
                                                        name="ingressoValor[]" 
                                                        placeholder="Valor"> 
                                                    </div> 
                                                </div>
                                                <div class="col-md-12">
                                                    <button id="item-excluir" 
                                                        class="btn btn-danger btn-sm m-b-0 pull-right hidden" 
                                                        type="button">
                                                        <span class="btn-label">
                                                            <i class="ti-trash"></i>
                                                        </span>Excluir
                                                    </button>
                                                    <button id="item-duplicar" 
                                                        class="btn btn-inverse btn-sm m-b-0 pull-right m-r-10 hidden" 
                                                        type="button">
                                                        <span class="btn-label">
                                                            <i class="ti-files"></i>
                                                        </span>Duplicar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>                  
                                    </div>
                                    <div id="itens-remove"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
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

<!-- javascripts -->
<script type="text/javascript" src="assets/javascript/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/javascript/jquery.mask.js"></script>
<script type="text/javascript" src="javascripts/functions.js"></script>
<script type="text/javascript" src="javascripts/administrador/lote/edit.js"></script>
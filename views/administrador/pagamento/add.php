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
                <h4 class="page-title">Pagamentos</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/administrador/dashboard">Dashboard</a></li>
                    <li><a href="/administrador/pagamento">Pagamentos</a></li>
                    <li class="active">Pagamento Manual</li>
                </ol>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-md-3">     
                <div class="white-box">
                    <form id="formPagamento" name="formPagamento">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="senha">Busca por:</label>
                                    <input type="text" class="form-control" 
                                        id="pesquisa" name="pesquisa" placeholder="código, cliente e CPF"> 
                                </div>                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" id="procurar"
                                    class="btn btn-info btn-sm btn-block">
                                    <span class="btn-label"><i class="fa fa-search"></i></span>Procurar
                                </button>
                                <button type="button" id="cancelar"
                                    class="btn btn-default btn-sm btn-block">Voltar
                                </button>
                            </div>
                        </div>

                    </form><!--/form-->
                </div><!--/.white-box-->
            </div>

            <div class="col-md-9">                
                <div class="white-box">

                    <div id="success" class="alert alert-success hidden">
                        <button type="button" class="close" data-dismiss="alert" 
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <p></p>
                    </div>

                    <div class="table-responsive">
                        <div id="table-info" class="text-center m-t-20" 
                        style="margin-bottom: 68px;">
                            <i class="fa fa-search fa-2x"></i>
                            <p class="m-t-10">Faça uma busca pelo código da transação, nome do cliente ou CPF</p>
                        </div>
                        <div id="col-legenda" class="col-md-12 hidden m-t-10">
                            <div class="legenda">
                                <ul class="p-l-0">
                                    <li><span>Legenda: </span></li>
                                    <li>
                                        <i class="fa fa-credit-card"></i> Crédito
                                    </li>
                                    <li>
                                        <i class="fa fa-credit-card-alt"></i> Débito
                                    </li>
                                    <li>
                                        <i class="fa fa-barcode"></i> Boleto
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="table-loading" class="text-center hidden">
                            <img src="assets/images/common/loading.gif">
                            <p>Aguarde um pouco, estamos processando...</p>
                        </div>
                        <table id="table-results" class="table hidden">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>CPF</th>
                                <th>Ingresso</th>
                                <th>Valor</th>
                                <th class="text-center">Método</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Ação</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                          <p id="notfound" class="hidden"></p>
                    </div>

                    <div id="col-total" class="row hidden">
                        <div class="col-md-6">
                          <nav aria-label="Page navigation">
                              <ul id="pagination" class="pagination pagination-sm">
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                              </ul>
                            </nav>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right m-t-30">
                                <span id="pagination-length"></span>
                            </div>
                        </div>
                    </div><!--/.row -->

                </div><!--/.white-box-->
            </div>
        </div><!--/.row -->


    </div><!-- end col -->
</div><!-- /.row -->

<?php require_once 'views/template/footer.php'; ?>

<!-- javascripts -->
<script type="text/javascript" src="javascripts/functions.js"></script>
<script type="text/javascript" src="javascripts/administrador/pagamento/add.js"></script>
<script type="text/javascript" src="javascripts/administrador/global.js"></script>
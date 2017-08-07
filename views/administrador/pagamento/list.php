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
                    <li class="active">Lista</li>
                </ol>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-md-12">                
                <div class="white-box">

                    <div id="success" class="alert alert-success hidden">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <p></p>
                    </div>

                    <ul class="nav nav customtab nav-tabs hidden" role="tablist">
                        <li class="nav-item">
                            <a href="#status" id="paga" data-status="3"
                                class="nav-link active" data-toggle="tab">
                                <span class="hidden-xs"> Paga</span>
                                <span id="count-paga" class="label label-rouded label-success pull-right m-l-5">1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#status" id="aguardando" data-status="1"
                                class="nav-link" data-toggle="tab">
                                <span class="hidden-xs"> Aguardando pagamento</span>
                                <span id="count-aguardando" class="label label-rouded label-warning pull-right m-l-5">1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#status" id="analise" data-status="2"
                                class="nav-link" data-toggle="tab">
                                <span class="hidden-xs"> Em análise</span>
                                <span id="count-analise" class="label label-rouded label-info pull-right m-l-5">1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#status" id="cancelada" data-status="7"
                                class="nav-link" data-toggle="tab">
                                <span class="hidden-xs"> Cancelada</span>
                                <span id="count-cancelada" class="label label-rouded label-danger pull-right m-l-5">1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div id="col-reload" class="pull-right hidden">
                                <div class="text-right">
                                    <img src="assets/images/common/loading.gif">
                                    <span>Processando...</span>
                                </div>
                            </div>
                        </li>
                    </ul><!-- /.nav nav-tabs -->

                    <div id="add" class="pull-right hidden">
                        <button class="btn btn-info btn-sm btn-add waves-effect waves-light" type="button">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>Baixar pgto
                        </button>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane active" id="status" aria-expanded="true">
                            
                            <div id="col-search" class="col-md-3 hidden">
                                <form>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input id="search" type="text" 
                                            class="form-control input-sm" placeholder="Busca por código, cliente e CPF">
                                            <span class="input-group-addon p-r-20">
                                                <i class="fa fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                  </form>
                            </div>

                            <div id="col-legenda" class="col-md-9 m-t-5 hidden">
                                <div class="legenda">
                                    <ul>
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
                                        <li>
                                            <i class="ti-link"></i> Link de pgto.
                                        </li>
                                        <li>
                                            <i class="icon-loop"></i> 2° via de pgto
                                        </li>
                                        <li>
                                            <i class="fa fa-search"></i> Detalhes
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <div id="table-loading" class="text-center">
                                    <img src="assets/images/common/loading.gif">
                                    <p>Aguarde um pouco, estamos processando...</p>
                                </div>
                                <table id="table-results" class="table hidden">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>CPF</th>
                                        <th>Ingresso</th>
                                        <th>Valor</th>
                                        <th class="text-center">Método</th>
                                        <th class="text-center"></th>
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

                        </div><!-- /.tab-pane -->
                    </div><!-- /.nav nav-tabs -->

                </div><!--/.white-box-->
            </div>
        </div><!--/.row -->


    </div><!-- end col -->
</div><!-- /.row -->

<?php require_once 'views/template/footer.php'; ?>

<!-- javascripts -->
<script type="text/javascript" src="javascripts/functions.js"></script>
<script type="text/javascript" src="javascripts/administrador/pagamento/list.js"></script>
<script type="text/javascript" src="javascripts/administrador/global.js"></script>

<!-- Javascript Pagseguro -->
<script type="text/javascript" src="<?=javascriptURL?>"></script>
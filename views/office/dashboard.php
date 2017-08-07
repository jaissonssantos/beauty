<?php
    if (!isset(
        $_SESSION['congresso_uid'],
        $_SESSION['congresso_nome'],
        $_SESSION['congresso_sobrenome'],
        $_SESSION['congresso_cpf'],
        $_SESSION['congresso_email'],
        $_SESSION['congresso_gestor']
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
                <h4 class="page-title">Dashboard</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li class="active">Meu painel</li>
                </ol>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="box-title m-b-30">Olá <?=$_SESSION['congresso_nome'].' '.$_SESSION['congresso_sobrenome']?></h3>
                            <!-- Nav tabs -->
                            <ul class="nav nav-custom nav-tabs" role="tablist">
                                <li role="presentation" class="nav-item">
                                    <a href="#info" class="nav-link active" aria-controls="home" role="tab" 
                                        data-toggle="tab" aria-expanded="true">
                                        <span class="visible-xs"><i class="ti-home"></i></span>
                                        <span class="hidden-xs"> Informações básicas</span>
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <a href="#registration" class="nav-link" aria-controls="profile" role="tab" 
                                    data-toggle="tab" aria-expanded="false">
                                    <span class="visible-xs"><i class="ti-user"></i></span> 
                                    <span class="hidden-xs">Matrículas</span>
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <a href="#certificate" class="nav-link" aria-controls="messages" role="tab" 
                                    data-toggle="tab" aria-expanded="false">
                                    <span class="visible-xs"><i class="ti-email"></i></span> 
                                    <span class="hidden-xs">Certificados</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="info">
                                    <div class="col-md-3">
                                        <b>Nome completo:</b>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="cliente"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <b>Crachá:</b>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="cracha"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <b>Sexo:</b>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="sexo"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <b>CPF:</b>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="cpf"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <b>Telefone:</b>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="telefone"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <b>E-mail:</b>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="email"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <b>País de origem:</b>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="pais"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <b>Cidade:</b>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="cidade"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <b>Desde de:</b>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="created_at"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <b>Último acesso:</b>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="login_at"></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="registration">
                                    <div class="well">
                                        <div class="row row-registration">
                                            <div class="col-md-6">
                                                <h5 id="lote">1º Lote</h5>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button id="btn-segundavia" 
                                                    class="btn btn-success hidden"> 
                                                    <i class="icon-doc m-r-5"></i> <span>2ª via de pagamento</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <b>Matrícula:</b>
                                            </div>
                                            <div class="col-md-9">
                                                <p id="matricula"></p>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Transação:</b>
                                            </div>
                                            <div class="col-md-9">
                                                <p id="transacao"></p>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Ingresso:</b>
                                            </div>
                                            <div class="col-md-9">
                                                <p id="ingresso"></p>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Valor:</b>
                                            </div>
                                            <div class="col-md-9">
                                                <p id="valor"></p>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Método:</b>
                                            </div>
                                            <div class="col-md-9">
                                                <p id="metodo"></p>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Status:</b>
                                            </div>
                                            <div class="col-md-9">
                                                <p id="status"></p>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Criado em:</b>
                                            </div>
                                            <div class="col-md-9">
                                                <p id="created_pay_at"></p>
                                            </div>
                                            <div class="col-md-3">
                                                <b>Atualizado em:</b>
                                            </div>
                                            <div class="col-md-9">
                                                <p id="updated_pay_at"></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="certificate">
                                    <div class="col-md-6">
                                        <h3>Aguarde a conclusão do curso para impressão do certificado!</h3>
                                        <h4>Obrigado por participar do evento!!!</h4>
                                    </div>
                                    <div class="col-md-5 pull-right">
                                        <p></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.row -->

                </div>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

    </div><!-- end col -->
</div><!-- /.row -->

<?php require_once 'views/template/rigth.php'; ?>
<?php require_once 'views/template/footer.php'; ?>

<!-- javascripts -->
<script type="text/javascript" src="javascripts/office/dashboard.js"></script>
<script type="text/javascript" src="javascripts/office/global.js"></script>

<!-- Javascript Pagseguro -->
<script type="text/javascript" src="<?=javascriptURL?>"></script>

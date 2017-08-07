<!-- CSS -->
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<link rel="stylesheet" type="text/css" href="assets/css/login.css">

<div class="transparencia"></div>
<div class="container">
    <a href="/" class="logo-new">
        <img src="../assets/images/pages/logo-congresso-login.svg" alt="">
    </a>
    <div class="title">
        <div class="separador"></div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="flat-form">
                <ul class="tabs">
                    <li style="width: 100%">
                        <a href="#reset" class="active"><i class="pe-7s-pen"></i>  Nova senha</a>
                    </li>
                </ul>

                <div id="reset" class="form-action">
                    <br/>
                    <form id="formReset" name="formReset">

                        <input id="token" name="token" type="hidden" value="<?=$url_subpath?>">

                        <div class="loading col-md-12 text-center">
                            <img src="assets/images/common/loading.gif" width="38">
                            <p>Aguarde, processando...</p>
                        </div>

                        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 form-change hidden">
                            <div id="errorPassword" class="row hidden">
                                <div class="col-md-12">
                                    <div class="alert alert-warning">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div id="successPassword" class="row hidden">
                                <div class="col-md-12">
                                    <div class="alert= alert-success">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nova senha</label>
                                        <input id="senha" name="senha" placeholder="Senha" class="form-control" type="password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Confirma</label>
                                        <input id="confirmasenha" name="confirmasenha" placeholder="Confirme sua senha" class="form-control" type="password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button id="salvar" class="btn btn-success btn-fill btn-wd">SALVAR</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--/#register.form-action-->
            </div>

        </div>
    </div>
</div>


<!-- javascripts -->
<script type="text/javascript" src="assets/javascript/jquery.validate.min.js"></script>
<script type="text/javascript" src="javascripts/functions.js"></script>
<script type="text/javascript" src="javascripts/password-change.js"></script>

<!-- Javascript Pagseguro -->
<script type="text/javascript" src="<?=javascriptURL?>"></script>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<link rel="stylesheet" type="text/css" href="assets/css/login.css">

<!-- Login Content -->
<div class="area imagem">
    <div class="fade-login"></div>
    <a href="/" class="voltar" title="Voltar">Voltar</a>
    <span class="direitos">Todos os direitos reservados © 2017-<?=date('Y')?> LA BELLA LTDA.</span>
</div>
<div class="area area-login">
    <img src="assets/images/common/icon_logo_orange.svg" border="0" class="logo" />
    <div class="container-login">
        <form id="formLogin" name="formLogin">
            <div class="row">
                <div id="error" class="col-md-12 hidden">
                    <div class="alert alert-danger">
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="container-campos">
                        <div class="form-group">
                            <label for="email">Endereço de e-mail</label>
                            <div class="controls">
                                <input type="text" id="email" name="email" class="form-control" placeholder="E-mail" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="container-campos">
                        <div class="form-group">
                            <label class="senha">Senha</label>
                            <div class="controls">
                                <input type="password" id="senha" name="senha" class="form-control" placeholder="Sua senha" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" id="entrar" class="botao btn btn-block btn-primary">Entrar</button>
                </div>
            </div>
        </form>
        <div class="or">OU</div>
        <a href="/signup" class="btn facebook" name="facebook" id="facebook">Cadastre-se</a>
        <a href="/password" class="esqueceu-senha">Esqueceu sua senha?</a>
    </div>
</div>
<!-- END Login Content -->

<!-- javascripts -->
<script type="text/javascript" src="assets/javascript/jquery.validate.min.js"></script>
<script type="text/javascript" src="javascripts/login.js"></script>
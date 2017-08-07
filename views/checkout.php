<div class="modal-header"><!--.modal-header-->
    <h4 class="modal-title text-uppercase">Pagamento</h4>
    <div id="carrinho" class="carrinho">
      <i class="fa fa-shopping-cart"></i>
      <p class="descricao">Sua compra:</p>
      <p class="valor">R$0,00</p>
    </div>
</div><!--/.modal-header-->

<div class="modal-body"><!--.modal-body-->

  <div id="gerando-boleto" class="gerando-boleto hidden">
    <div class="back-drop"></div>
    <div class="load">
      <img src="assets/images/common/loading.gif" width="38">
      <p>Gerando boleto, aguarde...</p>
    </div>
  </div>

  <div id="mensagem" class="mensagem hidden"><!--.mensagem-->
    <div class="row">
      <div id="pagamento-pago" class="col-md-12 text-center hidden">
        <h1>Parabéns</h1>
        <h3>Sua compra foi realizada com sucesso</h3>
        <p id="pagamento-codigo"></p>
        <p id="pagamento-status"></p>
        <img src="assets/images/common/icon_success.svg" width="128">
      </div>
      <div id="pagamento-aguardando" class="col-md-12 text-center hidden">
        <h1>O pagamento está em processamento</h1>
        <h3>Estamos aguardando a confirmação do pagamento</h3>
        <h4>Você será notificado em breve, aguarde</h4>
        <p id="pagamento-codigo"></p>
        <p id="pagamento-status"></p>
        <img src="assets/images/common/icon_timer.svg" width="128">
      </div>
      <div id="pagamento-devolvido" class="col-md-12 text-center hidden">
        <h1>O pagamento foi devolvido</h1>
        <h3>Por favor, aguarde o valor ser devolvido ou retorne e refaça o pagamento</h3>
        <p id="pagamento-codigo"></p>
        <p id="pagamento-status"></p>
        <img src="assets/images/common/icon_warning.svg" width="128">
      </div>
      <div id="pagamento-cancelado" class="col-md-12 text-center hidden">
        <h1>O pagamento foi cancelado</h1>
        <h3>Por favor, retorne e refaça o pagamento</h3>
        <p id="pagamento-codigo"></p>
        <p id="pagamento-status"></p>
        <img src="assets/images/common/icon_cancel.svg" width="128">
      </div>
      <div id="pagamento-debito" class="col-md-12 text-center hidden">
        <h1>O pagamento está em processamento</h1>
        <h3>O pedido será confirmado somente após a aprovação do pagamento</h3>
        <p id="pagamento-codigo"></p>
        <p id="pagamento-status"></p>
        <img src="assets/images/common/icon_timer.svg" width="128">
      </div>
      <div id="pagamento-boleto" class="col-md-12 text-center hidden">
        <h1>O boleto foi enviado para o seu e-mail</h1>
        <h3>O pedido será confirmado somente após a aprovação do pagamento, para continuar clique em "Finalizar cadastro".</h3>
        <p id="pagamento-codigo"></p>
        <p id="pagamento-status"></p>
        <img src="assets/images/common/icon_timer.svg" width="128">
      </div>
    </div>
  </div><!--/.mensagem-->

  <div id="pagamento" class="pagamento"><!--.pagamento-->
    <div id="errorBoleto" class="row hidden">
      <div class="col-md-12">
        <div class="alert alert-warning">
          <p></p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-center">Como deseja efetuar o pagamento do seu ingresso?</h1>
      </div>
      <div class="col-md-6">
        <a id="setPagamento" 
          class="block forma-pagamento text-center" href="javascript:;" data-rel="1">
          <div class="block-content block-content-full">
            <i class="fa fa-credit-card fa-4x"></i>
            <p>Cartão de crédito</p>
          </div>
        </a>
      </div>
      <!-- <div class="col-md-4">
        <a id="setPagamento" 
          class="block forma-pagamento text-center" href="javascript:;" data-rel="2">
          <div class="block-content block-content-full bg-modern">
            <i class="fa fa-credit-card-alt fa-4x"></i>
            <p>Débito online</p>
          </div>
        </a>
      </div> -->
      <div class="col-md-6">
        <a id="setPagamento" 
          class="block forma-pagamento text-center" href="javascript:;" data-rel="3">
          <div class="block-content block-content-full bg-modern">
            <i class="fa fa-barcode fa-4x"></i>
            <p>Boleto bancário</p>
          </div>
        </a>
      </div>
    </div><!--/.row-->
  </div><!--/.pagamento-->

  <div id="cartaoCredito" class="hidden">
    <form id="formCartaoCredito" name="formCartaoCredito" class="formCartaoCredito">
      <div id="errorCartaoCredito" class="row hidden">
        <div class="col-md-12">
          <div class="alert alert-warning">
            <p></p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
            <label for="portador">Nome<small>(como está no cartão)</small></label>
            <input type="text" class="form-control" id="portador" name="portador">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="cvc">CVC<small>(código de segurança)</small></label>
            <input type="text" class="form-control" id="cvc" name="cvc">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="numerocartao">Número do Cartão</label>
            <input type="text" class="form-control" id="numerocartao" name="numerocartao">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Mês</label>
            <select class="form-control" id="mes" name="mes">
              <option value=""></option>
              <option value="01">Janeiro</option>
              <option value="02">Fevereiro</option>
              <option value="03">Março</option>
              <option value="04">Abril</option>
              <option value="05">Maio</option>
              <option value="06">Junho</option>
              <option value="07">Julho</option>
              <option value="08">Agosto</option>
              <option value="09">Setembro</option>
              <option value="10">Outubro</option>
              <option value="11">Novembro</option>
              <option value="12">Dezembro</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Ano</label>
            <select class="form-control" id="ano" name="ano">
              <option value=""></option>
              <option value="2017">2017</option>
              <option value="2018">2018</option>
              <option value="2019">2019</option>
              <option value="2020">2020</option>
              <option value="2021">2021</option>
              <option value="2022">2022</option>
              <option value="2023">2023</option>
              <option value="2024">2024</option>
              <option value="2025">2025</option>
              <option value="2026">2026</option>
              <option value="2027">2027</option>
              <option value="2028">2028</option>
              <option value="2029">2029</option>
              <option value="2030">2030</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group bandeira">
            <img src="assets/images/common/visa.png" id="visa">
            <img src="assets/images/common/mastercard.png" id="mastercard">
            <img src="assets/images/common/amex.png" id="amex">
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="datanascimento">Data de nascimento(do portador)</label>
              <input type="text" class="form-control" id="datanascimento" name="datanascimento">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label for="area">DDD</label>
              <input type="text" class="form-control" id="area" name="area">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="datanascimento">Telefone</label>
              <input type="text" class="form-control" id="telefone" name="telefone">
            </div>
          </div>
        </div>
    </form>
  </div><!--/.row-->

  <div id="cartaoDebito" class="hidden">
    <form id="formCartaoDebito" name="formCartaoDebito" class="formCartaoDebito">
      <div id="errorCartaoDebito" class="row hidden">
        <div class="col-md-12">
          <div class="alert alert-warning">
            <p></p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <a id="setBanco" 
            class="block banco text-center" href="javascript:;" data-rel="bradesco">
            <div class="block-content block-content-full">
              <div class="logo">
                <img src="assets/images/common/bancobradesco.svg">
              </div>
              <p>Banco do Bradesco</p>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          <a id="setBanco" 
            class="block banco text-center" href="javascript:;" data-rel="itau">
            <div class="block-content block-content-full">
              <div class="logo">
                <img src="assets/images/common/bancoitau.png">
              </div>
              <p>Itaú</p>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          <a id="setBanco" 
            class="block banco text-center" href="javascript:;" data-rel="bancodobrasil">
            <div class="block-content block-content-full">
              <div class="logo">
                <img src="assets/images/common/bancodobrasil.svg">
              </div>
              <p>Banco de brasil</p>
            </div>
          </a>
        </div>
      </div>
      <div class="row">
        <p class="observacao">* Após clicar em "PAGAR" você receberá um link que levará ao site do seu banco, assim é possível realizar o pagamento em total segurança.</p>
      </div>
    </form>
  </div><!--/.row-->

</div><!--/.modal-body-->

<div class="modal-footer"><!--.modal-footer-->
  <div class="ambiente-seguro">
    <i class="fa fa-lock"></i>
    <span>Ambiente seguro</span>
    <p>Pagamento processado pelo <img src="assets/images/common/logo-pagseguro.png" width="60"></p>
  </div>
  <button id="alterar" class="btn btn-warning" type="button">ALTERAR INGRESSO</button>
  <button id="voltar" class="btn btn-warning hidden" type="button">VOLTAR</button>
  <button id="pagar" class="btn btn-success hidden" type="button">PAGAR</button>
  <button id="banking" class="btn btn-success hidden" type="button">PAGAR</button>
  <button id="internetbanking" class="btn btn-success hidden" type="button">ACESSAR A PÁGINA DO BANCO</button>
  <button id="retornar" class="btn btn-warning hidden" type="button">RETORNAR</button>
  <button id="continuar" class="btn btn-success hidden" type="button">CONTINUAR</button>
  <button id="finalizar" class="btn btn-success hidden" type="button">FINALIZAR</button>
  <button id="finalizarcadastro" class="btn btn-success hidden" type="button">FINALIZAR CADASTRO</button>
</div><!--/.modal-footer-->


<!-- Javascripts -->
<script type="text/javascript" src="assets/javascript/jquery.mask.js"></script>
<script type="text/javascript" src="javascripts/checkout.js"></script>
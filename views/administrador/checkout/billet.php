<div class="modal-loading">
  	<div class="col-md-12 text-center">
	    <div class="loading">
	        <img src="assets/images/common/loading.gif" width="38">
	        <p>Aguarde, processando...</p>
	    </div>
  	</div>
</div><!-- /.modal-loading -->

<div class="modal-header hidden">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    	<span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">2ª via de pagamento</h4> 
</div>
<div class="modal-body hidden">

	<div id="errorModal" class="hidden">
        <div class="alert alert-warning">
            <p></p>
        </div>
    </div>

    <div id="successModal" class="hidden">
        <div class="alert alert-success">
            <p></p>
        </div>
    </div>

    <form id="formPagamento" name="formPagamento">
        <fieldset class="m-b-10">
            <legend>Informações do pagamento</legend>
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nome" class="control-label">Nome:</label>
                        <span id="nome" class="dados"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="email" class="control-label">E-mail:</label>
                        <span id="email" class="dados"></span>
                    </div>
                </div>
                 <div class="col-md-12">
                    <div class="form-group">
                        <label for="cpf" class="control-label">CPF:</label>
                        <span id="cpf" class="dados"></span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Ingresso<abbr>*</abbr></label>
                        <select id="ingresso" name="ingresso" class="form-control input-sm">
                           <option value="" disabled selected>Lote</option>
                        </select>
                    </div>
                </div>

            </div>
        </fieldset>
    </form>
    
</div>
<div class="modal-footer hidden">
    <button id="enviarBoleto" class="btn btn-success btn-sm" type="button">
        <span class="btn-label"><i class="icon-paper-plane"></i></span>Enviar
    </button>
    <button type="button" id="fechar" class="btn btn-sm btn-default hidden" 
        data-dismiss="modal">Fechar</button>
</div>

<!-- javascripts -->
<script type="text/javascript" src="javascripts/administrador/checkout/billet.js"></script>
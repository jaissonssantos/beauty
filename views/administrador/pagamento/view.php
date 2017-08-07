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
    <h4 class="modal-title">Detalhes</h4> 
</div>
<div class="modal-body hidden">
    <form id="formPagamento">
	    <fieldset class="m-b-10">
		    <legend>Informações do pagamento</legend>
		    <div class="row">
		    	<div class="col-md-12">
			        <div class="form-group">
			            <label class="control-label">Código:</label>
			            <span id="codigo" class="dados"></span>
			        </div>
		        </div>
		        <div class="col-md-6">
			        <div class="form-group">
			            <label class="control-label">Método:</label>
			            <span id="metodo" class="dados"></span>
			        </div>
		        </div>
		        <div class="col-md-6">
			        <div class="form-group">
			            <label class="control-label">Ingresso:</label>
			            <span id="ingresso" class="dados"></span>
			        </div>
		        </div>
		    </div>
		    <div class="row">
		        <div class="col-md-6">
			        <div class="form-group">
			            <label class="control-label">Valor:</label>
			            <span id="valor" class="dados"></span>
			        </div>
		        </div>
		        <div class="col-md-6">
			        <div class="form-group">
			            <label class="control-label">Status:</label>
			            <span id="status" class="dados"></span>
			        </div>
		        </div>
		        <div class="col-md-12">
			        <div class="form-group">
			            <label class="control-label">Data:</label>
			            <span id="data" class="dados"></span>
			        </div>
		        </div>
		    </div>
		</fieldset>
		<fieldset class="m-b-10">
		    <legend>Informações do cliente</legend>
		    <div class="row">
		    	<div class="col-md-12">
			        <div class="form-group">
			            <label class="control-label">Nome:</label>
			            <span id="nome" class="dados"></span>
			        </div>
		        </div>
		        <div class="col-md-6">
			        <div class="form-group">
			            <label class="control-label">Crachá:</label>
			            <span id="cracha" class="dados bg-cracha"></span>
			        </div>
		        </div>
		        <div class="col-md-6">
			        <div class="form-group">
			            <label class="control-label">E-mail:</label>
			            <span id="email" class="dados"></span>
			        </div>
		        </div>
		        <div class="col-md-4">
			        <div class="form-group">
			            <label class="control-label">Telefone:</label>
			            <span id="telefone" class="dados"></span>
			        </div>
		        </div>
		        <div class="col-md-4">
			        <div class="form-group">
			            <label class="control-label">CPF:</label>
			            <span id="cpf" class="dados"></span>
			        </div>
		        </div>
		        <div class="col-md-4">
			        <div class="form-group">
			            <label class="control-label">Sexo:</label>
			            <span id="sexo" class="dados"></span>
			        </div>
		        </div>
		    </div>
		    <div class="row">
		        <div class="col-md-6">
			        <div class="form-group">
			            <label class="control-label">Pais de origem:</label>
			            <span id="pais" class="dados"></span>
			        </div>
		        </div>
		        <div class="col-md-6">
			        <div class="form-group">
			            <label class="control-label">Cidade:</label>
			            <span id="cidade" class="dados"></span>
			        </div>
		        </div>
		    </div>
		</fieldset>
    </form>
</div>
<div class="modal-footer hidden">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fechar</button>
</div>

<!-- javascripts -->
<script type="text/javascript" src="javascripts/administrador/pagamento/get.js"></script>
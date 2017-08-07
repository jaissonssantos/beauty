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
    <form id="formLote">
		<fieldset class="m-b-10">
		    <div class="row">
		    	<div class="col-md-12">
			        <div class="form-group">
			            <label class="control-label">Nome:</label>
			            <span id="nome" class="dados"></span>
			        </div>
		        </div>
		        <div class="col-md-4">
			        <div class="form-group">
			            <label class="control-label">Status:</label>
			            <span id="status" class="dados"></span>
			        </div>
		        </div>
		    </div>
		    <div class="row">
			    <div class="col-md-12">
			        <div class="table-responsive">
			        	<table id="table-results" class="table hidden">
	                        <thead>
	                          <tr>
	                            <th>#</th>
	                            <th>Nome</th>
	                            <th class="text-center">Qtd</th>
	                            <th class="text-center">Valor</th>
	                            <th class="text-center"></th>
	                          </tr>
	                        </thead>
	                        <tbody>
	                        </tbody>
	                    </table>
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
<script type="text/javascript" src="javascripts/administrador/lote/get.js"></script>
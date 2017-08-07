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

    <div class="row">
	    <div class="col-md-12">
	        <button id="btn-imprimir" 
	            class="btn btn-info btn-block"> 
	            <i class="icon-printer m-r-5"></i> <span>Imprimir boleto</span>
	        </button>
	    </div>
    </div>
    
</div>
<div class="modal-footer hidden">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fechar</button>
</div>

<!-- javascripts -->
<script type="text/javascript" src="javascripts/office/checkout/billet.js"></script>
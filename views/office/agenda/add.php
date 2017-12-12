<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" id="exampleModalLabel1">Adicionar agendamento</h4> 
</div>
<div class="modal-body">

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

    <form id="formAdd">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="atual" class="control-label">Cliente:</label>
                    <input type="text" class="form-control" id="cliente" name="cliente"> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="data" class="control-label">Data:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="data" name="data"> 
                        <span class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>    
            <div class="col-md-4">
                <label for="data" class="control-label">Horário:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="horario" name="horario"> 
                    <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-9">
                  <small ng-bind="** Este serviço finaliza às 09h30"></small>
                </div>
                <div class="col-md-3 text-right">
                  <a href="javascript:;">Adicionar nota</a>
                  <a href="javascript:;">Ocultar nota</a>
                </div>
            </div>
            <div class="form-group">
                <label for="confirmasenha" class="control-label">Confirmar senha:</label>
                <input type="password" class="form-control" id="confirmasenha" name="confirmasenha"> 
            </div>
        </div><!-- ./row-->
    </form>
</div>
<div class="modal-footer">
    <button type="button" id="salvar" class="btn btn-sm btn-success">Salvar</button>
</div>

<!-- javascripts -->
<!-- <script type="text/javascript" src="assets/javascript/jquery.validate.min.js"></script>
<script type="text/javascript" src="javascripts/office/artista/password.js"></script> -->
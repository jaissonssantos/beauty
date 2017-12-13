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

    <form id="formAdd" name="formAdd">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="atual" class="control-label">Cliente<abbr>*</abbr></label>
                    <input type="text" class="form-control" id="cliente" name="cliente"> 
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="servico" class="control-label">Serviço<abbr>*</abbr></label>
                    <input type="text" class="form-control" id="servico" name="servico" disabled value="Pés"> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="data" class="control-label">Data</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="data" name="data" disabled> 
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="col-md-4">
                <div class="form-group">
                    <label for="hora" class="control-label">Horário</label>
                    <input type="text" class="form-control" id="hora" name="hora" disabled> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="duracao" class="control-label">Duração<abbr>*</abbr></label>
                    <select id="duracao" name="duracao" class="form-control">
                        <option>0h15min</option>
                    </select>
                </div>
            </div>

            <div class="col-md-9">
                <div class="form-group">
                  <small>** Este serviço finaliza às <span id="finaliza"></span></small>
                </div>
            </div>
            <div class="col-md-3 text-right">
                  <a href="javascript:;" id="action-note">Adicionar nota</a>
                </div>
            </div>

            <div id="note" class="col-md-12 hidden">
                <div class="form-group">
                    <label for="nota" class="control-label">Nota</label>
                    <textarea id="nota" 
                          name="nota" 
                          class="form-control"
                          rows="2">
                    </textarea>
                </div>
            </div>
        </div><!-- ./row-->
    </form>
</div>
<div class="modal-footer">
    <button type="button" id="salvar" class="btn btn-sm btn-success">Salvar</button>
</div>

<!-- javascripts -->
<script type="text/javascript" src="assets/javascript/jquery.validate.min.js"></script>
<script type="text/javascript" src="javascripts/office/agenda/add.js"></script>
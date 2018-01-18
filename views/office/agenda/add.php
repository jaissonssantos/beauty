<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" id="exampleModalLabel1">Novo compromisso</h4> 
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
            <div class="col-md-4">
                <div class="form-group">
                    <label for="data" class="control-label">Data</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="data" name="data" readonly> 
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-8">
                <div class="form-group autocomplete">
                    <label for="atual" class="control-label">Cliente<abbr>*</abbr></label>
                    <input type="text" class="form-control" id="cliente" name="cliente" autocomplete="off" data-provide="typeahead">
                    <div class="loading hidden">
                        <img src="assets/images/common/loading.gif">
                    </div>
                    <a href="javascript:;" id="alterar-cliente" class="btn-absolute hidden">Alterar cliente</a>
                    <a href="javascript:;" id="novo-cliente" class="btn-absolute">+ Novo cliente</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="square" id="reservas">
                    <div class="card" id="reserva">
                    
                        <div class="form-group">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="servico" class="control-label">Serviço<abbr>*</abbr></label>
                                    <select id="servico" name="servico[]" class="form-control">
                                        <option>Nome do serviço</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hora" class="control-label">Horário<abbr>*</abbr></label>
                                    <select class="form-control" id="hora" name="hora[]"></select>
                                    <small>Finaliza às <span id="finaliza"></span></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="duracao" class="control-label">Duração<abbr>*</abbr></label>
                                    <select id="duracao" name="duracao[]" class="form-control">
                                        <option>0h00min</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr/>
                        </div>

                        <div class="col-md-4">
                            <div class="price">
                                <span class="title">Preço:</span>
                                <span class="money">R$0,00</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div id="ps" class="ps hidden">
                                <p class="text-danger text-right">*** Atenderá fora do horário de atendimento</p>
                            </div>
                            <div class="square-pre-loading pull-right hidden">
                                <img src="assets/images/common/loading.gif">
                            </div>
                            <button type="button" id="excluir" 
                                class="btn btn-sm btn-danger pull-right hidden">
                                Excluir       
                            </button>
                        </div>

                    </div><!-- ./row -->
                </div>
            </div>

            <div id="note" class="col-md-12 hidden">
                <div class="form-group">
                    <label for="nota" class="control-label">Nota</label>
                    <textarea id="nota" 
                          name="nota" 
                          class="form-control"
                          rows="2"></textarea>
                </div>
            </div>

        </div><!-- ./row-->

        <div class="row" id="row-new-add">
            <div class="col-md-12">
                <div class="new-add">
                    <a href="javascript:;" id="add">+ Adicionar outra reserva</a>
                </div>
            </div>
        </div><!-- ./row-->

    </form>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-6">
            <button type="button" id="action-note" 
                class="btn btn-sm btn-default pull-left">+ Nota</button>
        </div>
        <div class="col-md-6">
            <button type="button" id="salvar" 
                class="btn btn-sm btn-success">Salvar</button>
        </div>
    </div>
</div>

<!-- javascripts -->
<script type="text/javascript" src="assets/javascript/jquery.autocomplete.min.js"></script>
<script type="text/javascript" src="assets/javascript/jquery.validate.min.js"></script>
<script type="text/javascript" src="javascripts/office/agenda/add.js"></script>
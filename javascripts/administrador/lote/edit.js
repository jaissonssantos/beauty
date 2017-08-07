//variable global
var lotes = {};
var remove = []; 

$(document).ready(function(){

    //validate
    $('form#formLote').validate({
        rules: {
            nome: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            nome: { 
                required: 'Preencha o nome do lote',
                minlength: 'O nome do lote deve ter 5 caracteres'
            }
        },
        highlight: function (element, errorClass, validClass) {
            if (element.type === "radio") {
                this.findByName(element.name).addClass(errorClass).removeClass(validClass);
                $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
            } else {
                $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                $(element).closest('.form-group').find('i.fa').remove();
                $(element).closest('.form-group').append('<i class="fa fa-times fa-validate form-control-feedback fa-absolute"></i>');
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            if (element.type === "radio") {
                this.findByName(element.name).removeClass(errorClass).addClass(validClass);
            } else {
                $(element).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
                $(element).closest('.form-group').find('i.fa').remove();
                $(element).closest('.form-group').append('<i class="fa fa-check fa-validate form-control-feedback fa-absolute"></i>');
            }
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.attr("type") == "radio") {
                error.insertAfter(element.parent().parent());
            }else{
                error.insertAfter(element);
            }
        }
    });

    function get(){
        var params = {
            id: $('#id').val()
        };
        params = JSON.stringify(params);

        //list
        app.util.getjson({
            url : "/controller/administrador/lote/get",
            method : 'POST',
            contentType : "application/json",
            data: params,
            success: function(response){
                if(response.id){
                    //set
                    lotes = response;
                    $('#editName').html(response.nome);
                    $('#nome').val(response.nome);

                    //itens
                    for (var i=0;i<response.ingresso.length;i++) {
                        var item = $('div#item:first').clone();
                        item.attr('data-id',i);
                        item.find('.form-group').removeClass('has-success has-feedback');
                        item.find('.form-group i').remove();
                        item.find('#ingressoId').val(response.ingresso[i].id);
                        item.find('#ingressoNome').val(response.ingresso[i].nome);
                        item.find('#ingressoQtd').val(response.ingresso[i].qtd);
                        item.find('#ingressoValor').val(response.ingresso[i].valor);
                        item.find('#ingressoValor').unmask().mask('#.##0,00', {reverse: true});
                        if(i >= 1){
                            item.find('button#item-excluir').removeClass('hidden');
                            item.find('button#item-duplicar').removeClass('hidden');
                        }
                        $('#itens').append(item)
                    }
                    //remove first item
                    $('div#item:first').remove();

                    //hidden
                    $('#form-loading').addClass('hidden');
                    $('#form').removeClass('hidden');
                }else{
                    window.location.href = "/404";
                }

            },
            error : function(response){
                window.location.href = "/404";
            }
        });
    }

    //save
    $('button#salvar').livequery('click',function(event){
        if($("form#formLote").valid()){

            $('button#salvar').html('Processando...');
            $('button#salvar').prop("disabled",true);
            $('button#cancelar').prop("disabled",true);

            app.util.getjson({
                url : "/controller/administrador/lote/update",
                method : 'POST',
                data: $("form#formLote").serialize(),
                success: function(response){
                    if(response.success){
                        setSession('success', response.success);
                        window.location.href = "/administrador/lote";
                    }
                },
                error : function(response){
                    response = JSON.parse(response.responseText);
                    $('#error').removeClass('hidden');
                    $('#error').find('.alert p').html(response.error);
                    $('button#salvar').html('Salvar');
                    $('button#salvar').prop("disabled",false);
                    $('button#cancelar').prop("disabled",false);
                }
            });
        }else{
            $("form#formLote").valid();
        }
        return false;
    });

    //add
    $('button#add').livequery('click',function(event){
        var item = $('div#item:last').clone();
        $('#itens').append(item)

        var count = $('div#item').length;
        var item = $('div#item:last');
        item.attr('data-id',count);
        item.find('.form-group').removeClass('has-success has-feedback');
        item.find('.form-group i').remove();
        item.find('#ingressoId').val('');
        item.find('#ingressoNome').val('');
        item.find('#ingressoQtd').val('');
        item.find('#ingressoValor').val('');
        item.find('#ingressoValor').unmask().mask('#.##0,00', {reverse: true});
        item.find('button#item-excluir').removeClass('hidden');
        item.find('button#item-duplicar').removeClass('hidden');
        return false;
    });

    //duplicate
    $('button#item-duplicar').livequery('click',function(event){
        var item = $(this).parents('div#item').clone();
        $('#itens').append(item);

        var count = $('div#item').length;
        var item = $('div#item:last')
        item.attr('data-id',count);
        item.find('.form-group').removeClass('has-success has-feedback');
        item.find('.form-group i').remove();
        item.find('#ingressoValor').unmask().mask('#.##0,00', {reverse: true});
    });

    //remove
    $('button#item-excluir').livequery('click',function(event){
        var item =  $(this).parents('#item').find('input#ingressoId').val();
        remove.push(item);
        var input = $("<input>").attr("type", "hidden").attr("name", "removeId[]").val(remove);
        $('#itens-remove').append($(input));

        //remove block well
        $(this).parents('#item').remove();
    });

    //cancel
    $('button#cancelar').livequery('click',function(event){
        window.location.href = "/administrador/lote/";
        return false;
    });

	function onError(response) {
      console.log(response);
    }

    //init
    get();

});
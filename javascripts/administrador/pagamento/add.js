//variable global
var search = undefined;
var page = 1;
var offset = 0;
var limit = 10;
var status = 99;

$(document).ready(function(){

    //validate
    $('form#formPagamento').validate({
        rules: {
            pesquisa: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            pesquisa: { 
                required: 'Preencha sua pesquisa',
                minlength: 'Pesquisa mínimo de 3 caracteres'
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

    function checkSuccess(){
        //success
        if(getSession('success')){
            $('#success').removeClass('hidden');
            $('#success').find('p').html(getSession('success'));
        }
        setTimeout(function() {
            $('#success').addClass('hidden');
            destroySession('success');
        }, 5000);
    }

    function list(reload = false, search = undefined, status = 1){
        var params = (search == undefined) ? 
                        {offset: offset, limit: limit, status: status} : 
                        {offset: offset, limit: limit, status: status, search: search};
        params = JSON.stringify(params);

        if(reload){
            $('#table-loading').removeClass('hidden');
            $('#table-info').addClass('hidden');
        }

        //list
        app.util.getjson({
            url : "/controller/administrador/pagamento/list",
            method : 'POST',
            contentType : "application/json",
            data: params,
            success: function(response){
                var html = '';
                for (var i=0;i<response.results.length;i++) {
                    var status, metodo, link = undefined;
                    switch(parseInt(response.results[i].metodo)){
                        case 1:
                            metodo = '<i class="fa fa-credit-card"></i>';
                        break;
                        case 2:
                            metodo = '<i class="fa fa-barcode"></i>';
                        break;
                        case 3:
                            metodo = '<i class="fa fa-credit-card-alt"></i>';
                        break;
                        default:
                            metodo = '-';
                        break;
                    }
                    switch(parseInt(response.results[i].status)){
                        case 1:
                            status = 'Aguardando pgto';
                            labelStatus = 'label-warning';
                        break;
                        case 2:
                            status = 'Em análise';
                            labelStatus = 'label-warning';
                        break;
                        case 3:
                            status = 'Paga';
                            labelStatus = 'label-success';
                        break;
                        case 7:
                            status = 'Cancelada';
                            labelStatus = 'label-danger';
                        break;
                    }
                    if(response.results[i].link != undefined && response.results[i].status != 3){
                        link = '<a id="receber" href="javascript:;" data-codigo="'+ response.results[i].codigo +'">Receber</a>';
                    }else{
                        link = '<a href="javascript:;">-</a>';
                    }

                    html += '<tr>'+
                                '<td>'+ response.results[i].id + '</td>'+
                                '<td>'+ response.results[i].cliente + '</td>'+
                                '<td>'+ response.results[i].cpf + '</td>'+
                                '<td>'+ response.results[i].ingresso + '</td>'+
                                '<td>'+ floatToMoney(response.results[i].valor, 'R$') + '</td>'+
                                '<td class="text-center">'+ metodo +'</td>'+
                                '<td><span class="label '+labelStatus+'">'+status+'</span></td>'+
                                '<td class="text-center">'+ link +'</td>'+
                            '</tr>';
                }
                if(parseInt(response.count.results) >= 1){

                    $('#col-legenda').removeClass('hidden');
                    $('#col-total').removeClass('hidden');
                    $('#pagination-length').html('Exibindo ' + response.results.length + ' de ' + response.count.results + ' registros');
                    
                    var pagination = paginator(limit,page,response.count.results);
                    $('#pagination').html(pagination);

                }
                if(parseInt(response.count.results) == 0){
                    $('#notfound').removeClass('hidden');
                    $('#notfound').html('Nenhum registro encontrado');
                    $('#table-results').addClass('hidden');
                    $('#col-legenda').addClass('hidden');
                }else{
                    $('#notfound').addClass('hidden');
                    $('#table-results').removeClass('hidden');
                    $("#table-results > tbody").html(html);
                }
                if(reload)
                    $('#table-loading').addClass('hidden');
            },
            error : onError
        });
    }

    //paginator
    $('#pagination li a').livequery('click',function(event){
        if(!$(this).parent().hasClass('disabled')){
            page = parseInt($(this).data('page'));
            offset = Math.ceil((page-1) * limit);
            if(search != undefined && search.length >= 3){
                list(true, search, status);
            }else{
                list(true);
            }
        }
        return false;
    });

    //search
    $('button#procurar').livequery('click',function(event){
        if($("form#formPagamento").valid()){
            search = $('form#formPagamento input#pesquisa').val();
            list(true, search, status);
        }else{
            $("form#formPagamento").valid();
        }
        return false;
    });

    //receber
    $('a#receber').livequery('click',function(event){
        var codigo = $(this).data('codigo');
        //params
        var params = {
            codigo: codigo
        }
        params = JSON.stringify(params);

        $(this).html('<img src="assets/images/common/loading.gif" style="height:22px;">');
        //status
        app.util.getjson({
            url : "/controller/administrador/pagamento/receive",
            method : 'POST',
            contentType : "application/json",
            data: params,
            success: function(response){
                if(response.success){
                    setSession('success', response.success);
                    list(true, search, status);
                    checkSuccess();
                }
            },
            error: onError()
        });
    });

    //cancel
    $('button#cancelar').livequery('click',function(event){
        window.location.href = "/administrador/pagamento/";
        return false;
    });

    function onError(response) {
      console.log(response);
    }

});
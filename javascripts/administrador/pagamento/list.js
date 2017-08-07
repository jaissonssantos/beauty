//variable global
var id = 0;
var search = undefined;
var page = 1;
var offset = 0;
var limit = 10;
var status = 3; //status (3) = paga
var clientes, results = {};

$(document).ready(function(){

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

    function list(reload = false, search = undefined, status = 3){
        var params = (search == undefined) ? 
                        {offset: offset, limit: limit, status: status} : 
                        {offset: offset, limit: limit, status: status, search: search};
        params = JSON.stringify(params);

        if(reload)
            $('#col-reload').removeClass('hidden');

        //remove all itens active
        $('.nav .nav-item a').removeClass('active');
        switch(parseInt(status)){
            case 1: 
                $('a#aguardando').addClass('active');
            break;
            case 2: 
                $('a#analise').addClass('active');
            break;
            case 3: 
                $('a#paga').addClass('active');
            break;
            case 7: 
                $('a#cancelada').addClass('active');
            break;
        }

        //list
        app.util.getjson({
            url : "/controller/administrador/pagamento/list",
            method : 'POST',
            contentType : "application/json",
            data: params,
            success: function(response){
                var html = '';
                //set results
                results = response.results;
                for (var i=0;i<response.results.length;i++) {
                    var metodo, link, segundavia = undefined;
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
                    if(response.results[i].link != undefined && response.results[i].status != 3){
                        link = '<a href="'+ response.results[i].link +'" target="_blank" title="Link de pgto."><i class="ti-link"></a>';
                    }else{
                        link = '';
                    }   

                    if(response.results[i].status != 3){
                        segundavia = '<a href="javascript:;" id="pagar" data-id="'+ response.results[i].id + '" title="2° via de pagamento"><i class="icon-loop"></a>';
                    }else{
                        segundavia = '';
                    }

                    html += '<tr>'+
                                '<td>'+ response.results[i].id + '</td>'+
                                '<td>'+ response.results[i].created_at + '</td>'+
                                '<td>'+ response.results[i].cliente + '</td>'+
                                '<td>'+ response.results[i].cpf + '</td>'+
                                '<td>'+ response.results[i].ingresso + '</td>'+
                                '<td>'+ floatToMoney(response.results[i].valor, 'R$') + '</td>'+
                                '<td class="text-center">'+ metodo +'</td>'+
                                '<td class="text-center">'+ link +'</td>'+
                                '<td class="text-center">'+ segundavia +'</td>'+
                                '<td class="text-center"><a href="javascript:;" id="detalhar" data-id="'+ response.results[i].id + '"><i class="fa fa-search"></i></a></td>'+
                            '</tr>';
                }
                if(parseInt(response.count.results) >= 1){

                    $('#col-total').removeClass('hidden');
                    $('#col-search').removeClass('hidden');
                    $('#col-legenda').removeClass('hidden');
                    $('#col-action').addClass('hidden');
                    $('#pagination-length').html('Exibindo ' + response.results.length + ' de ' + response.count.results + ' registros');
                    
                    var pagination = paginator(limit,page,response.count.results);
                    $('#pagination').html(pagination);

                }
                if(parseInt(response.count.results) == 0){
                    $('#notfound').removeClass('hidden');
                    $('#notfound').html('Nenhum registro encontrado');
                    $('#table-results').addClass('hidden');
                    $('#col-total').addClass('hidden');
                    $('#col-search').removeClass('hidden');
                    $('#col-action').addClass('hidden');
                    $('#col-legenda').addClass('hidden');
                }else{
                    $('#notfound').addClass('hidden');
                    $('#table-results').removeClass('hidden');
                    $("#table-results > tbody").html(html);
                }
                $('#table-loading').addClass('hidden');
                $('#add').removeClass('hidden');
                $('ul.customtab').removeClass('hidden');
                $('#count-aguardando').html(response.count.aguardando);
                $('#count-analise').html(response.count.analise);
                $('#count-paga').html(response.count.paga);
                $('#count-cancelada').html(response.count.cancelada);
                if(reload)
                    $('#col-reload').addClass('hidden');
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
                list(true, undefined, status);
            }
        }
        return false;
    });

    //search
    $('input#search').livequery('keyup',function(event){
        search = $(this).val();
        if(search == undefined){
          return;
        }else{
            list(true, search, status);
        }
    });

    //set list tab item
    $('a#paga,a#aguardando,a#analise,a#cancelada').livequery('click',function(event){
        status = $(this).data('status');
        list(true, search, status);
    });

    //add form
    $('button.btn-add').livequery('click',function(event){
        window.location.href = "/administrador/pagamento/add";
    });

    //get
    $('a#detalhar').livequery('click',function(event){
        id =  $(this).data('id');

        var options = {
            cache:false,
            show: true,
            keyboard: false,
            backdrop: 'static'
        }
        $("div#modal").modal(options);

        //clear
        $('div#modal .modal-content').html('');

        $('div#modal .modal-content').load('views/administrador/pagamento/view.php');
        return false;
    });

    //segunda via
    $('a#pagar').livequery('click',function(event){
        id =  $(this).data('id');
        for(var i=0; i<results.length; i++){
            if(id == results[i].id){
                clientes = {
                    idingresso: results[i].idingresso,
                    nome: results[i].nome,
                    sobrenome: results[i].sobrenome,
                    cpf: results[i].cpf,
                    email: results[i].email,
                    codigo: results[i].codigo
                };
            }
        }

        var options = {
            cache:false,
            show: true,
            keyboard: false,
            backdrop: 'static'
        }
        $("div#modal").modal(options);

        //clear
        $('div#modal .modal-content').html('');

        $('div#modal .modal-content').load('views/administrador/checkout/billet.php');
        return false;
    });

    function onError(response) {
      console.log(response);
    }

    //init
    list();
    checkSuccess();

});
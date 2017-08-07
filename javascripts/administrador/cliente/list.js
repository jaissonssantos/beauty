//variable global
var id = 0;
var search = undefined;
var page = 1;
var offset = 0;
var limit = 10;
var status = 1; //status (1) = ativo

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

    function list(reload = false, search = undefined, status = 1){
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
                $('a#ativo').addClass('active');
            break;
            case 2: 
                $('a#inativo').addClass('active');
            break;
        }

        //list
        app.util.getjson({
            url : "/controller/administrador/cliente/list",
            method : 'POST',
            contentType : "application/json",
            data: params,
            success: function(response){
                var html = '';
                for (var i=0;i<response.results.length;i++) {
                    html += '<tr>'+
                                 '<td><input type="checkbox" class="checkItem" value="'+ response.results[i].id + '"></td>'+
                                '<td>'+ response.results[i].id + '</td>'+
                                '<td>'+ response.results[i].nome + ' ' + response.results[i].sobrenome + '</td>'+
                                '<td>'+ response.results[i].cpf + '</td>'+
                                '<td>'+ response.results[i].email + '</td>'+
                                '<td class="text-center">'+
                                    '<a href="/administrador/cliente/edit/'+ response.results[i].id +'" id="editar" class="m-r-10"><i class="fa fa-pencil"></i></a>'+
                                    '<a href="javascript:;" id="detalhar" data-id="'+ response.results[i].id + '"><i class="fa fa-search"></i></a>'+
                                '</td>'+
                            '</tr>';
                }
                if(parseInt(response.count.results) >= 1){

                    $('#col-total').removeClass('hidden');
                    $('#col-search').removeClass('hidden');
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
                }else{
                    $('#notfound').addClass('hidden');
                    $('#table-results').removeClass('hidden');
                    $("#table-results > tbody").html(html);
                }
                $('#table-loading').addClass('hidden');
                $('#add').removeClass('hidden');
                $('ul.customtab').removeClass('hidden');
                $('#count-ativos').html(response.count.ativos);
                $('#count-inativos').html(response.count.inativos);
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
    $('a#ativo,a#inativo').livequery('click',function(event){
        status = $(this).data('status');
        list(true, search, status);
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

        $('div#modal .modal-content').load('views/administrador/cliente/view.php');
        return false;
    });

    //check all list
    $('#checkAll').livequery('click',function(event){
        var count = 0;
        $(':checkbox.checkItem').prop('checked', this.checked);    
        var count = 0;
        $('.checkItem:checked').each(function(){
            if(this.checked)
                count++;
        })
        if(count >= 1){
            $('#col-action').removeClass('hidden');
        }else{
            $('#col-action').addClass('hidden');
        }
    });

    //check item
    $('.checkItem').livequery('change',function(event){
        var count = 0;
        $('.checkItem:checked').each(function(){
            if(this.checked)
                count++;
        })
        if(count >= 1){
            $('#col-action').removeClass('hidden');
        }else{
            $('#col-action').addClass('hidden');
        }
    });

    //setStatus
    $('a#setStatus').livequery('click',function(event){
        var status = $(this).data('status');
        var items = [];
        $('.checkItem:checked').each(function(){
            items.push($(this).val());
        });

        //params
        var params = {
            clientes: items,
            status: status
        }
        params = JSON.stringify(params);

        //status
        app.util.getjson({
            url : "/controller/administrador/cliente/setstatus",
            method : 'POST',
            contentType : "application/json",
            data: params,
            success: function(response){
                if(response.success){
                    setSession('success', response.success);
                    list();
                    checkSuccess();
                }
            },
            error: onError()
        });
    });

    function onError(response) {
      console.log(response);
    }

    //init
    list();
    checkSuccess();

});
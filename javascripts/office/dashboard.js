//variable global
var clientes, pagamentos = {};

$(document).ready(function(){

    function list(){
        //list
        app.util.getjson({
            url : "/controller/office/dashboard/list",
            method : 'POST',
            contentType : "application/json",
            success: function(response){
                if(response.id){
                    var telefone, sexo, status, labelStatus, metodo, segundaVia = undefined;
                    if (response.telefone == undefined) {
                        telefone = 'N/A';
                    }else{
                        telefone = response.telefone;
                    }

                    if (response.sexo == 'M') {
                        sexo = 'Masculino';
                    }else{
                        sexo = 'Feminino';
                    }

                    switch(parseInt(response.status)){
                        case 1:
                            status = 'Aguardando pgto';
                            labelStatus = 'label-warning';
                            segundaVia = true;
                        break;
                        case 2:
                            status = 'Em análise';
                            labelStatus = 'label-info';
                            segundaVia = true;
                        break;
                        case 3:
                            status = 'Paga';
                            labelStatus = 'label-success';
                            segundaVia = false;
                        break;
                        case 7:
                            status = 'Cancelada';
                            labelStatus = 'label-danger';
                            segundaVia = true;
                        break;
                    }

                    switch(parseInt(response.metodo)){
                        case 1:
                            metodo = 'Crédito';
                        break;
                        case 2:
                            metodo = 'Boleto';
                        break;
                        case 3:
                            metodo = 'Débito';
                        break;
                    }

                    $('p#cliente').html(response.cliente);   
                    $('p#cracha').html(response.cracha);
                    $('p#sexo').html(sexo);
                    $('p#cpf').html(response.cpf);
                    $('p#telefone').html(telefone);
                    $('p#email').html(response.email);
                    $('p#cidade').html(response.cidade);
                    $('p#pais').html(response.pais);
                    $('p#created_at').html(response.created_at);
                    $('p#login_at').html(response.login_at);
                    $('h5#lote').html(response.lote);
                    $('p#matricula').html(response.id);
                    $('p#transacao').html(response.codigo);
                    $('p#status').html('<span class="label '+labelStatus+'">'+status+'</span>');
                    $('p#ingresso').html(response.ingresso);
                    $('p#valor').html(response.valor);
                    $('p#metodo').html(metodo);
                    $('p#created_pay_at').html(response.created_pay_at);
                    $('p#updated_pay_at').html(response.updated_pay_at);
                    if(segundaVia)
                        $('button#btn-segundavia').removeClass('hidden');

                    //set 
                    clientes = response;
                    
                }
            },
            error : onError
        });
    }

    $('button#btn-segundavia').livequery('click',function(event){

        var options = {
            cache:false,
            show: true,
            keyboard: false,
            backdrop: 'static'
        }
        $("div#modal").modal(options);
        $('div#modal .modal-content').load('views/office/checkout/billet.php');
        return false;
    });

    //navegação abas
    $('a.nav-link').livequery('click',function(event){
        $('a.nav-link').removeClass('active');
        $(this).addClass('active');
    });

    function onError(response) {
      console.log(response);
    }

    //init
    list();

});
$(document).ready(function(){

	//get
	function get(){
		var params = {
            id: id //utilizando variavel global(list.js)
        };
        params = JSON.stringify(params);

	    app.util.getjson({
	        url : "/controller/administrador/pagamento/get",
	        method : 'POST',
	        contentType : "application/json",
	        data: params,
	        success: function(response){
	            if(response.id){
	            	var metodo, status, bgstatus, sexo, telefone = undefined;
                    switch(parseInt(response.metodo)){
                        case 1:
                            metodo = 'Cartão de crédito';
                        break;
                        case 2:
                            metodo = 'Boleto';
                        break;
                        case 3:
                            metodo = 'Cartão de débito';
                        break;
                        default:
                            metodo = '-';
                        break;
                    }

                    switch(parseInt(response.status)){
                        case 1:
                            status = 'Aguardando pgto';
                            bgstatus = 'bg-warning';
                        break;
                        case 2:
                            status = 'Em análise';
                            bgstatus = 'bg-info';
                        break;
                        case 3:
                            status = 'Paga';
                            bgstatus = 'bg-success';
                        break;
                        case 7:
                            status = 'Cancelada';
                            bgstatus = 'bg-danger';
                        break;
                    }

                    if(response.sexo == 'M'){
                    	sexo = 'Masculino';
                    }else{
                    	sexo = 'Feminino';
                    }

                    if(response.telefone == undefined){
                        telefone = 'N/A';
                    }else{
                        telefone = response.telefone;
                    }

	                //set
	                $('form#formPagamento span#codigo').html(response.codigo);
	                $('form#formPagamento span#metodo').html(metodo);
	                $('form#formPagamento span#ingresso').html(response.ingresso);
	                $('form#formPagamento span#valor').html(floatToMoney(response.valor, 'R$'));
	                $('form#formPagamento span#status').html(status);
	                $('form#formPagamento span#status').addClass(bgstatus);
	                $('form#formPagamento span#data').html(response.created_at);

	                $('form#formPagamento span#nome').html(response.cliente);
	                $('form#formPagamento span#cracha').html(response.cracha);
                    $('form#formPagamento span#email').html(response.email);
	                $('form#formPagamento span#telefone').html(telefone);
                    $('form#formPagamento span#cpf').html(response.cpf);
	                $('form#formPagamento span#sexo').html(sexo);
	                $('form#formPagamento span#pais').html(response.pais);
	                $('form#formPagamento span#cidade').html(response.cidade);

	                //hidden
	                $('.modal-loading').addClass('hidden');
	                $('.modal-header').removeClass('hidden');
	                $('.modal-body').removeClass('hidden');
	                $('.modal-footer').removeClass('hidden');
	            }
	        },
	        error : onError
	    });
	}

	function onError(response) {
      console.log(response);
    }

	//init
    get();

});
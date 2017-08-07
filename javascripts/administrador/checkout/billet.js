$(document).ready(function(){
	var senderHash = undefined;

	//set
    $('form#formPagamento span#nome').html(clientes.nome + ' ' + clientes.sobrenome);
    $('form#formPagamento span#email').html(clientes.email);
    $('form#formPagamento span#cpf').html(clientes.cpf);

	//lote
    app.util.getjson({
        url : "/controller/guest/lote/get",
        method : 'POST',
        contentType : "application/json",
        success: function(response){
        	var options = '<option value="" disabled selected>Lote</option>';
	        for (var i=0;i<response.results.length;i++) {
	        	options += '<optgroup label="'+response.results[i].nome+'">'
	        	for(var j=0;j<response.results[i].ingresso.length;j++){
        			options += '<option value="'+response.results[i].ingresso[j].id+'" data-value="'+response.results[i].ingresso[j].valor+'">'+ 
	        					response.results[i].ingresso[j].nome + ' - '  + floatToMoney(response.results[i].ingresso[j].valor,'R$')
	        				+'</option>';
	        	}
	        	options += '</optgroup>';
	    	}
	    	$("#ingresso").html(options);
        },
        error : onError
    });

	//get session checkout transparent
    app.util.getjson({
        url : "/controller/guest/checkout/getsession",
        method : 'POST',
        contentType : "application/json",
        success: function(response){
          if(response.results.id){
            session = response.results.id;
            PagSeguroDirectPayment.setSessionId(session);
            senderHash = PagSeguroDirectPayment.getSenderHash();
            //remove hidden
			$('.modal-loading').addClass('hidden');
			$('.modal-header').removeClass('hidden');
			$('.modal-body').removeClass('hidden');
			$('.modal-footer').removeClass('hidden');
          }
        },
        error : onError
    });

    $('button#enviarBoleto').livequery('click',function(event){
    	//params
        var params = {
			senderhash: senderHash,
			usuario: {
				ingresso: $('#ingresso').val(),
				nome: clientes.nome,
				sobrenome: clientes.sobrenome,
				cpf: clientes.cpf,
				email: clientes.email
			}
        };

        $('button#enviarBoleto').html('Processando...');
        $('button#enviarBoleto').prop("disabled",true);

        params = JSON.stringify(params);
        app.util.getjson({
			url : "/controller/guest/checkout/billet",
			method : 'POST',
			contentType : "application/json",
			data: params,
			success: function(response){
				if(response.results.codigo){
					//set pagamentos
					pagamentos = {
						codigo: response.results.codigo,
						status: response.results.status,
						descricao: response.results.descricao,
						metodo: response.results.metodo,
						valor: parseFloat(response.results.valor),
						link: response.results.link,
						codigoupdate: clientes.codigo //codigo de atualização da transação
					};

					//params
					params = JSON.stringify(pagamentos);

					//update
					app.util.getjson({
						url : "/controller/office/pagamento/update",
						method : 'POST',
						contentType : "application/json",
						data: params,
						success: function(response){
							if(response.success){
								//add hidden
								$('form#formPagamento').addClass('hidden');
								$('button#enviarBoleto').addClass('hidden');
								$('button#fechar').removeClass('hidden');
							
							    $('#successModal').find('.alert').append('<p>'+ response.success +'</p>');
	            				$('#successModal').removeClass('hidden');
							}
						},
						error(response){
							$('#errorModal').find('.alert').append('<p>'+ response.error +'</p>');
	            			$('#errorModal').removeClass('hidden');
	            			$('button#enviarBoleto').html('Enviar');
                    		$('button#enviarBoleto').prop("disabled",false);
						}
					});

				}
			},
			error: function(response){
				$('#errorModal').find('.alert').append('<p>Ocorreu um erro ao gerar o boleto, tente novamente</p>');
            	$('#errorModal').removeClass('hidden');

            	$('button#enviarBoleto').html('Enviar');
                $('button#enviarBoleto').prop("disabled",false);
			}
		});
		return false;
    });

    function onError(response) {
      console.log(response);
    }

});
$(document).ready(function(){
	var senderHash = undefined;
	var usuarios =	{
		ingresso: clientes.idingresso,
		nome: clientes.nome,
		sobrenome: clientes.sobrenome,
		cpf: clientes.cpf,
		email: clientes.email
	};

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
            //billet
            billet();
          }
        },
        error : onError
    });

    function billet(){
    	//params
        var params = {
          senderhash: senderHash,
          usuario: usuarios
        };

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
								//remove hidden
								$('.modal-loading').addClass('hidden');
								$('.modal-header').removeClass('hidden');
								$('.modal-body').removeClass('hidden');
								$('.modal-footer').removeClass('hidden');

							    $('#successModal').find('.alert').append('<p>'+ response.success +'</p>');
	            				$('#successModal').removeClass('hidden');
							}
						},
						error(response){
							$('#errorModal').find('.alert').append('<p>'+ response.error +'</p>');
	            			$('#errorModal').removeClass('hidden');
						}
					});

				}
			},
			error: function(response){
				$('#errorModal').find('.alert').append('<p>Ocorreu um erro ao gerar o boleto, tente novamente</p>');
            	$('#errorModal').removeClass('hidden');
			}
		});
    }

    $('button#btn-imprimir').livequery('click',function(event){
    	window.open(pagamentos.link);
    	return false;
    });

    function onError(response) {
      console.log(response);
    }

});
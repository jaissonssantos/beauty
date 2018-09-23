$(document).ready(function(){

	//get
	function get(){
		var params = {
            id: id //utilizando variavel global(list.js)
        };
        params = JSON.stringify(params);

	    app.util.getjson({
	        url : "/controller/administrador/cliente/get",
	        method : 'POST',
	        contentType : "application/json",
	        data: params,
	        success: function(response){
	            if(response.id){
	            	var telefone,sexo = undefined;
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
	                $('form#formCliente span#nome').html(response.cliente);
	                $('form#formCliente span#cracha').html(response.cracha);
	                $('form#formCliente span#telefone').html(telefone);
	                $('form#formCliente span#email').html(response.email);
	                $('form#formCliente span#cpf').html(response.cpf);
	                $('form#formCliente span#sexo').html(sexo);
	                $('form#formCliente span#pais').html(response.pais);
	                $('form#formCliente span#cidade').html(response.cidade);

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
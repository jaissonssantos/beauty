$.validator.addMethod( "checkcpf", function(value){

	var response = {};

	var params = {cpf: value};
    	params = JSON.stringify(params);

    response = $.ajax({ 
        async: false, 
        url: "/controller/guest/usuario/checkcpf",
        method: 'POST',
        contentType: "application/json",
        data: params,
     }); 

    response = JSON.parse(response.responseText);

    if(response.success){
		return false;
    }else{
    	return true;
    }

}, "CPF already in use" );

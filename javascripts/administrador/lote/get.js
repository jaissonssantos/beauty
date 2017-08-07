$(document).ready(function(){

	//get
	function get(){
		var params = {
            id: id //utilizando variavel global(list.js)
        };
        params = JSON.stringify(params);

	    app.util.getjson({
	        url : "/controller/administrador/lote/get",
	        method : 'POST',
	        contentType : "application/json",
	        data: params,
	        success: function(response){
	            if(response.id){
	            	var status, bgstatus = undefined;
                    if(response.status == 1){
                    	bgstatus = 'bg-success';
                    	status = 'Ativo';
                    }else{
                    	bgstatus = 'bg-success';
                    	status = 'Inativo';
                    }

	                //set
	                $('form#formLote span#nome').html(response.nome);
	                $('form#formLote span#status').html(status);
	                $('form#formLote span#status').addClass(bgstatus);

	                //table
	                var html = '';
	                for (var i=0;i<response.ingresso.length;i++) {
	                	var status, bgstatus = undefined;
	                    if(response.status == 1){
	                    	bgstatus = 'bg-success';
	                    	status = 'Ativo';
	                    }else{
	                    	bgstatus = 'bg-success';
	                    	status = 'Inativo';
	                    }
		                html += '<tr>'+
	                                '<td>'+ (i+1) + '</td>'+
	                                '<td>'+ response.ingresso[i].nome +'</td>'+
	                                '<td>'+ response.ingresso[i].qtd +'</td>'+
	                                '<td>'+ floatToMoney(response.ingresso[i].valor, 'R$') + '</td>'+
	                                '<td class="text-center"><span class="label '+bgstatus+'">'+status+'</span></td>'+
	                            '</tr>';
                    }
                    $("form#formLote #table-results").removeClass('hidden');
                    $("form#formLote #table-results > tbody").html(html);

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
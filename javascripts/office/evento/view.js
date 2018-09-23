//variable global
var projetos = {};

$(document).ready(function(){

	function get(){
        var params = {
            id: $('#id').val()
        };
        params = JSON.stringify(params);

        //list
        app.util.getjson({
            url : "/controller/office/evento/get",
            method : 'POST',
            contentType : "application/json",
            data: params,
            success: function(response){
                if(response.id){
                    //set
                    projetos = response;

                    $('#qrcode').attr('src', '/controller/'+response.qrcode);
                    $('#nome').html(response.nome);
                    $('#local').html(response.local);
                    $('#descricao').html(response.descricao);
                    $('#pais').html(response.pais);
                    switch(parseInt(response.faixa)){
                        case 1:
                            $('#faixa').html('$');
                        break;
                        case 2:
                            $('#faixa').html('$$');
                        break;
                        case 3:
                            $('#faixa').html('$$$');
                        break;
                        case 4:
                            $('#faixa').html('$$$$');
                        break;
                        case 5:
                            $('#faixa').html('$$$$$');
                        break;
                    }
                    switch(parseInt(response.pais)){
                        case 1:
                            $('#pais').html('Brazil');
                        break;
                        case 2:
                            $('#pais').html('Bolívia');
                        break;
                        case 3:
                            $('#pais').html('Peru');
                        break;
                    }
                    $('#data').html(response.data);
                    $('#termino').html(response.termino);

                    var html = '';
                    for (var i=0;i<response.imagem.length;i++) {

                        html += '<div class="col-md-3">'+
                                    '<img src="'+ response.imagem[i].imagem + '" class="img-responsive img-thumbnail">'+
                                '</div>';
                    }
                    $('#image').html(html);

                    console.log(html);

                    $('#form-loading').addClass('hidden');
                    $('#form').removeClass('hidden');
                }else{
                    //window.location.href = "/404";
                }
            },
            error : function(response){
                // window.location.href = "/404";
            }
        });

        //list
        // app.util.gethtml({
        //     url : "/controller/office/evento/qrcode",
        //     data: params,
        //     success: function(response){
        //         console.log(response);
        //         if(response){
        //             //set
        //             $('#qrcode').attr('src', response);
        //             $('#form-loading').addClass('hidden');
        //             $('#form').removeClass('hidden');
        //         }else{
        //             //window.location.href = "/404";
        //         }
        //     },
        //     error : function(response){
        //         // window.location.href = "/404";
        //     }
        // });
    }

    //cancel
    $('button#cancelar').on('click',function(event){
        window.location.href = "/office/evento/";
        return false;
    });

	function onError(response) {
      console.log(response);
    }

    //init
    get();
    //checkSuccess();


});
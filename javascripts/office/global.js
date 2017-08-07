$(document).ready(function(){

    //sair da conta
    $('a#sair').livequery('click',function(event){
        app.util.getjson({
            url : "/controller/guest/usuario/logout",
            method : 'POST',
            contentType : "application/json",
            success: function(response){
                if(response.success)
                    window.location.href = "/login";
            },
            error : onError
        });
        return false;
	});

    $('a#mudarsenha').livequery('click',function(event){

        var options = {
            cache:false,
            show: true,
            keyboard: false,
            backdrop: 'static'
        }
        $("div#modal").modal(options);
        $('div#modal .modal-content').load('views/office/cliente/password.php');
        return false;
    });

    function onError(response) {
      console.log(response);
    }

});
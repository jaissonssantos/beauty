//variable global
var usuarios = {};

$(document).ready(function(){

	$('ul.tabs a').livequery( "click", function(event){
		var tabnavs = $(this).attr('href');
        $(this).parent().parent().find('li a').removeClass('active');
        $(this).addClass('active');
        $('.flat-form .form-action').addClass('hide');
        $('.flat-form .form-action').removeClass('show');
        $('.flat-form '+tabnavs).addClass('show');
        return false;
	});

    function checktoken(){
        //params
        var params = {
                token: $('form#formReset #token').val()
        };
        params = JSON.stringify(params);

        app.util.getjson({
            url : "/controller/guest/usuario/checktoken",
            method : 'POST',
            contentType : "application/json",
            data: params,
            success: function(response){
                if(response.success){
                    $('.form-change').removeClass('hidden');
                    $('.loading').addClass('hidden');
                }
            },
            error : onError
        });
    }

    //validate cadastro
    $('form#formReset').validate({
        onfocusout: false,
        onkeyup: false,
        rules: {
            senha: { 
                required: true,
                minlength: 5
            },
            confirmasenha: { 
                required: true,
                equalTo: "#formReset #senha"
            }
        },
        messages: {
            senha: { 
                required: 'Preencha sua senha',
                minlength: 'Para sua segurança a senha deve ter no mínimo cinco caracteres'
            },
            confirmasenha: { 
                required: 'Vamos lá, confirme sua senha',
                equalTo: 'Pelo que estou vendo as senhas não coincidem, tente novamente'
            }
        },
        highlight: function (element, errorClass, validClass) {
            if (element.type === "radio") {
                this.findByName(element.name).addClass(errorClass).removeClass(validClass);
                $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
            } else {
                $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                $(element).closest('.form-group').find('i.fa').remove();
                $(element).closest('.form-group').append('<i class="fa fa-times fa-validate form-control-feedback"></i>');
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            if (element.type === "radio") {
                this.findByName(element.name).removeClass(errorClass).addClass(validClass);
            } else {
                $(element).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
                $(element).closest('.form-group').find('i.fa').remove();
                $(element).closest('.form-group').append('<i class="fa fa-check fa-validate form-control-feedback"></i>');
            }
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.attr("type") == "radio") {
                error.insertAfter(element.parent().parent());
            }else{
                error.insertAfter(element);
            }
        }
    });

    //salvar senha
    $('button#salvar').livequery('click',function(event){
        if($("form#formReset").valid()){
            usuarios = {
                token: $('form#formReset #token').val(),
                senha: $('form#formReset #senha').val()
            };

            $('button#salvar').html('PROCESSANDO...');
            $('button#salvar').prop("disabled",true);

            //params
            var params = {};
            params = JSON.stringify(usuarios);

            app.util.getjson({
                url : "/controller/guest/usuario/password-change",
                method : 'POST',
                contentType : "application/json",
                data: params,
                success: function(response){
                    if(response.success && response.results){
                        switch(parseInt(response.results.gestor)){
                            case 0:
                                window.location.href = "/office/dashboard";
                                break;
                            case 1:
                                window.location.href = "/administrador/dashboard";    
                                break;
                        }
                    }
                },
                error : function(response){
                    response = JSON.parse(response.responseText);
                    $('#errorPassword').removeClass('hidden');
                    $('#errorPassword').find('.alert p').html(response.error);
                    $('button#salvar').html('SALVAR');
                    $('button#salvar').prop("disabled",false);
                }
            });
        }else{
            $("form#formReset").valid();
        }
        return false;
    });

	function onError(response) {
      console.log(response);
    }

    //init
    checktoken();

});
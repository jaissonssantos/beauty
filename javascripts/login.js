$(document).ready(function(){

    //validate login
    $('form#formLogin').validate({
        rules: {
            email: {
                required: true, 
                email: true
            },
            senha: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            email: { 
                required: 'Preencha seu endereço de e-mail', 
                email: 'Ops, tem certeza que é um email válido?'
            },
            senha: {
                required: 'Preencha sua senha',
                minlength: 'Para sua segurança a senha foi cadastrada com no mínimo cinco caracteres'
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

    $('form#formLogin').submit(function(event){
        if($("form#formLogin").valid()){
            usuarios = {
                email: $('form#formLogin #email').val(),
                senha: $('form#formLogin #senha').val()
            };

            $('button#entrar').html('PROCESSANDO...');
            $('button#entrar').prop("disabled",true);

            //params
            var params = {};
            params = JSON.stringify(usuarios);

            app.util.getjson({
                url : "/controller/guest/usuario/login",
                method : 'POST',
                contentType : "application/json",
                data: params,
                success: function(response){
                    if(response.results.id){
                        window.location.href = "/office/dashboard";
                    }
                },
                error : function(response){
                    response = JSON.parse(response.responseText);
                    $('#error').removeClass('hidden');
                    $('#error').find('p').html(response.error);
                    $('button#entrar').html('Entrar');
                    $('button#entrar').prop("disabled",false);
                }
            });
        }else{
            $("form#formLogin").valid();
        }
        return false;
    });

	function onError(response) {
      console.log(response);
    }

});
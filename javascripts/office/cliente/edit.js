//variable global
var clientes = {};

$(document).ready(function(){

    //mask
    $("#telefone").mask("(00) 0000-00009");

    function checkSuccess(){
        //success
        if(getSession('success')){
            $('#success').removeClass('hidden');
            $('#success').find('p').html(getSession('success'));
        }
        setTimeout(function() {
            $('#success').addClass('hidden');
            destroySession('success');
        }, 5000);
    }

    //validate
    $('form#formCliente').validate({
        onfocusout: false,
        onkeyup: false,
        rules: {
            nome: {
                required: true,
                minlength: 5
            },
            sexo: { 
                required: true
            },
            pais: { 
                required: true
            },
            estado: { 
                required: true
            },
            cidade: { 
                required: true
            }
        },
        messages: {
            nome: { 
                required: 'Preencha o nome de usuário',
                minlength: 'Vamos lá o nome de usuário deve ter cinco caracteres'
            },
            sexo: { 
                required: 'Qual o seu sexo?'
            },
            pais: { 
                required: 'Qual seu pais de origem?'
            },
            estado: { 
                required: 'Qual estado você reside?'
            },
            cidade: { 
                required: 'Falta pouco, qual cidade você reside?'
            }
        },
        highlight: function (element, errorClass, validClass) {
            if (element.type === "radio") {
                this.findByName(element.name).addClass(errorClass).removeClass(validClass);
                $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
            } else {
                $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                $(element).closest('.form-group').find('i.fa').remove();
                $(element).closest('.form-group').append('<i class="fa fa-times fa-validate form-control-feedback fa-absolute"></i>');
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            if (element.type === "radio") {
                this.findByName(element.name).removeClass(errorClass).addClass(validClass);
            } else {
                $(element).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
                $(element).closest('.form-group').find('i.fa').remove();
                $(element).closest('.form-group').append('<i class="fa fa-check fa-validate form-control-feedback fa-absolute"></i>');
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

    function get(){
        var params = {
            id: $('#id').val()
        };
        params = JSON.stringify(params);

        //list
        app.util.getjson({
            url : "/controller/office/cliente/get",
            method : 'POST',
            contentType : "application/json",
            data: params,
            success: function(response){
                if(response.id){
                    //set
                    clientes = response;
                    $('#editName').html(response.cliente);
                    $('#nome').val(response.nome);
                    $('#sobrenome').val(response.sobrenome);
                    $('#cpf').val(response.cpf);
                    $('#cracha').val(response.cracha);
                    $('#email').val(response.email);
                    $('#telefone').val(response.telefone);
                    $( "#sexo option" ).each(function(){
                        if($(this).val() == response.sexo)
                            $(this).attr('selected', true);
                    });
                    $('#form-loading').addClass('hidden');
                    $('#form').removeClass('hidden');
                }else{
                    window.location.href = "/404";
                }

                //pais de origem
                app.util.getjson({
                    url : "/controller/guest/estadocidade/getpais",
                    method : 'POST',
                    contentType : "application/json",
                    success: function(response){
                        var options = '<option value="" disabled selected>Pais</option>';
                        for (var i=0;i<response.results.length;i++) {
                            selected = (i==0) ? 'selected' : '';
                            options += '<option value="'+response.results[i].id+'" '+selected+'>'+ response.results[i].nome+'</option>';
                        }
                        $("#pais").html(options);
                    },
                    error : onError
                });

                //estado
                app.util.getjson({
                    url : "/controller/guest/estadocidade/getestado",
                    method : 'POST',
                    contentType : "application/json",
                    success: function(response){
                        var options = '<option value="" disabled selected>Estado</option>';
                        for (var i=0;i<response.results.length;i++) {
                            selected = ((i+1)==clientes.idestado) ? 'selected="selected"' : '';
                            options += '<option value="'+response.results[i].id+'" '+selected+'>'+ response.results[i].nome+'</option>';
                        }
                        if(clientes.idestado != undefined)
                            $('select#estado').trigger('change');
                        $("#estado").html(options);
                    },
                    error : onError
                });

                //cidade
                $('select#estado').change(function(){
                    var params = {
                        estado: ($(this).val() != undefined) ? $(this).val() : clientes.idestado 
                    };
                    params = JSON.stringify(params);
                    var options = '<option value="" disabled selected>Carregando...</option>';
                    $("#cidade").html(options);
                    app.util.getjson({
                        url : "/controller/guest/estadocidade/getcidade",
                        method : 'POST',
                        contentType : "application/json",
                        data : params,
                        success: function(response){
                            options = undefined;
                            for (var i=0;i<response.results.length;i++) {
                                options += '<option value="'+response.results[i].id+'">'+ response.results[i].nome+'</option>';
                            }
                            $("#cidade").html(options);
                        },
                        error : onError
                    });
                });

            },
            error : function(response){
                window.location.href = "/404";
            }
        });
    }

    //edit
    $('button#salvar').livequery('click',function(event){
        if($("form#formCliente").valid()){
            clientes = {
                id: $('#id').val(),
                nome: $('#nome').val(),
                sobrenome: $('#sobrenome').val(),
                cracha: $('#cracha').val(),
                telefone: $('#telefone').val(),
                sexo: $('#sexo').val(),
                pais: $('#pais').val(),
                estado: $('#estado').val(),
                cidade: $('#cidade').val()
            };

            //params
            var params = {};
            params = JSON.stringify(clientes);

            $('button#salvar').html('Processando...');
            $('button#salvar').prop("disabled",true);
            $('button#cancelar').prop("disabled",true);

            app.util.getjson({
                url : "/controller/office/cliente/update",
                method : 'POST',
                contentType : "application/json",
                data: params,
                success: function(response){
                    if(response.success){
                        setSession('success', response.success);
                        window.location.href = "/office/cliente/edit/"+clientes.id;
                    }
                },
                error : function(response){
                    response = JSON.parse(response.responseText);
                    $('#error').removeClass('hidden');
                    $('#error').find('.alert p').html(response.error);
                    $('button#salvar').html('Salvar');
                    $('button#salvar').prop("disabled",false);
                    $('button#cancelar').prop("disabled",false);
                }
            });
        }else{
            $("form#formCliente").valid();
        }
        return false;
    });

    //cancel
    $('button#cancelar').livequery('click',function(event){
        window.location.href = "/office/cliente/";
        return false;
    });

	function onError(response) {
      console.log(response);
    }

    //init
    get();
    checkSuccess();

});
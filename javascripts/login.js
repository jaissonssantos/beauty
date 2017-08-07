//variable global
var usuarios = pagamentos = {};

$(document).ready(function(){

    //mask
    $("#telefone").mask("(00) 0000-00009");

	$('ul.tabs a').livequery( "click", function(event){
		var tabnavs = $(this).attr('href');
        $(this).parent().parent().find('li a').removeClass('active');
        $(this).addClass('active');
        $('.flat-form .form-action').addClass('hide');
        $('.flat-form .form-action').removeClass('show');
        $('.flat-form '+tabnavs).addClass('show');
        return false;
	});

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
                required: 'Preencha seu email', 
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

    //validate cadastro
    $('form#formCadastro').validate({
        onfocusout: false,
        onkeyup: false,
        rules: {
            nome: { 
                required: true, 
                minlength: 2
            },
            email: {
                required: true, 
                email: true,
                checkemail: true
            },
            cracha: { 
                required: true,
                minlength: 3
            },
            telefone: { 
                required: true
            },
            ingresso: { 
                required: true
            },
            sexo: { 
                required: true
            },
            cpf: { 
                required: true,
                cpfBR: true,
                checkcpf: true
            },
            deficiencia: { 
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
            },
            senha: { 
                required: true,
                minlength: 5
            },
            confirmasenha: { 
                required: true,
                equalTo: "#formCadastro #senha"
            }
        },
        messages: {
            nome: { 
                required: 'Qual o seu nome?', 
                minlength: 'Seu nome tem menos que duas letras?'
            },
            email: { 
                required: 'Preencha seu email', 
                email: 'Ops, tem certeza que é um email válido?',
                checkemail: 'Este endereço de E-mail está em uso, tente outro'
            },
            cracha: { 
                required: 'Como deseja ter seu nome no crachá?',
                minlength: 'Só aceitamos nomes superior a três letras'
            },
            telefone: { 
                required: 'Oi, precisamos do seu contato'
            },
            ingresso: { 
                required: 'Vamos lá, qual ingresso deseja adquirir?'
            },
            sexo: { 
                required: 'Qual o seu sexo?'
            },
            cpf: { 
                required: 'Preencha seu CPF',
                cpfBR: 'Este número de CPF é inválido',
                checkcpf: 'Este CPF está em uso, tente outro'
            },
            deficiencia: { 
                required: 'Possui alguma alguma deficiência?'
            },
            pais: { 
                required: 'Qual seu pais de origem?'
            },
            estado: { 
                required: 'Qual estado você reside?'
            },
            cidade: { 
                required: 'Falta pouco, qual cidade você reside?'
            },
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

    //validate password
    $('form#formReset').validate({
        rules: {
            email: {
                required: true, 
                email: true
            }
        },
        messages: {
            email: { 
                required: 'Preencha seu email', 
                email: 'Ops, tem certeza que é um email válido?'
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

	//deficiencia
    app.util.getjson({
        url : "/controller/guest/deficiencia/get",
        method : 'POST',
        contentType : "application/json",
        success: function(response){
            var options = '<option value="" disabled selected>Deficiência</option>';
            for (var i=0;i<response.results.length;i++) {
                selected = (i==0) ? 'selected' : undefined;
                options += '<option value="'+response.results[i].id+'" '+selected+'>'+ response.results[i].nome+'</option>';
            }
            $("#deficiencia").html(options);
        },
        error : onError
    });

    //pais de origem
	app.util.getjson({
        url : "/controller/guest/estadocidade/getpais",
        method : 'POST',
        contentType : "application/json",
        success: function(response){
        	var options = '<option value="" disabled selected>Pais</option>';
	        for (var i=0;i<response.results.length;i++) {
                selected = (i==0) ? 'selected' : undefined;
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
		        options += '<option value="'+response.results[i].id+'">'+ response.results[i].nome+'</option>';
	    	}
	    	$("#estado").html(options);
        },
        error : onError
    });

    //cidade
    $('select#estado').change(function(){
    	var params = {estado: $(this).val()};
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

    //save
    $('button#salvar').livequery('click',function(event){
        if($("form#formCadastro").valid()){
            usuarios = {
                nome: $('form#formCadastro #nome').val(),
                sobrenome: $('form#formCadastro #sobrenome').val(),
                cracha: $('form#formCadastro #cracha').val(),
                telefone: $('form#formCadastro #telefone').val(),
                email: $('form#formCadastro #email').val(),
                ingresso: $('form#formCadastro #ingresso').val(),
                valor: $('form#formCadastro #ingresso option:selected').attr('data-value') != undefined ? $('form#formCadastro #ingresso option:selected').attr('data-value') : 0.00,
                sexo: $('form#formCadastro #sexo:checked').val(),
                cpf: $('form#formCadastro #cpf').val(),
                deficiencia: $('form#formCadastro #deficiencia').val(),
                pais: $('form#formCadastro #pais').val(),
                cidade: $('form#formCadastro #cidade').val(),
                senha: $('form#formCadastro #senha').val()
            };

            $("#modal-checkout").modal({
                cache:false,
            	show: true,
                keyboard: false,
                backdrop: 'static',
                remote: '/views/checkout.php',
            });
        }else{
            $("form#formCadastro").valid();
        }
        return false;
	});

    //login
    $('button#login').livequery('click',function(event){
        if($("form#formLogin").valid()){
            usuarios = {
                email: $('form#formLogin #email').val(),
                senha: $('form#formLogin #senha').val()
            };

            $('button#login').html('PROCESSANDO...');
            $('button#login').prop("disabled",true);

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
                        if(response.results.gestor == 1){
                            window.location.href = "/administrador/dashboard";
                        }else{
                            window.location.href = "/office/dashboard";
                        }
                    }
                },
                error : function(response){
                    response = JSON.parse(response.responseText);
                    $('#errorLogin').removeClass('hidden');
                    $('#errorLogin').find('.alert p').html(response.error);
                    $('button#login').html('ACESSAR');
                    $('button#login').prop("disabled",false);
                }
            });
        }else{
            $("form#formLogin").valid();
        }
        return false;
    });

    //recuperar-senha
    $('button#recuperar').livequery('click',function(event){
        if($("form#formReset").valid()){
            usuarios = {
                email: $('form#formReset #email').val()
            };

            $('button#recuperar').html('PROCESSANDO...');
            $('button#recuperar').prop("disabled",true);

            //params
            var params = {};
            params = JSON.stringify(usuarios);

            app.util.getjson({
                url : "/controller/guest/usuario/password-reset",
                method : 'POST',
                contentType : "application/json",
                data: params,
                success: function(response){
                    if(response.success){
                        $('#successPassword').removeClass('hidden');
                        $('#successPassword').find('.alert p').html(response.success);
                    }else{
                        $('#errorPassword').removeClass('hidden');
                        $('#errorPassword').find('.alert p').html(response.error);
                    }
                    $('button#recuperar').html('ENVIAR');
                    $('button#recuperar').prop("disabled",false);
                },
                error : function(response){
                    response = JSON.parse(response.responseText);
                    $('#errorPassword').removeClass('hidden');
                    $('#errorPassword').find('.alert p').html(response.error);
                    $('button#recuperar').html('ENVIAR');
                    $('button#recuperar').prop("disabled",false);
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

});
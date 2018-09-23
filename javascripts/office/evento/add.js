//variable global
// var questionarios = {};

$(document).ready(function(){

    //datepicker
    $('#data').datepicker({
        startDate: 'today',
        autoclose: true, 
        todayHighlight: true,
        format: "dd/mm/yyyy",
        language: 'pt-BR'
    });

    //datepicker
    $('#termino').datepicker({
        startDate: 'today',
        autoclose: true, 
        todayHighlight: true,
        format: "dd/mm/yyyy",
        language: 'pt-BR'
    });

    $('#data').mask('00/00/0000');
    $('#termino').mask('00/00/0000');

    //validate
    $('form#formAdd').validate({
        rules: {
            nome: {
                required: true
            },
            local: {
                required: true
            },
            descricao : {
                required: true
            },
            data : {
                required: true
            },
            categoria : {
                required: true
            }
        },
        messages: {
            nome: { 
                required: 'Preencha o nome do evento'
            },
            local: { 
                required: 'Preencha onde será realizado o evento'
            },
            descricao: { 
                required: 'Preencha uma descrição sobre o evento'
            },
            data: { 
                required: 'Preencha a data do evento'
            },
            categoria: { 
                required: 'Vamos começar, selecione uma categoria'
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

    //categoria
    app.util.getjson({
        url : "/controller/office/categoria/list",
        method : 'POST',
        contentType : "application/json",
        success: function(response){
        var options = '<option value="" disabled selected>Selecione</option>';
        for (var i=0;i<response.results.length;i++) {
            //selected = (i==0) ? 'selected' : '';
            options += '<option value="'+response.results[i].id+'" >'+ response.results[i].nome+'</option>';
        }
        $("#categoria").html(options);
    },
        error : onError
    });

    // function get(){
    //     var params = {
    //         id: $('#idprojeto').val()
    //     };
    //     //alert(params.id);
    //     params = JSON.stringify(params);

    //     var secretaria = 0;

    //     //list
    //     app.util.getjson({
    //         url : "/controller/office/projeto/get",
    //         method : 'POST',
    //         contentType : "application/json",
    //         data: params,
    //         success: function(response){
    //             if(response.id){
    //                 //set
    //                 projetos = response;

    //                 $('#nomeprojeto').html(response.nome);
    //                 $('#nomesecretaria').html(response.sigla);
    //                 $('#vigenciaprojeto').html(response.vigenciaOperacao);
    //                 $('#form-loading').addClass('hidden');
    //                 $('#form').removeClass('hidden');
    //             }else{
    //                 //window.location.href = "/404";
    //             }
                
    //         },
    //         error : function(response){
    //             //window.location.href = "/404";
    //         }
    //     });
    // }
    

    //save
    $('button#salvar').on('click',function(event){
        if($("form#formAdd").valid()){

            $('button#salvar').html('Processando...');
            $('button#salvar').prop("disabled",true);
            $('button#cancelar').prop("disabled",true);

            // $.ajax({  
            //     type: "POST", 
            //     contentType:attr( "enctype", "multipart/form-data" ),
            //     url: "/controller/office/evento/create",  
            //     data: $("form#formAdd").serialize(),  
            //     success: function(response){  
            //         if(response.success){
            //             setSession('success', response.success);
            //             window.location.href = "/office/evento/";
            //         }
            //     },
            //     error : function(response){
            //         response = JSON.parse(response.responseText);
            //         $('#error').removeClass('hidden');
            //         $('#error').find('.alert p').html(response.error);
            //         $('button#salvar').html('Salvar');
            //         $('button#salvar').prop("disabled",false);
            //         $('button#cancelar').prop("disabled",false);
            //     }
            // });  

            app.util.getjson({
                url : "/controller/office/evento/create",
                method : 'POST',
                data: $("form#formAdd").serialize(),
                success: function(response){
                    if(response.success){
                        setSession('success', response.success);
                        window.location.href = "/office/evento/";
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
            $("form#formAdd").valid();
        }
        return false;
    });

    //cancel
    $('button#cancelar').on('click',function(event){
        window.location.href = "/office/evento/";
        return false;
    });

	function onError(response) {
      console.log(response);
    }

    get();

});
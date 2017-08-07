$(document).ready(function(){
    var portador =  $('input#portador');
    var numerocartao =  $('input#numerocartao');
    var cvc =  $('input#cvc');
    var mes =  $('select#mes');
    var ano =  $('select#ano');
    var visa =  $('#visa');
    var mastercard =  $('#mastercard');
    var amex =  $('#amex');
    var brand = undefined;
    var bank = undefined;
    var session = undefined;
    var senderHash = undefined;
    var cardToken = undefined;
    var pay = false;

    //set value cart
    $('#carrinho .valor').html(floatToMoney(usuarios.valor,'R$'));

    //mask
    $('#datanascimento').mask('00/00/0000');

    //use format
    numerocartao.payform('formatCardNumber');
    cvc.payform('formatCardCVC');

    //set flag
    numerocartao.keyup(function() {
      amex.removeClass('transparent');
      visa.removeClass('transparent');
      mastercard.removeClass('transparent');
      if($.payform.validateCardNumber(numerocartao.val()) == false){
        numerocartao.removeClass('has-success');
        numerocartao.addClass('has-error');
      }else{
        numerocartao.removeClass('has-error');
        numerocartao.addClass('has-success');
      }
      if($.payform.parseCardType(numerocartao.val()) == 'visa'){
        brand = 'visa';
        mastercard.addClass('transparent');
        amex.addClass('transparent');
      }else if($.payform.parseCardType(numerocartao.val()) == 'amex'){
        brand = 'amex';
        mastercard.addClass('transparent');
        visa.addClass('transparent');
      }else if($.payform.parseCardType(numerocartao.val()) == 'mastercard'){
        brand = 'mastercard';
        amex.addClass('transparent');
        visa.addClass('transparent');
      }
    });

    //validate
    $('form#formCartaoCredito').validate({
      rules: {
        portador: { 
          required: true
        },
        numerocartao: { 
          required: true
        },
        cvc: { 
          required: true,
          minlength: 3
        },
        mes: { 
          required: true
        },
        ano: { 
          required: true
        },
        datanascimento: { 
          required: true
        },
        area: { 
          required: true,
          minlength: 2
        },
        telefone: { 
          required: true,
          minlength: 9
        }
      },
      messages: {
        portador: { 
          required: 'Qual o nome do portador do cartão?'
        },
        numerocartao: { 
          required: 'Preencha os números do cartão'
        },
        cvc: { 
          required: 'Qual o código de segurança?',
          minlength: 'Um cartão de crédito tem 3 ou 4 digitos de segurança, nos informe'
        },
        mes: { 
          required: 'Qual o mês de validade?'
        },
        ano: { 
          required: 'Qual o ano de validade?'
        },
        datanascimento: { 
          required: 'Qual a data de nascimento do portador?'
        },
        area: { 
          required: 'Qual o area do telefone?',
          minlength: 'DDD mínimo de 2 digitos'
        },
        telefone: { 
          required: 'Qual o número de telefone?',
          minlength: 'Telefone mínimo de 9 digitos'
        }
      },
      highlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
        $(element).closest('.form-group').find('i.fa').remove();
        $(element).closest('.form-group').append('<i class="fa fa-times fa-validate form-control-feedback"></i>');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
        $(element).closest('.form-group').find('i.fa').remove();
        $(element).closest('.form-group').append('<i class="fa fa-check fa-validate form-control-feedback"></i>');
      },
      errorElement: 'span',
      errorClass: 'help-block',
      errorPlacement: function(error, element) {
        error.insertAfter(element);
      }
    });

    $('a#setPagamento').livequery('click',function(event){
      var option = $(this).attr('data-rel');
      if(option==1){
        $('#pagamento').addClass('hidden');
        $('button#alterar').addClass('hidden');
        $('button#voltar').removeClass('hidden');
        $('#cartaoCredito').removeClass('hidden');
        $('button#pagar').removeClass('hidden');
      }else if(option==2){
        $('#pagamento').addClass('hidden');
        $('button#alterar').addClass('hidden');
        $('button#voltar').removeClass('hidden');
        $('button#banking').removeClass('hidden');
        if(bank!=undefined){
          $('button#banking').prop("disabled",false);
        }else{
          $('button#banking').prop("disabled",true);
        }
        $('#cartaoDebito').removeClass('hidden');
      }else{
        $('button#alterar').addClass('hidden');
        $('#errorBoleto').addClass('hidden');
        $('#gerando-boleto').removeClass('hidden');
        //params
        var params = {
          senderhash: senderHash,
          usuario: usuarios //utilizando variavel global(login.js)
        };
        params = JSON.stringify(params);
        //transactions
        app.util.getjson({
          url : "/controller/guest/checkout/billet",
          method : 'POST',
          contentType : "application/json",
          data: params,
          success: function(response){
            if(response.results.codigo){
              //set pagamentos
              pagamentos = {
                codigo: response.results.codigo,
                status: response.results.status,
                descricao: response.results.descricao,
                metodo: response.results.metodo,
                valor: response.results.valor,
                link: response.results.link
              };

              //create usuario
              //params
              var params = {
                pagamento: pagamentos, //utilizando variavel global(login.js)
                usuario: usuarios //utilizando variavel global(login.js)
              };
              params = JSON.stringify(params);
              //save
              app.util.getjson({
                url : "/controller/guest/usuario/create",
                method : 'POST',
                contentType : "application/json",
                data: params,
                success: function(response){
                  if(response.success){
                    $('#carrinho').addClass('hidden');
                    $('#pagamento').addClass('hidden');
                    $('#mensagem').removeClass('hidden');
                      $('#mensagem #pagamento-pago').addClass('hidden');
                      $('#mensagem #pagamento-aguardando').addClass('hidden');
                      $('#mensagem #pagamento-cancelado').addClass('hidden');
                      $('#mensagem #pagamento-devolvido').addClass('hidden');
                      $('#mensagem #pagamento-debito').addClass('hidden');
                    $('#mensagem #pagamento-boleto').removeClass('hidden');
                    $('#mensagem #pagamento-boleto #pagamento-codigo').html('Código: '+pagamentos.codigo);
                    $('#mensagem #pagamento-boleto #pagamento-status').html('Status: '+pagamentos.descricao);
                    $('#gerando-boleto').addClass('hidden');
                    $('button#finalizarcadastro').removeClass('hidden');
                  }
                },
                error(response){
                  $('#errorBoleto').find('.alert').append('<p>'+ response.error +'</p>');
                  $('#errorBoleto').removeClass('hidden');
                }
              });
            }
          },
          error: function(response){
            $('button#alterar').removeClass('hidden');
            $('#gerando-boleto').addClass('hidden');
            $('#errorBoleto').find('.alert').append('<p>Ocorreu um erro ao gerar o boleto, tente novamente</p>');
            $('#errorBoleto').removeClass('hidden');
          }
        });
      }
      return false;
    });

    $('a#setBanco').livequery('click',function(event){
      var option = $(this).data('rel');
      $("a#setBanco").addClass('transparent');
      $("a#setBanco[data-rel]").each(function(){
        item = $(this).data('rel');
        if(option == item){
          $(this).removeClass('transparent');
          bank = item;
          $('button#banking').prop("disabled",false);
        }
      });
      return false;
    });
    

    //get session checkout transparent
    app.util.getjson({
        url : "/controller/guest/checkout/getsession",
        method : 'POST',
        contentType : "application/json",
        success: function(response){
          if(response.results.id){
            session = response.results.id;
            PagSeguroDirectPayment.setSessionId(session);
            senderHash = PagSeguroDirectPayment.getSenderHash();
          }
        },
        error : onError
    });

    //pay
    $('button#pagar').livequery('click',function(event){
      if($("form#formCartaoCredito").valid()){
        var isCardValid = $.payform.validateCardNumber(numerocartao.val());
        var isCvcValid = $.payform.validateCardCVC(cvc.val());
        var isExpiryValid = $.payform.validateCardExpiry(mes.val(),ano.val());
        var errors = 0;

        $('#errorCartaoCredito').find('.alert').html('');
        if(portador.val().length < 5){
          errors++;
          $('#errorCartaoCredito').find('.alert').append('<p>Verifique o nome do portador do cartão</p>');
        }else if(!isCardValid){
          errors++;
          $('#errorCartaoCredito').find('.alert').append('<p>Verifique o número do seu cartão</p>');
        }else if(!isCvcValid){
          errors++;
          $('#errorCartaoCredito').find('.alert').append('<p>Verifique o código de segurança do seu cartão</p>');
        }else if(!isExpiryValid){
          errors++;
          $('#errorCartaoCredito').find('.alert').append('<p>Verifique a validade do seu cartão</p>');
        }else if(!session && !senderHash){
          errors++;
          $('#errorCartaoCredito').find('.alert').append('<p>Ocorreu um erro ao tentar fazer uma requisição de pagamento, tente novamente mais tarde!</p>');
        }else{
          $('#errorCartaoCredito').addClass('hidden');
          $('button#pagar').html('PROCESSANDO...');
          $('button#pagar').prop("disabled",true);
          $('button#voltar').prop("disabled",true);

          var cardNumber = numerocartao.val();
          var cardMonth = mes.val().toString();
          var cardYear = ano.val().toString();
          cardNumber = cardNumber.toString().replace(/ /g,"");
          
          PagSeguroDirectPayment.createCardToken({
            cardNumber: cardNumber,
            brand: brand,
            cvv: cvc.val(),
            expirationMonth: cardMonth,
            expirationYear: cardYear,
            success: function(response){
              cardToken = response.card.token;
              //params
              var params = {
                senderhash: senderHash,
                cardtoken: cardToken,
                portador: portador.val(),
                cardbirthdate: $('input#datanascimento').val(),
                cardarea: $('input#area').val(),
                cardphone: $('input#telefone').val(),
                usuario: usuarios //utilizando variavel global(login.js)
              };
              params = JSON.stringify(params);
              //transactions
              app.util.getjson({
                  url : "/controller/guest/checkout/creditcard",
                  method : 'POST',
                  contentType : "application/json",
                  data: params,
                  success: function(response){
                    if(response.results.codigo){
                      //set pagamentos
                      pagamentos = {
                        codigo: response.results.codigo,
                        status: response.results.status,
                        descricao: response.results.descricao,
                        metodo: response.results.metodo,
                        valor: response.results.valor
                      };

                      //params
                      var params = {
                        pagamento: pagamentos, //utilizando variavel global(login.js)
                        usuario: usuarios //utilizando variavel global(login.js)
                      };
                      params = JSON.stringify(params);
                      //save
                      app.util.getjson({
                        url : "/controller/guest/usuario/create",
                        method : 'POST',
                        contentType : "application/json",
                        data: params,
                        success: function(response){
                          if(response.success){
                            $('#mensagem').removeClass('hidden');
                            $('#mensagem #pagamento-pago').addClass('hidden');
                            $('#mensagem #pagamento-aguardando').addClass('hidden');
                            $('#mensagem #pagamento-cancelado').addClass('hidden');
                            $('#mensagem #pagamento-devolvido').addClass('hidden');
                            $('#mensagem #pagamento-debito').addClass('hidden');
                            switch(parseInt(pagamentos.status)){
                              case 1:
                              case 2:
                                $('#carrinho').addClass('hidden');
                                $('button#pagar').addClass('hidden');
                                $('button#voltar').addClass('hidden');
                                $('#cartaoCredito').addClass('hidden');
                                $('button#finalizar').removeClass('hidden');
                                $('#mensagem #pagamento-aguardando').removeClass('hidden');
                                $('#mensagem #pagamento-aguardando #pagamento-codigo').html('Código: '+pagamentos.codigo);
                                $('#mensagem #pagamento-aguardando #pagamento-status').html('Status: '+pagamentos.descricao);
                              break;
                              case 3:
                                //set transaction pay approved
                                pay = true;
                                $('#carrinho').addClass('hidden');
                                $('button#pagar').addClass('hidden');
                                $('button#voltar').addClass('hidden');
                                $('#cartaoCredito').addClass('hidden');
                                $('button#continuar').removeClass('hidden');
                                $('#mensagem #pagamento-pago').removeClass('hidden');
                                $('#mensagem #pagamento-pago #pagamento-codigo').html('Código: '+pagamentos.codigo);
                                $('#mensagem #pagamento-pago #pagamento-status').html('Status: '+pagamentos.descricao);
                              break;
                              case 6:
                                $('#carrinho').addClass('hidden');
                                $('button#pagar').addClass('hidden');
                                $('button#voltar').addClass('hidden');
                                $('#cartaoCredito').addClass('hidden');
                                $('button#retornar').removeClass('hidden');
                                $('#mensagem #pagamento-devolvido').removeClass('hidden');
                                $('#mensagem #pagamento-devolvido #pagamento-codigo').html('Código: '+pagamentos.codigo);
                                $('#mensagem #pagamento-devolvido #pagamento-status').html('Status: '+pagamentos.descricao);
                              break;
                              case 7:
                                $('#carrinho').addClass('hidden');
                                $('button#pagar').addClass('hidden');
                                $('button#voltar').addClass('hidden');
                                $('#cartaoCredito').addClass('hidden');
                                $('button#retornar').removeClass('hidden');
                                $('#mensagem #pagamento-cancelado').removeClass('hidden');
                                $('#mensagem #pagamento-cancelado #pagamento-codigo').html('Código: '+pagamentos.codigo);
                                $('#mensagem #pagamento-cancelado #pagamento-status').html('Status: '+pagamentos.descricao);
                              break;
                            }
                          }
                        },
                        error(response){
                          $('#errorCartaoCredito').find('.alert').append('<p>'+ response.error +'</p>');
                          $('#errorCartaoCredito').removeClass('hidden');
                          $('button#pagar').html('PAGAR');
                          $('button#pagar').prop("disabled",false);
                          $('button#voltar').prop("disabled",false);
                        }
                      });
                    }
                  },
                 error: function(response){
                  var html = '<ul>';
                  $.map(response.errors, function(error){
                    html += '<li>'+error+'</li>';
                  });
                  html += '</ul>';
                  $('#errorCartaoCredito').find('.alert').append(html);
                  $('#errorCartaoCredito').removeClass('hidden');
                  $('button#pagar').html('PAGAR');
                  $('button#pagar').prop("disabled",false);
                  $('button#voltar').prop("disabled",false);
                }
              });
            },
            error: function(response){
              var html = '<ul>';
              $.map(response.errors, function(error){
                html += '<li>'+error+'</li>';
              });
              html += '</ul>';
              $('#errorCartaoCredito').find('.alert').append(html);
              $('#errorCartaoCredito').removeClass('hidden');
              $('button#pagar').html('PAGAR');
              $('button#pagar').prop("disabled",false);
              $('button#voltar').prop("disabled",false);
            },
            complete: function(response){}
          });
        }
        if(errors){
          $('#errorCartaoCredito').removeClass('hidden');
          $('button#voltar').prop("disabled",true);
        }
      }else{
        $("form#formCartaoCredito").valid();
      }
      return false;
    });

    //pay internet banking
    $('button#banking').livequery('click',function(event){
      if(bank!=undefined){
        $('button#banking').html('PROCESSANDO...');
        $('button#banking').prop("disabled",true);
        $('button#voltar').prop("disabled",true);
        //params
        var params = {
          bank: bank,
          senderhash: senderHash,
          usuario: usuarios //utilizando variavel global(login.js)
        };
        params = JSON.stringify(params);
        //transactions
        app.util.getjson({
          url : "/controller/guest/checkout/debitcard",
          method : 'POST',
          contentType : "application/json",
          data: params,
          success: function(response){
            if(response.results.codigo){
              //set pagamentos
              pagamentos = {
                codigo: response.results.codigo,
                status: response.results.status,
                metodo: response.results.metodo,
                valor: response.results.valor,
                link: response.results.link
              };

              $('#mensagem').removeClass('hidden');
                $('#mensagem #pagamento-pago').addClass('hidden');
                $('#mensagem #pagamento-aguardando').addClass('hidden');
                $('#mensagem #pagamento-cancelado').addClass('hidden');
                $('#mensagem #pagamento-devolvido').addClass('hidden');
                $('#mensagem #pagamento-debito').addClass('hidden');
              $('#carrinho').addClass('hidden');
              $('button#banking').addClass('hidden');
              $('button#voltar').addClass('hidden');
              $('button#internetbanking').removeClass('hidden');
              $('button#internetbanking').attr('data-link', response.results.link);
              $('#cartaoDebito').addClass('hidden');
              $('#mensagem #pagamento-debito').removeClass('hidden');
              $('#mensagem #pagamento-debito #pagamento-codigo').html('Código: '+response.results.codigo);
              $('#mensagem #pagamento-debito #pagamento-status').html('Status: '+response.results.descricao);
              $('button#banking').html('PAGAR');
              $('button#banking').prop("disabled",true);
              $('button#voltar').prop("disabled",true);
            }
          },
          error: function(response){
            var html = '<ul>';
            $.map(response.errors, function(error){
              html += '<li>'+error+'</li>';
            });
            html += '</ul>';
            $('#errorCartaoDebito').find('.alert').append(html);
            $('#errorCartaoDebito').removeClass('hidden');
            $('button#banking').html('PAGAR');
            $('button#banking').prop("disabled",false);
            $('button#voltar').prop("disabled",true);
          },
          complete: function(response){}
        });
      }
      return false;
    });

    //internet banking link
    $('button#internetbanking').livequery('click',function(event){
      var link = $(this).data('link');
      $('button#internetbanking').html('PROCESSANDO...');
      $('button#internetbanking').prop("disabled",true);
      //params
      var params = {
        pagamento: pagamentos, //utilizando variavel global(login.js)
        usuario: usuarios //utilizando variavel global(login.js)
      };
      params = JSON.stringify(params);
      //save
      app.util.getjson({
        url : "/controller/guest/usuario/create",
        method : 'POST',
        contentType : "application/json",
        data: params,
        success: function(response){
          if(response.success){
            window.open(link);
            setTimeout(function(){
              window.location.href = "/";
            },5000);
          }
        },
        error(response){
          $('button#internetbanking').html('ACESSAR A PÁGINA DO BANCO');
          $('button#internetbanking').prop("disabled",false);
        }
      });
    });
    
    //continuar
    $('button#continuar').livequery('click',function(event){
      if(pay){
        window.location.href = "/office/dashboard";
      }else{
        window.location.href = "/";
      }
    });

    //finalizar cadastro através do boleto
    $('button#finalizarcadastro').livequery('click',function(event){
      window.location.href = "/";
    });

    //finalizar
    $('button#finalizar').livequery('click',function(event){
      if(!pay) window.location.href = "/"
    });

    //retornar
    $('button#retornar').livequery('click',function(event){
      if(!pay){
        $('button#voltar').addClass('hidden');
        $('#pagamento').removeClass('hidden');
        $('#mensagem').addClass('hidden');
          $('#mensagem #pagamento-pago').addClass('hidden');
          $('#mensagem #pagamento-aguardando').addClass('hidden');
          $('#mensagem #pagamento-cancelado').addClass('hidden');
          $('#mensagem #pagamento-devolvido').addClass('hidden');
          $('#mensagem #pagamento-debito').addClass('hidden');
        $('#cartaoCredito').addClass('hidden');
        $('button#retornar').addClass('hidden');
        $('button#banking').addClass('hidden');
        $('button#pagar').addClass('hidden');
        $('button#pagar').html('PAGAR');
        $('button#pagar').prop("disabled",false);
        $('button#alterar').removeClass('hidden');
      }
    });

    //voltar
    $('button#voltar').livequery('click',function(event){
      $('button#pagar').addClass('hidden');
      $('button#voltar').addClass('hidden');
      $('button#banking').addClass('hidden');
      $('button#finalizarcadastro').addClass('hidden');
      $('#cartaoCredito').addClass('hidden');
      $('#cartaoDebito').addClass('hidden');
      $('#mensagem').addClass('hidden');
        $('#mensagem #pagamento-pago').addClass('hidden');
        $('#mensagem #pagamento-aguardando').addClass('hidden');
        $('#mensagem #pagamento-cancelado').addClass('hidden');
        $('#mensagem #pagamento-devolvido').addClass('hidden');
        $('#mensagem #pagamento-debito').addClass('hidden');
        $('#mensagem #pagamento-boleto').addClass('hidden');
      $('#pagamento').removeClass('hidden');
      $('button#alterar').removeClass('hidden');
      $('#carrinho').removeClass('hidden');
    });

    //alterar ingresso
    $('button#alterar').livequery('click',function(event){
      $("#modal-checkout").modal('hide').data('bs.modal',null);
    });

    function onError(response) {
      console.log(response);
    }

});
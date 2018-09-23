$(document).ready(function(){

    //get
    function get(){

        var params = {
            slug: $('#slug').val()
        };
        params = JSON.stringify(params);

        app.util.getjson({
            url : "/controller/guest/evento/get",
            method : 'POST',
            contentType : "application/json",
            data: params,
            success: function(response){
                
                var html = '';
                for (var i=0;i<response.length;i++) {

                    var pais = '';
                    switch(parseInt(response[i].pais)){
                        case 1:
                            pais = 'Brazil';
                        break;
                        case 2:
                            pais = 'Bolívia';
                        break;
                        case 3:
                            pais = 'Peru';
                        break;
                    }

                    html += '<li>'+
                                '<time datetime="2014-07-20">'+
                                    '<span class="day">'+ response[i].dia +'</span>'+
                                    '<span class="month">'+ response[i].mes +'</span>'+
                                    '<span class="time">'+ pais +'</span>'+
                                '</time>'+
                                '<img alt="'+ response[i].nome +'" src="'+ response[i].imagem +'" />'+
                                '<div class="info">'+
                                    '<h2 class="title">'+ response[i].nome +'</h2>'+
                                    '<p class="desc">'+ response[i].descricao +'</p>'+
                                '</div>'+
                                '<div class="social">'+
                                    '<ul>'+
                                        '<li class="facebook" style="width:33%;"><a href="#facebook"><span class="fa fa-facebook"></span></a></li>'+
                                        '<li class="twitter" style="width:34%;"><a href="#twitter"><span class="fa fa-twitter"></span></a></li>'+
                                        '<li class="google-plus" style="width:33%;"><a href="#google-plus"><span class="fa fa-google-plus"></span></a></li>'+
                                    '</ul>'+
                                '</div>'+
                            '</li>';
                }
                $('ul.event-list').html(html);
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
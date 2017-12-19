//variable global
var artistas, agendas = [];
var app_date, params = {};

$(document).ready(function(){

    function calendar(){
        $('#calendar').fullCalendar({
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            locale: 'pt-br',
            timezone: 'local',
            ignoreTimezone: true,
            defaultView: 'agendaDay',
            slotDuration: '00:15:00',
            defaultDate: (app_date.ano+'-'+app_date.mes+'-'+app_date.dia),
            editable: true,
            eventLimit: true,
            selectable: true,
            header: {
                left: 'agendaDay,agendaWeek',
                center: 'today, prev, title, next',
                right: ''
            },
            titleFormat: 'ddd D MMM, YYYY',
            allDaySlot: false,
            resources: artistas,
            events: agendas,
            eventDrop: function(event, delta, revertFunc) {

         //        alert(event.title + " was dropped on " + event.start.format());

         //        if (!confirm("Are you sure about this change?")) {
         //            revertFunc();
         //        }

            },
            select: function(start,end,event,view,resource) {
                console.log(resource);
                tooltip(event);

                //params
                params = {
                    inicio: new Date(start),
                    fim: new Date(end),
                    artista: resource.id
                }
            },
            eventClick: function(event) {
                console.log(event);
            },
            eventDrop: function(event, delta, revertFunc) {
                console.log(event);
            },
            eventAfterRender: function(event, element) {
                var icon = '';
                switch(parseInt(event.status)){
                    case 1:
                        element.addClass('pending-app');
                        icon = 'icon-hourglass pending';
                    break;
                    case 2:
                        element.addClass('success-app');
                        icon = 'ti-thumb-up success';
                    break;
                    case 3:
                        element.addClass('completed-app');
                        icon = 'icon-check completed';
                    break;
                    case 4:
                        element.addClass('canceled-app');
                        icon = 'ti-na canceled';
                    break;
                    case 5:
                        element.addClass('pending-office');
                        icon = 'icon-hourglass pending';
                    break;
                    case 6:
                        element.addClass('success-office');
                        icon = 'ti-thumb-up success';
                    break;
                    case 7:
                        element.addClass('canceled-office');
                        icon = 'ti-na canceled'
                    break;
                    case 8:
                        element.addClass('blocked');
                    break;
                }
                element.find('.fc-title').after("<div class='fc-description'>"+event.description+"</div>")
                element.find('.fc-title').after("<i class='"+icon+"'></i>")
            }
        });
    }

    function getDate(){
        $('#calendar-loading').removeClass('hidden');
        //get
        app.util.getjson({
            url : "/controller/office/agenda/getdate",
            method : 'POST',
            contentType : "application/json",
            success: function(response){
                if(response.results){
                    //set 
                    app_date = response.results;
                    listArtista();
                }
            },
            error : onError
        });
    }

    function listArtista(){
        //list
        app.util.getjson({
            url : "/controller/office/artista/list",
            method : 'POST',
            contentType : "application/json",
            success: function(response){
                if(response.results){
                    //set 
                    artistas = response.results;
                    listAgenda();
                }
            },
            error : onError
        });
    }

    function listAgenda(){
        //list
        app.util.getjson({
            url : "/controller/office/agenda/list",
            method : 'POST',
            contentType : "application/json",
            success: function(response){
                if(response.results){
                    //set 
                    agendas = response.results;

                    $('#calendar-loading').addClass('hidden');

                    //set itens in calendar
                    calendar();
                }
            },
            error : onError
        });
    }

    function tooltip(attributes){
        $('.tooltip-calendar').removeClass('hidden');
        $('.tooltip-calendar').css('top', attributes.clientY);
        $('.tooltip-calendar').css('left', attributes.clientX);
    }

    $('button.tooltipClose').livequery('click',function(event){
        $('.tooltip-calendar').addClass('hidden');
    });

    $('button#schedule').livequery('click',function(event){
        var options = {
            cache:false,
            show: true,
            keyboard: false,
            backdrop: 'static'
        }
        $('.tooltip-calendar').addClass('hidden');
        $("div#modal").modal(options);
        //modal-lg
        // $('div#modal .modal-dialog').addClass('modal-lg');

        $('div#modal .modal-content').load('views/office/agenda/add.php');
        return false;
    });

    function onError(response) {
      console.log(response);
    }

    //init
    getDate();

});
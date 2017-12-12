//variable global
var artistas, agendas = [];

$(document).ready(function(){

    function calendar(){
        $('#calendar').fullCalendar({
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            locale: 'pt-br',
            timezone: 'local',
            ignoreTimezone: true,
            defaultView: 'agendaDay',
            slotDuration: '00:15:00',
            // defaultDate: ($scope.aplicacao.ano+'-'+$scope.aplicacao.mes+'-'+$scope.aplicacao.dia),
            defaultDate: '2017-12-11',
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
                // $scope.agendamento.start =  new Date(start);
                // $scope.agendamento.end = new Date(end);
                // $scope.agendamento.profissional = resource.id;
            },
            eventClick: function(event) {
                console.log(event);
            },
            eventDrop: function(event, delta, revertFunc) {
                console.log(event);
            }
        });
    }

    function listArtista(){
        $('#calendar-loading').removeClass('hidden');

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
        $('div#modal .modal-content').load('views/office/agenda/add.php');
        return false;
    });

    function onError(response) {
      console.log(response);
    }

    //init
    listArtista();

});
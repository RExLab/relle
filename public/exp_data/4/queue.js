$(function () {

    var rep = '';
    var popup = '';
    
    

   function queueUpload(){
        $('#return').addClass('well well-sm');
        $('#return').html('<button id="btnLeave" class="btn btn-sm btn-default" name="leave">' +
                lang.leave + '</button>' +
                lang.time + ": " +
                "<span id='min'>10</span>:<span id='seg'>00</span>");
    }
         
    function loadLab(data) {
             $.getScript("/js/queue.js", function () {
            refresh = setInterval(RefreshTimeAlive, 5000); // Intervalo para refresh da fila (5 em 5 segundos deve mandar um POST para identificar que usuario continua conectado)  
            setTimeout(LeaveExperiment, duration * 60 * 1000); // Agenda a execucao da funcao que envia um POST com action de deixar experimento
            timer = setInterval(TimerMinus, 1000); // Refresh do contador visual
            $("#btnLeave").click(function () {
                $('#exp').hide();
                $('#return').remove();
                //"<span id='min'>" + data.clock.min + "</span>:<span id='seg'>" + data.clock.seg + "</span>");
                $('#lab').hide();
            });
        });
    }

    function waitLab(data) {
        $('#error').html("");
        $('#return').html("");
        if (data.clock.min < 0 || data.clock.seg < 0) {
            data.clock.min = data.clock.seg = 0;
        }
        $('#error').append(
                "<div class='alert alert-warning alert-dismissible'>" +
                "<button id='btnLeave' class='btn btn-warning btn-sm' name='leave'>"+lang.leave+"</button>&nbsp;&nbsp;" +
                "<div class='col-xs-4'>" +
                "<strong>+lang.wait+</strong><span id='nwait'>" + data.wait + " </span>&nbsp;&nbsp;" +
                "</div><div class='col-xs-4'>" +
                "<strong>{{trans('interface.timeleft')}}: </strong>" +
                "<span id='min'>" + data.clock.min + "</span>:<span id='seg'>" + data.clock.seg + "</span>" +
                '</div>' +
                '</div>');
        $("#access").css("display", "none");
        $.getScript("/js/queue.js", function () {
            refresh = setInterval(Refresh, 200);
            timer = setInterval(TimerMinus, 1000);
            $("#btnLeave").click(LeaveExperiment);
        });
    }

    function errorLab() {
        $('#error').html("");
        $('#error').html(
                "<div class='alert alert-warning alert-dismissible'>" +
                '<button id="btnLeave" class="btn btn-warning btn-sm" name="leave">{{trans("interface.leave")}}</button>' +
                "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
                "{{trans('message.tab')}}" +
                '</div>'
                );
        $.getScript("/js/queue.js", function () {
            $("#btnLeave").click(LeaveExperiment);
        });
    }
    
    
    $("#upload").click(function () {
        var json = { 'exp_id': exp_id,
                'pass': $('meta[name=csrf-token]').attr('content'),
                'exec_time':duration };
                $.ajax({
                type: "POST",
                        url: urlqueue + "/queue",
                        data: json,
                        success:function(data){
                        data = $.parseJSON(data);
                                if (data['message'] == 'first'){
                        loadLab(data);
                        } else if (data.wait) {
                        waitLab(data);
                        } else{
                            errorLab();
                        }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            errorLab();
                        }

                });
       
        });
});


       
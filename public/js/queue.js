function reloadPage() {
    location.reload(true);
}

function LeaveExperiment() {
    $('#exp').html("");
    $('#return').html("");
    //$("#access").click(Acess);
    reloadPage();
}

$(function () {
    var timer;

    $("#access").click(Acess);

    function ExtendedSessionHandler() {
        uilang.extended = 'Sessão extendida.';
        console.log('Sessão foi extendida. Fique atento, a qualquer momento a sessão pode ser terminada.');
        $(".timeleft").html(uilang.extended);
    }

    function StatusHandler(data) {
        $("#min").html(data.clock.min);
        var seg_old = parseInt($("#seg").html());
        if (Math.abs(seg_old - data.clock.seg) > 10) {
            $("#seg").html(data.clock.seg);
            console.log(Math.abs(seg_old - data.clock.seg));
        }
        $('#nwait').html(data.wait);

    }

    function FinishedSessionHandler() {
        console.log('Sessão finalizada.');
        clearInterval(timer)
        LeaveExperiment()
    }

    function ReconnectedSessionHandler() {
        hideReconnectingAlert();
        if (typeof (LabReconnectedSessionHandler) == 'function')
            LabReconnectedSessionHandler();
        else
            console.log('Callback function for lab reconnection is missing');
    }

    function Countdown() {
        var soma = parseInt($("#min").html()) * 60 + parseInt($("#seg").html());
        soma = (soma - 1) / 60;
        if (soma > 0) {
            $("#min").html(parseInt(soma));
            var seg = Math.round((soma - parseInt(soma)) * 60);
            var zero = "";
            if (seg < 10) {
                zero = "0";
            }
            $("#seg").html(zero + seg);
        } else {
            clearInterval(timer);
        }
    }

    function Acess(event) {
        event.preventDefault();
        var token1 = $("#inputBox").val();

        
        $("#access").off();
        
        var socket = io.connect('http://rexlab.ufsc.br:8080/' + exp_id, { path: '/socket.io','force new connection': true});

        socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content'),
            'exp_id': exp_id,
            'exec_time': duration,
            'token': token1, 
        });

        socket.on('wait', waitLab);

        socket.on('status', StatusHandler);

        socket.on('extended session', ExtendedSessionHandler);

        socket.on('finished session', FinishedSessionHandler);

        socket.on('success', function (data) {
            loadLab(data, socket);
        });

        socket.on('reconnect', function (data) {
            
            socket.emit('reconnection', {pass: $('meta[name=csrf-token]').attr('content'),
                'exp_id': exp_id,
                'exec_time': duration});
            socket.on('reconnected session', ReconnectedSessionHandler);
        });

        socket.on('reconnecting', function () {
            showReconnectingAlert(uilang);
        });

        socket.on('err', function (data) {
            console.log(data);
            if(data.code == 1){
                errorBooking(uilang);
            }else if(data.code == 2){
                errorLab(uilang);
            }else if(data.code == 3){
                errorLab(uilang);
            }
               
            
            setTimeout(function () {
                clearInterval(timer)
                LeaveExperiment();
            }, 2500);
        });

    }

    function loadLab(data, queue_socket) {
        if(typeof(locale) !== 'undefined' && data[locale] !== 'undefined'){
           data.html = data[locale];
        }else{
            data.html =data.defaulthtml; 
        }                
            
        UILoadLab(data, uilang).load(data.html, function () {

            $.getScript(data.js);
            
            timer = setInterval(Countdown, 1000);

            $("#btnLeaveExp").click(function (event) {
                event.preventDefault();

                if (typeof (LabLeaveSessionHandler) == 'function')
                    LabLeaveSessionHandler();
                else
                    console.log('Callback function before leaving lab is missing');

                if (typeof (lab_socket) !== 'undefined') {
                    if (lab_socket !== null)
                        lab_socket.disconnect();
                } else {
                    console.log('lab_socket not found');
                }
                if (queue_socket !== null)
                    queue_socket.disconnect();

                UILeave(uilang, exp_id).click(LeaveExperiment);

            });

        });

    }

    function waitLab(data) {
        UIWaitLab(data, uilang).click(function () {
            clearInterval(timer);
            LeaveExperiment();
        });

        timer = setInterval(Countdown, 1000);
    }

});

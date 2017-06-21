function getParameterByName(name, url) {
    if (!url) {
        url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
    if (!results)
        return null;
    if (!results[2])
        return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function reloadPage() {
    var callbacksite = getParameterByName('return');
    console.log(callbacksite);
    if (callbacksite)
        window.location.replace(callbacksite);
    else
        location.reload(true);
}

function LeaveExperiment() {
    $('#exp').html("");
    $('#return').html("");
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
        $("#access").off();
        loadLab({
            pt: 'lab/pt.html',
            es: 'lab/es.html',
            en: 'lab/en.html',
            defaulthtml: 'lab/pt.html',
            js: 'lab/exp_script.js',
            css: 'lab/exp_style.css',
            clock: {seg: 0, min: 5}
        }, null);
    }

    function loadLab(data, queue_socket) {
        if (typeof (locale) !== 'undefined' && data[locale] !== 'undefined') {
            data.html = data[locale];
        } else {
            data.html = data.defaulthtml;
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

                var btnRedirect = UILeave(uilang, exp_id)
                console.log(btnRedirect.length);
                if (btnRedirect.length)
                    btnRedirect.click(LeaveExperiment);
                else
                    LeaveExperiment();

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
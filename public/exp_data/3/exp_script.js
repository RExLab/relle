$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

var rpi_server = "http://paineldc2.relle.ufsc.br";
var results;
var lab_socket = null;
var switches = 0;
var UIimg_interval = null;
var circuit_images = [10, 12, 13, 14, 17, 18, 20, 21, 24, 25,30, 32, 34, 36, 37, 38, 4, 40, 41, 42, 48, 49, 5, 53, 54, 58, 64, 65, 66, 67, 68, 69, 7, 70, 72, 73, 74, 8, 80, 81, 9, 96, 97];
var image = "";
var cam_snapshot = rpi_server + "/snapshot.jpg"

$.getScript('http://relle.ufsc.br/exp_data/3/welcome.js', function () {
    var shepherd = setupShepherd();
    addShowmeButton('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span></button>')

    $('#btnIntro').on('click', function (event) {
        event.preventDefault();
        shepherd.start();
    });


});

$(function () {

    $('.switch').bootstrapToggle({
        onstyle: "success",
        offstyle: "danger",
        size: "small"
    });

    function reset() {
        var message = {};
        message.sw = {};
        message.pass = $('meta[name=csrf-token]').attr('content');

        for (var i = 0; i < 7; i++) {
            message.sw[i] = 0;
        }
        if (message && lab_socket) {
            message.pass = $('meta[name=csrf-token]').attr('content');
            lab_socket.emit('new message', message);
        }
    }

    function sendMessage() {
        clearTimeout(UIimg_interval);
        switches = 0;
        var message = {};
        message.sw = {};
        message.pass = $('meta[name=csrf-token]').attr('content');
        for (var i = 0; i < 7; i++) {
            if ($("input[id='sw" + i + "']:checked").length) {
                message.sw[i] = 1;
                switches = switches | 1 << i;
                console.log('switches: ' + switches);
            } else {
                message.sw[i] = 0;
            }
        }
        if (message && lab_socket) {
            message.pass = $('meta[name=csrf-token]').attr('content');
            lab_socket.emit('new message', message);
        }
        UIimg_interval = setTimeout(function () {
            if (circuit_images.indexOf(switches) >= 0) {
                console.log('loading /exp_data/3/resultante/' + switches + '.png');
                $('.equivalent').attr('src', '/exp_data/3/equivalent/' + switches + '.png');
                $('.default_circuit').hide().addClass('hiddencircuit');
                $('.equivalent').show().removeClass('hiddencircuit');
            } else {
                $('.equivalent').hide().addClass('hiddencircuit');
                $('.default_circuit').show().removeClass('hiddencircuit');
                console.log('resultante ' + switches + ' nao criada ainda');
            }
        }, 3000);
    }

    $('.switch').change(function () {
        sendMessage();
    });

    // depende da biblioteca lab_socket.io carregada pela fila
    lab_socket = io.connect(rpi_server, {'force new connection': true});
    lab_socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});
    $(".controllers").show();
    $(".loading").hide();

    lab_socket.on('new message', function (data) {
        console.log(data);
    });


    // Whenever the server emits 'user joined', log it in the chat body
    lab_socket.on('data received', function (data) {
        //printLog(data);
        results = $.parseJSON(data);
        console.log("I'm receiving " + data);

        for (var i = 0; i < 7; i++) {
            if (!isNaN(results.amperemeter[i])) {
                $("#a" + i).html(parseFloat(results.amperemeter[i] / 1000).toFixed(1) + " mA");
            }
        }
        for (var i = 0; i < 2; i++) {
            if (!isNaN(results.amperemeter[i])) {
                $("#v" + i).html(parseFloat(results.voltmeter[i] / 1000).toFixed(2) + " V");
            }
        }

    });

    lab_socket.on('reconnect', function (data) {
        console.log('reconnect');
        $(".cam").attr('src', $(".cam").attr('src'));
    });

    lab_socket.on('reconnecting', function () {
        console.log('reconnecting');

    });
});

function LabReconnectedSessionHandler() {
    if (lab_socket) {
        lab_socket.emit('reconnection', {pass: $('meta[name=csrf-token]').attr('content'),
            'exp_id': exp_id,
            'exec_time': duration});
    }
}


function LabLeaveSessionHandler() {
    if ($('.equivalent.hiddencircuit').length > 0) {
        image = $('img.default_circuit').attr('src');
    } else {
        image = $('.equivalent').attr('src');
    }
}

function report(id) {
    var array = results;
    array.equivalent = image;
    array.cam_url = cam_snapshot;
    console.log(array);
//$.parseJSON(results);   //JSON formatado como variável results no topo
    //$.redirect('http://relle.ufsc.br/labs/'+ id + '/report', array);
    $.ajax({
        type: "POST",
        url: location.pathname + "/report/",
        data: array, // results, //{a2: 'i'}, // results,
        success: function (pdf) {
            var win = window.open(location.pathname + "/report", '_blank');
            //   win.focus();
            console.log("Report created.");
        }
    });
}

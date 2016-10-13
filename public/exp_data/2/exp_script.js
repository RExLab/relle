$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

var rpi_server = "http://painelac1.relle.ufsc.br";
var socket = '';
var circuit_images = [0, 7, 11, 15];
var UIimg_interval = null;

$.getScript('http://relle.ufsc.br/exp_data/2/welcome.js', function () {
    var shepherd = setupShepherd();
    $('#return').prepend('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span> </button>');
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
        if (message && socket) {
            message.pass = $('meta[name=csrf-token]').attr('content');
            socket.emit('new message', message);
        }
        UIimg_interval = setTimeout(function () {
            if (circuit_images.indexOf(switches) >= 0) {
                console.log('loading /exp_data/2/equivalent/' + switches + '.png');
                $('.equivalent').attr('src', '/exp_data/2/equivalent/' + switches + '.png');
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


    $.getScript(rpi_server + '/socket.io/socket.io.js', function () {
        // Initialize varibles
        // Prompt for setting a username
        socket = io.connect(rpi_server);
        socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});

        socket.on('new message', function (data) {
            console.log(data);
        });

        $(".controllers").show();
        $(".loading").hide();

        // Whenever the server emits 'user joined', log it in the chat body
        socket.on('data received', function (data) {
            //printLog(data);
            results = $.parseJSON(data);
            console.log("I'm receiving " + data);

            for (var i = 0; i < 7; i++) {
                //console.log(results.amperemeter[i]);
                $("#a" + i).html(results.amperemeter[i] / 1000 + " mA");
            }
            for (var i = 0; i < 2; i++) {
                //console.log(results.voltmeter[i]);
                $("#v" + i).html(results.voltmeter[i] / 1000 + " V");
            }

        });
        // Limpar
        $('#btnLeave').on('click', function () {
            if (socket) {
                socket.disconnect();
                socket = null;
            }
        });


    });

});

function report(id) {
    var array = results; //$.parseJSON(results);   //JSON formatado como variável results no topo
    $.ajax({
        type: "POST",
        url: "http://relle.ufsc.br/lara/labs/" + id + "/report/",
        data: array, // results, //{a2: 'i'}, // results,
        success: function (pdf) {
            // window.open("http://relle.ufsc.br/lara/labs/" + id + "/report", "_TOP");
            //safari.self.browserWindow
            //window.focus();
            var win = window.open("http://relle.ufsc.br/lara/labs/" + id + "/report", '_blank');
            win.focus();
            console.log("Report created.");
        }
    });
}



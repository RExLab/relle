$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

var rpi_server = "http://150.162.232.4:8053";
var results = '{ "amperemeter": [123456789,1222,444,5678]}';
var socket = '';

$(function () {
    $('.switch').bootstrapToggle({
        onstyle: "success",
        offstyle: "danger",
        size: "small"
    });
    
    function sendMessage() {
        var message = {};
        message.sw = {};
        //collect data from inputs
        for (var i = 0; i < 7; i++) {
            if ($("input[id='sw" + i + "']:checked").length) {
                console.log('sw' + i + ': 1');
                message.sw[i] = 1;
            } else {
                console.log('sw' + i + ': 0');
                message.sw[i] = 0;
            }
        }
        console.log(message);
        if (message && socket) {
            message.pass = $('meta[name=csrf-token]').attr('content');
            socket.emit('new message', message);
        }
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
            if(socket){
                socket.disconnect();
                socket = null;
            }
        });
        
        $.getScript('http://relle.ufsc.br/exp_data/2/welcome.js', function () {
            var shepherd = setupShepherd();
             $('#return').prepend('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span> </button>');
             $('#btnIntro').on('click', function (event) {
                 event.preventDefault();
                 shepherd.start();
             });


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



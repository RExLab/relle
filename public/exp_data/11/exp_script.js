var rpi_server = "";
var results;
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
        message.pass =  $("#pass").html();
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
            message.pass = $("#pass").html();
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
        socket.emit('new connection', {pass: $("#pass").html()});

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
        
    });
});

function report(id) {
    var array = results; //$.parseJSON(results);   //JSON formatado como variável results no topo
    $.ajax({
        type: "POST",
        url: "http://relle.ufsc.br/labs/" + id + "/report/",
        data: array, // results, //{a2: 'i'}, // results,
        success: function (pdf) {
            var win = window.open("http://relle.ufsc.br/labs/" + id + "/report", '_blank');
            win.focus();
            console.log("Report created.");
        }
    });
}

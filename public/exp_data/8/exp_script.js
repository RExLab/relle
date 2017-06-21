var rpi_server = "http://relle.ufsc.br:8030";
var results;
var socket = '';

$(function () {
    $.getScript(rpi_server + '/socket.io/socket.io.js', function () {

            var socket = io.connect(rpi_server);
            socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});

            function sendMessage(key) {
                var message = {};
                message.key = key;
                message.sw = {};
                socket.emit('new message',message);
            }

            $('.chave').click(function () {
                var key = $(this).attr("name");
                console.log(key);
                sendMessage(key);

            });

            socket.on('initial', function (data) {
                console.log("Iniciou em: " + data.pos);
                setupUI(parseInt(data.pos));
                
            });

            // Whenever the server emits 'user joined', log it in the chat body
            socket.on('data received', function (data) {
                //printLog(data);
                results = JSON.parse(data);
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

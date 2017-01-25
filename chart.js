var rpi_server = "http://rexlab.ufsc.br:8059";
var t = new Date();
var start = 0;
var step;
var stephelp;
var interval, time_plotting = 4 * 60;
var timer = null;
var readings = [];
var url;

function done() {
    console.log('<img> carregada com sucesso');
    url = document.getElementById("canvas").toDataURL();
    document.getElementById("imagem").value = url;
}

/*
 *Graphs 
 */

var randomScalingFactor = function () {
    return Math.round(Math.random() * 100);
};
var lineChartData = {
    labels: [],
    datasets: [
        {
            label: "Barra 1",
            fillColor: "rgba(255, 211, 198, 0.1)",
            strokeColor: "#FDA98F",
            pointColor: "#FDA98F",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: []
        },
        {
            label: "Barra 2",
            fillColor: "rgba(151,187,205,0.1)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: []
        },
        {
            label: "Barra 3",
            fillColor: "rgba(130, 125, 143, 0.1)",
            strokeColor: "rgba(130, 125, 143, 0.9)",
            pointColor: "rgba(130, 125, 143, 0.9)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(130, 125, 143, 0.9)",
            data: []



        }
    ]

};

function init_chart() {
    console.log("Iniciando Grafico");
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myLine = new Chart(ctx).Line(lineChartData, {
        responsive: true
    });
}

function update_chart(thermos) {
    window.myLine.addData([thermos[0], thermos[3], thermos[6]], start);
    start = start + step;

}

function ResizeSamples(stepold) {
    lineChartData.labels = [];
    for (var i = 0; i < start; i = i + 2 * stepold) {
        lineChartData.labels.push(i);
    }
    console.log(lineChartData.labels);

    for (var j = 0; j < 3; j++) {
        var index = 0;
        var newarray = [];
        for (var i = 0; i < readings.length; i++) {
            if (i % (2 * (stepold / stephelp)) == 0) {
                newarray[index] = readings[i][3 * j];
                index++;
            }
        }
        console.log(" readings len: " + readings.length + " | new array len:" + newarray.length);
        lineChartData.datasets[j].data = newarray;
        console.log(lineChartData.datasets[j].data);
    }
    return;
}

$(function () {

    $.getScript('http://relle.ufsc.br/js/Chart.js', function () {

        init_chart();
    });


    $.getScript(rpi_server + '/socket.io/socket.io.js', function () {
        // Abre socket

        var mult = 0;
        var socket = io.connect(rpi_server);
        //Conecta-se enviando chave de acesso ao lab
        socket.emit('new connection', {pass: $("#pass").html()});

        // Send a message
        function sendMessage(status) {
            var message = {};
            message.sw = status;
            step = message.step = parseInt($("#step").val());
            message.duration = 240;
            stephelp = step;
            console.log(message);
            // if there is a non-empty message and a socket connection
            if (message) {
                var time = new Date();
                message.date = time;
                message.pass = "minhasenha334";
                // tell server to execute 'new message' and send along one parameter
                socket.emit('start', message);
                start = 0;
            }
        }


        // Eventos nas chaves


        // Servidor deve mandar leituras a cada intervalo de tempo estabelecido
        socket.on('data received', function (data) {
            var parsed = JSON.parse(data);
            readings.push(parsed.thermometers);
            //console.log("nova mensagem"); 
            if (mult == 0) {
                update_chart(parsed.thermometers);
            }
            mult = (mult + stephelp) % step;
            if (start > 0 && ((start % (stephelp * 16)) == 0) && step < 15) {
                step = step * 2;
                ResizeSamples(step / 2); //somente primeiros termometros
                window.myLine.destroy();
                var ctx = document.getElementById("canvas").getContext("2d");
                window.myLine = new Chart(ctx).Line(lineChartData, {
                    responsive: true
                });
            }
        });

        $('#start').click(function () {
            $(this).css({display: "none"});
            $("#stop").css({display: "block"});
            sendMessage(1);
        });

        $('#stop').click(function () {
            $(this).css({display: "none"});
            $("#start").css({display: "block"});
            sendMessage(0);
        });

        $('#btnLeave').on('click', function () {
            if (socket) {
                socket.disconnect();
                socket = null;
            }
        });


    });
});

function report(id) {
    url = document.getElementById("canvas").toDataURL();
    console.log('<img> converted');
    $.ajax({
        type: "POST",
        url: "http://relle.ufsc.br/labs/" + id + "/report/",
        data: {dados: url},
        success: function (pdf) {
            var win = window.open("http://relle.ufsc.br/labs/" + id + "/report", '_blank');
            console.log("Report created.");
        }
    });
}

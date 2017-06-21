$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

var rpi_server = "http://propagacaocalor1.relle.ufsc.br";
var t = new Date();
var start = 0;
var step;
var stephelp;
var interval, time_plotting = 4 * 60;
var timer = null;
var readings = [];
var url;

var lab_socket = null;

$.getScript('http://relle.ufsc.br/exp_data/5/welcome.js', function () {
    var shepherd = setupShepherd();
    addShowmeButton('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span></button>')
    $('#btnIntro').on('click', function (event) {
        event.preventDefault();
        shepherd.start();
    });

});


function done() {
    url = document.getElementById("canvas").toDataURL();
    document.getElementById("imagem").value = url;
}

var chart = {
    type: 'line',
    data: {
        datasets: [{
                label: lang.label1,
                data: [],
                backgroundColor: "rgba(75,192,192,0.4)"
            }, {
                label: lang.label2,
                data: [],
                backgroundColor: "rgba(255, 211, 198, 0.1)"
            }],
        xLabels: [lang.time],
        yLabels: [lang.temperature],
        labels: [lang.temperature]
    },
    options: {
        scales: {
            xAxes: [{
                    type: 'linear',
                    position: 'bottom'
                }]
        }
    }
};

function init_chart() {
    console.log("Iniciando Grafico");
    var ctx = document.getElementById("canvas").getContext("2d");


    if (typeof (window.myLine) != 'undefined')
        window.myLine.destroy();

    window.myLine = new Chart(ctx, chart);

}

function update_chart(thermos) {
    window.myLine.data.datasets[0].data.push({x: start, y: thermos[0]})
    window.myLine.data.datasets[1].data.push({x: start, y: thermos[1]})
    window.myLine.update();
    start = start + step;
}

function ResizeSamples(stepold) {
    window.myLine.data.datasets[0].data = [];
    window.myLine.data.datasets[1].data = [];

    for (var i = 0; i < start; i = i + 2 * stepold) {
        window.myLine.data.datasets[0].data.push({x: start, y: thermos[0]})
        window.myLine.data.datasets[1].data.push({x: start, y: thermos[1]})

    }

    for (var j = 0; j < 3; j++) {
        var index = 0;
        var newarray = [];
        for (var i = 0; i < readings.length; i++) {
            if (i % (2 * (stepold / stephelp)) == 0) {
                newarray[index] = readings[i][3 * j];
                index++;
            }
        }
    }
    window.myLine.update();
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $.getScript('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js', function () {
        init_chart();
    });

    $.getScript(rpi_server + '/socket.io/socket.io.js', function () {

        //var mult = 0;
        lab_socket = io.connect(rpi_server);

        $(".controllers").show();
        $(".loading").hide();

        $("#show-info span p").html(message[0]);
        $("#show-info").show();
        //$("#show-error span p").html(message[1]);
        //$("#show-error").show();
        //Conecta-se enviando chave de acesso ao lab
        lab_socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});

        // Send a message

        lab_socket.on('lab sync', function (data) {
            if (data.iscooling) {
                $("#show-error span p").html(message[1]);
                $("#show-error").show();
            }

        });
        // Servidor deve mandar leituras a cada intervalo de tempo estabelecido


        lab_socket.on('data received', function (data) {

            $("#m1").show();
            $("#m2").show();
            var parsed = JSON.parse(data);
            readings.push([parsed.thermometers[0], parsed.thermometers[1]]);
            //console.log("nova mensagem"); 
            //if (mult == 0) {
            update_chart(parsed.thermometers);
            /*var canvas = document.getElementById("canvas");
             var ctx = canvas.getContext("2d");
             ctx.font = "14px Arial";
             ctx.fillText("T[°C]",0,14);
             ctx.fillText("t[s]",canvas.width-20,canvas.height-10);*/
            //}
            //mult = (mult + stephelp) % step;
            /*if (start > 0 && ((start % (stephelp * 16)) == 0) && step < 10) {
             step = step * 2;
             ResizeSamples(step / 2); //somente primeiros termometros
             window.myLine.destroy();
             var ctx = document.getElementById("canvas").getContext("2d");
             window.myLine = new Chart(ctx).Line(lineChartData, {
             responsive: true
             });
             }*/
        });

        $('#start').click(function () {
            $(this).prop('disabled', true);
            sendMessage(1);
        });

        // TODO #btnLeaveExp
        $('#btnLeaveExp').on('click', LabLeaveSessionHandler);

    });
});

function report(id) {

    $.ajax({
        type: "POST",
        url: location.pathname + "/report/",
        data: {dados: url},
        success: function (pdf) {
            var win = window.open(location.pathname + "/report", '_blank');
            console.log("Report created.");
        }
    });
}

function LabLeaveSessionHandler() {
    if (document.getElementById("canvas") != null)
        url = document.getElementById("canvas").toDataURL();

    if (lab_socket) {
        sendMessage(0);
        lab_socket.disconnect();
        lab_socket = null;
    }
}

function sendMessage(status) { 
    var message = {};
    message.sw = status;
    step = message.step = parseInt($("#step").val());
    message.duration = parseInt($("#sourceduration").val());
    message.power = $('input:radio[name=power]:checked').val();
    stephelp = step;
    console.log(message);
    if (message) {
        var time = new Date();
        message.date = time;
        message.pass = $('meta[name=csrf-token]').attr('content');
        lab_socket.emit('start', message);
        start = 0;
    }
}

function exportcsv() {
    console.log("CSV data...");

    var data = [];
    for (var i = 0; i < readings.length; i++) {
        var dataline = {};
        dataline["time"] = i * stephelp;
        for (var j = 0; j < 2; j++) {
            dataline["Thermo" + (j + 1)] = readings[i][j];
        }
        data[i.toString()] = dataline;
    }
    $.redirect(location.pathname + '/export/', data);

}

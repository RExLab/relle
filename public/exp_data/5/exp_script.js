$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

var rpi_server = "http://relle.ufsc.br:8063";
var t = new Date();
var start = 0;
var step;
var stephelp;
var interval, time_plotting = 4 * 60;
var timer = null;
var readings = [];
var url;

function done() {
    url = document.getElementById("canvas").toDataURL();
    document.getElementById("imagem").value = url;
}

var randomScalingFactor = function () {
    return Math.round(Math.random() * 100);
};
var lineChartData = {
    labels: [],
    datasets: [
        {
            label: "Acima da fonte",
            fillColor: "rgba(255, 211, 198, 0.1)",
            strokeColor: "#FDA98F",
            pointColor: "#FDA98F",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: []
        },
        {
            label: "Na fonte",
            fillColor: "rgba(151,187,205,0.1)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: []
        },
        {
            label: "Abaixo da fonte",
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
    window.myLine.addData([thermos[0], thermos[1]], start);
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

$( function () {
    $('[data-toggle="tooltip"]').tooltip();  
    $.getScript('http://relle.ufsc.br/js/Chart.js', function () {
        init_chart();
    });

    $.getScript(rpi_server + '/socket.io/socket.io.js', function () {

        //var mult = 0;
        var socket = io.connect(rpi_server);
        
        $("#show-info span p").html(message[0]);
        $("#show-info").show();
        //$("#show-error span p").html(message[1]);
        //$("#show-error").show();
        //Conecta-se enviando chave de acesso ao lab
        socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});

        // Send a message
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
                socket.emit('start', message);
                start = 0;
            }    
        }
        
        
        socket.on('lab sync', function (data) {
            if(data.iscooling){
                $("#show-error span p").html(message[1]);
                $("#show-error").show();
            }
             
            
            
        });
        // Servidor deve mandar leituras a cada intervalo de tempo estabelecido
        
        
        socket.on('data received', function (data) {
            
            $("#m1").show();
            $("#m2").show();
            var parsed = JSON.parse(data);
            readings.push([parsed.thermometers[0],parsed.thermometers[1]]);
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


        $('#btnLeave').on('click', function () {
            if (socket) {
                sendMessage(0);
                socket.disconnect();
                socket = null;
            }
        });
        
        $.getScript('http://relle.ufsc.br/exp_data/5/welcome.js', function () {
            var shepherd = setupShepherd();
             $('#return').prepend('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span></button>');
             $('#btnIntro').on('click', function (event) {
                 event.preventDefault();
                 shepherd.start();
             });


        });


    });
});

function report(id) {
    url = document.getElementById("canvas").toDataURL();
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

function exportcsv(){
        console.log("CSV data...");

          var data =[] ;
         for(var i = 0; i < readings.length; i++){
               var dataline = {};
               dataline["time"] = i*stephelp; 
               for(var j= 0; j < 2; j++){
                    dataline["Thermo"+(j+1)] = readings[i][j];
                } 
               data[i.toString()] = dataline;
           }
           $.redirect(location.pathname+'/export/', data);
    
}


function startTour() {
    console.log('ready');
    var tour = introJs();
    tour.setOption('tooltipPosition', 'auto');
    tour.setOption('positionPrecedence', ['left', 'right', 'bottom', 'top']);
    tour.setOption("skipLabel", lang.leave);
    tour.setOption("prevLabel", lang.previous);
    tour.setOption("nextLabel", lang.next);
    tour.setOption("doneLabel", lang.done);
    tour.setOption('showProgress', true);

    tour.setOptions({
        steps: [
            {
                intro: lang.intro1
            },
            {
                element: 'img.cam',
                intro: lang.introcamera
            },
            {
                intro: lang.intro2
            },  
            {
                element: 'form.time',
                intro: lang.time
            },            
            {
                element: 'form.power',
                intro: lang.power
            },
            {
                element: 'input#start',
                intro: lang.start
            },            
            {
                element: '#canvas',
                intro: lang.chart
            },
            {
                element: 'div.alerts',
                intro: lang.alerts
            },
            
            {
                intro: lang.report
            }
            
        ]
    });
    
    tour.start();
}
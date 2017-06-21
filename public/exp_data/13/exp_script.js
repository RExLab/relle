$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

var rpi_server = "http://conducaocalor1.relle.ufsc.br";
var t = new Date();
var start = 0;
var step = 2;
var stephelp = 2;
var interval, time_plotting = 4 * 60;
var timer = null; 
var readings = [];
var url;
var $window = $(window);
window.charts = [];
var lab_socket= null;

$.getScript('http://relle.ufsc.br/exp_data/13/welcome.js', function () {
    var shepherd = setupShepherd();
    addShowmeButton('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span></button>')
    $('#btnIntro').on('click', function (event) {
        event.preventDefault();
        shepherd.start();
    });
});

function done() {
    console.log('<img> carregada com sucesso');
    url = document.getElementById("canvas").toDataURL();
    document.getElementById("imagem").value = url;
}

var randomScalingFactor = function () {
    return Math.round(Math.random() * 100);
};


var lineChartData = {
    labels: [],
    datasets: [{
            label: "Barra 1",
            fillColor: "rgba(255, 211, 198, 0.1)",
            strokeColor: "#FDA98F",
            pointColor: "#FDA98F",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: []
        }, {
            label: "Barra 2",
            fillColor: "rgba(151,187,205,0.1)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: []
        }, {
            label: "Barra 3",
            fillColor: "rgba(130, 125, 143, 0.1)",
            strokeColor: "rgba(130, 125, 143, 0.9)",
            pointColor: "rgba(130, 125, 143, 0.9)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(130, 125, 143, 0.9)",
            data: []



        }]

};

function init_chart() {
    if(document.getElementById("canvas") == null){
        console.log('canvas element not found')
        return;
    }
    var ctx = document.getElementById("canvas").getContext("2d");
    var chart = {};
    chart.lineChartData = lineChartData;
    chart.index = [0, 3, 6];
    chart.myLine = window.myLine = new Chart(ctx).Line(chart.lineChartData, {
        responsive: true
    });
    $("#canvas").width('');
    window.charts.push(chart);

}

function update_chart(thermos) {
    for (var cIndex = 0; cIndex < window.charts.length; cIndex++) {
        var data = [];
        for (var i = 0; i < window.charts[cIndex].index.length; i++) {
            data.push(thermos[window.charts[cIndex].index[i]]);
        }
        window.charts[cIndex].myLine.addData(data, start);
    }
    start = start + step;
    $('.labelx').show();
    $('.labely').show();
}

/*function update_chart(thermos) {
 window.myLine.addData([thermos[0], thermos[3], thermos[6]], start);
 start = start + step;
 }*/

function ResizeSamples(stepold) {
    lineChartData.labels = [];
    for (var i = 0; i < start; i = i + 2 * stepold) {
        lineChartData.labels.push(i);
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
        console.log(" readings len: " + readings.length + " | new array len:" + newarray.length);
        lineChartData.datasets[j].data = newarray;
        console.log(lineChartData.datasets[j].data);
    }
    return;
}

$(function () {
    $.getScript('http://relle.ufsc.br/js/Chart.js', function () {

        $(".grafico").show();
        $(".grafico.loading").hide();
    });


    $.getScript(rpi_server + '/socket.io/socket.io.js', function () {
        var mult = 0;
        lab_socket = io.connect(rpi_server);
        //Conecta-se enviando chave de acesso ao lab
        lab_socket.emit('new connection', {
            pass: $('meta[name=csrf-token]').attr('content')
        });
        $(".controllers").show();
        $(".controllers.loading").hide();

        // Send a message
        

        // Servidor deve mandar leituras a cada intervalo de tempo estabelecido
        lab_socket.on('data received', function (data) {
            var parsed = JSON.parse(data);
            readings.push(parsed.thermometers);
            if (mult == 0) {
                update_chart(parsed.thermometers);
            }

            mult = (mult + stephelp) % step;
            if (start > 0 && ((start % (stephelp * 16)) == 0) && step < 10) {
                step = step * 2;
                ResizeSamples(step / 2); //somente primeiros termometros
                /*for (var cIndex = 0; cIndex < window.charts.length; cIndex++) {
                 var data = [];
                 for (var i = 0; i < window.charts[cIndex].index.length; i++) {
                 
                 }
                 }*/
                window.myLine.destroy();
                var ctx = document.getElementById("canvas").getContext("2d");
                window.myLine = new Chart(ctx).Line(lineChartData, {
                    responsive: true
                });
            }
        });

        $('#start').click(function () {
            $(this).prop('disabled', true);
            $('#canvas').show();
            init_chart();
            $('.info-bars').hide();
            sendMessage(1);
        });

        // TODO trocar por #btnLeaveExp
        $('#btnLeaveExp').click(LabLeaveSessionHandler);
       

        $('#newvariable').on('click', function (event) {
            event.preventDefault();
            if ($('#matches div.row div').length < 17) {
                addNewVariable();
            }
        });

        $('#removevariable').on('click', function (event) {
            event.preventDefault();
            removeLastVariable();
        });

        $('#newchart').on('click', function (event) {
            event.preventDefault();
            var chart = addNewChart();
            var ctx = $('canvas.chart').last()[0].getContext("2d");
            chart.myLine = new Chart(ctx).Line(chart.lineChartData, {
                responsive: true
            });
            chart.id = Math.floor(Math.random() * 1000);
            $('canvas.chart').last().attr("id", chart.id);
            $('canvas.chart').last().width('');
            window.charts.push(chart);

            removeAllVariables();

            $('a.removechart').on('click', function (event) {
                event.preventDefault();
                removeChart($(this));
            });
        });

        $('.settings').show();
    });

});

function removeChart(elEvent) {
    var el = elEvent.parent('div.customchart');
    var deletebyid = parseInt(el.find('canvas').attr('id'));
    console.log(deletebyid);

    for (var i = 0; i < window.charts.length; i++) {
        if (window.charts[i].id == deletebyid) {
            window.charts[i].myLine.destroy();
            window.charts.splice(i, 1);
        }
    }
    el.remove();

}

function addNewVariable() {
    $('#matches div.row').append("<div class='versus col-lg-1 col-md-1 col-sm-1 col-xs-12'>x</div>" + "<div class='select-group col-lg-3 col-md-5 col-sm-5 col-xs-12'> " + "<select class='form-control'>" + "<option></option>" + "<option>M1-T1</option>" + "<option>M1-T2</option>" + "<option>M1-T3</option>" + "<option>M2-T1</option>" + "<option>M2-T2</option>" + "<option>M2-T3</option>" + "<option>M3-T1</option>" + "<option>M3-T2</option>" + "<option>M3-T3</option>" + "</select>" + "</div>");
}

function removeLastVariable() {
    if ($('#matches div.row div').length > 1) {
        $('#matches div.row div.select-group').last().remove();
        $('#matches div.row div.versus').last().remove();
    }
}

function removeAllVariables() {
    while ($('#matches div.row div').length > 1) {
        removeLastVariable();
    }
}

function addNewChart() {
    var chart = {};

    $("#custom-group").append('<div class="col-lg-6 col-sm-12 col-md-6 col-xs-12 customchart" >' + '<a href="#" class="removechart"><span class="glyphicon glyphicon-trash"></span></a>' + '<div class="labely">' + lang.temperature + ' [&#8451;]</div>' + '<canvas class="col-lg-12 chart" height="320" width="480">Aguarde, o gráfico está sendo configurado...</canvas>' + '<div class="labelx">' + lang.time + ' [s]</div>' + '</div>');

    var thisDiv = $("#custom-group div.customchart").last();
    thisDiv.append('<div class="row"></div>');
    chart.index = [];

    chart.lineChartData = {};
    chart.lineChartData.labels = [];
    for (var i = 0; i < start; i += stephelp) {
        chart.lineChartData.labels.push(i);
    }

    chart.lineChartData.datasets = [];

    $('#matches div.row div.select-group').each(function (index, element) {
        var variablename = $(element).find('select').val().split('-');
        if (variablename.length > 1) {
            thisDiv.find('div.row').append('<div class="col-sm-4 col-xs-4"> <canvas class="legend" style="background:' + lang.strokes[variablename[0] + '-' + variablename[1]] + ';"></canvas> ' + variablename[1] + ' ' + lang.metals[variablename[0]] + '</div>');
            var index = parseInt(variablename[1][1]) + 3 * (parseInt(variablename[0][1]) - 1) - 1;
            chart.index.push(index);
            var datatemp = [];
            for (var i = 0; i < readings.length; i++) {
                datatemp.push(readings[i][index]);
            }
            chart.lineChartData.datasets.push({
                label: "Barra 1",
                fillColor: "rgba(255, 211, 198, 0.1)",
                strokeColor: lang.strokes[variablename[0] + '-' + variablename[1]],
                pointColor: lang.strokes[variablename[0] + '-' + variablename[1]],
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: datatemp
            });
        }

    });
    console.log(chart);
    return chart;
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

function report(id) {
  
    console.log('<img> converted');
    console.log(url);
    $.ajax({
        type: "POST",
        url: location.pathname + "/report/",
        data: {
            dados: url
        },
        success: function (pdf) {
            var win = window.open(location.pathname + "/report", '_blank');
            console.log("Report created.");
        }
    });
}

function exportcsv() {
    console.log("CSV data...");

    var data = [];
    for (var i = 0; i < readings.length; i++) {
        var dataline = {};
        dataline["time"] = i * stephelp;
        for (var j = 0; j < 9; j++) {
            dataline["Thermo" + (j + 1)] = readings[i][j];
        }
        data[i.toString()] = dataline;
    }
    $.redirect('http://relle.ufsc.br/labs/export/', data);

}

function sendMessage(status) {
            var message = {};
            message.sw = status;
            step = message.step = parseInt($("#step").val());
            message.duration = 240;
            stephelp = step;
            console.log(message);
            if (message) {
                var time = new Date();
                message.date = time;
                message.pass = $('meta[name=csrf-token]').attr('content');
                lab_socket.emit('start', message);
                start = 0;
            }
            
            $('.labelx').show();
            $('.labely').show();

        }
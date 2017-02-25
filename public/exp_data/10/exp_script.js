$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

var rpi_server = "http://fotovoltaico1.relle.ufsc.br";
var results;
var $window = $(window);
window.charts = [];

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
        }
    ]

};

$.getScript('http://relle.ufsc.br/exp_data/10/welcome.js', function () {
    var shepherd = setupShepherd();
    addShowmeButton('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span></button>');
    $('#btnIntro').on('click', function (event) {
        event.preventDefault();
        shepherd.start();
    });
});

$.getScript('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js');

$(function () {
    $('head').append('<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" type="text/css" />');

    $('.switch').bootstrapToggle({
        onstyle: "success",
        offstyle: "danger",
        size: "small"
    });

    $.getScript('http://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js', function () {

        $(function () {
            $("#slider").slider({
                range: "min",
                value: 1750,
                min: 1000,
                max: 2500,
                slide: function (event, ui) {
                    $("#motor_pos").val(ui.value);
                }
            });
        });
    });

    $.getScript(rpi_server + '/socket.io/socket.io.js', function () {

        console.log('loading');
        socket = io.connect(rpi_server);

        $(".controllers").show();
        $(".loading").hide();
       
        socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});
        
        socket.on('reconnect', function () {
            socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')} );
        });

        socket.on('reconnecting', function () {
            console.log('reconnecting');
        });

        socket.on('sampling done', function (data) {
            $(".sampling").removeAttr("disabled");
            $(".hiddenchart").show();

            if (data.action == "charging")
                $("#sw0").bootstrapToggle('on');

            if (data.action == "discharging")
                $("#sw0").bootstrapToggle('off');


            var ctx = document.getElementById("canvas").getContext("2d");
            var chart = {
                type: 'line',
                data: {
                    datasets: [{
                            label: lang.voltage + ' [V] x ' + lang.time + ' [s]',
                            data: []
                        }]
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

            for (var i = 0; i < data.voltmeter.length; i++) {
                chart.data.datasets[0].data.push({
                    x: (data.period * i).toFixed(3),
                    y: data.voltmeter[i]
                });
            }
            console.log(chart.data.datasets[0].data);

            if (typeof (window.myLine) != 'undefined')
                window.myLine.destroy();

            window.myLine = new Chart(ctx, chart);

        });


        socket.on('voltage', function (data) {
            $("#voltage").val(data.voltmeter / 1000 + " V")
        });

        $("#send").click(function () {
            var data = {};
            data.motor = parseInt($("#motor_pos").val());
            console.log("Enviando " + (parseInt($("#motor_pos").val())));
            socket.emit('motor', data);
        });

        $('.switch').change(function (el) {
            var data = {};
            data[el.target.id] = $("input[id='" + el.target.id + "']:checked").length;
            socket.emit('switch', data);
        });

        $('.sampling').click(function (el) {
            $(".sampling").attr("disabled", true);
            var data = {};
            data.action = el.target.id;

            data.sampletime = $("#sampletime").val();
            console.log(data)
            socket.emit('sampling', data);
        });


        // $("#show-error span p").html(message[0]);
        // $("#show-error").show();


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

$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');
$('head').append('<link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.roundslider/1.3/roundslider.min.css" type="text/css"/>'); 
$.getScript('http://relle.ufsc.br/exp_data/15/welcome.js', function () {
    var shepherd = setupShepherd();
    addShowmeButton('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span></button>')

    $('#btnIntro').on('click', function (event) {
        event.preventDefault();
        shepherd.start();
    });
});


var rpi_server = "http://planoinclinado2.relle.ufsc.br";
var rotation = 0;
var readings = [];
var readingsfd = [];
var lab_socket = null;
var force = null;

$(function () {

    $.getScript("https://cdn.jsdelivr.net/jquery.roundslider/1.3/roundslider.min.js", function () {
        $("#slider").roundSlider({
            startAngle: -15,
            endAngle: 90,
            value: 0,
            min: -15,
            max: 90,
            sliderType: "min-range",
            handleShape: "dot",
            mouseScrollAction: true,
            create: function () {
                $('.rs-seperator').hide();
                $('.rs-tooltip-text').append('°');
            },
            change: function () {
                $('.rs-tooltip-text').append('°');
            }
        });
        
        if (window.DeviceOrientationEvent) {
            window.addEventListener("deviceorientation", function (event) {
                if (event.gamma > rotation + 20) {
                    rotation = rotation + 20;
                    $("#slider").roundSlider({value: rotation + 10})
                } else if (event.gamma < rotation - 20) {
                    rotation = rotation - 20;
                    $("#slider").roundSlider({value: rotation - 10})
                }
            });
        }
    });




    lab_socket = io.connect(rpi_server);
    lab_socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});

    lab_socket.on('message', function (data) {
        console.log(data);
    });

    $("#show-success span p").html(message[4]);
    $("#show-success").show();
    $(".controllers").show();
    $(".loading").hide();

    lab_socket.on('setup', function (data) {
        console.log(data);

        if (typeof (data.force) !== "undefined") {
            force = data.force;
            $('#forcax').val(data.forcex);
            console.log(data.force);
        }
        if (force != null) {
            $('#forcax').val(Math.sqrt(Math.pow(force, 2) - Math.pow(data.forcey, 2)).toFixed(1));
        } else {
            $('#forcax').val(data.forcex);
        }
        $('#forcay').val(parseFloat(data.forcey).toFixed(1));

        $(".angle").html(data.angle);
        if (data.status == 'ready') {
            $('#send').show();
            $('#drop').show();
            $('#setup').show();
            $('#send').on('click', function () {
                slideFunction($("[name='slider']").val());
            });
            $('#setup').on('click', function () {
                slideFunction(-15);
            });
        }

        if (typeof (data.error) !== "undefined") {
            $("#show-success").hide();
            $("#show-error span p").html(message[data.error - 1]);
            $("#show-error").show();
        }
        if (data.hold) {
            readingsfd.push(data);
        }

    });

    $('#drop').click(function () {
        var data = {};
        data.angle = $("[name='slider']").val();
        console.log(data);
        lab_socket.emit('drop', data);
    });

    lab_socket.on('preparing', function (data) {
        console.log("I'm receiving " + data);
    });

    lab_socket.on('erro', function (data) {
        console.log(data.message);
        if ($('#send:hidden').length > 0) {
            $('#send').show();
            $('#drop').show();
            $('#setup').show();
            $('#send').on('click', function () {
                slideFunction($("[name='slider']").val());
            });
            $('#setup').on('click', function () {
                slideFunction(-15);
            });
        }
    });

    lab_socket.on('lab done', function (data) {
        console.log(data);
        if (typeof (data.error) == "undefined") {
            readings.push(data);
            for (var i = 1; i < 6; i++) {
                $("#d" + i).html(data.time[i] - data.time[0]);
            }
            console.log(message[data.code - 1]);
            $("#show-error").hide();
            $("#show-success span p").html(message[data.code - 1]);
            $("#show-success").show();
        } else {
            console.log(message[data.error - 1]);
            $("#show-success").hide();
            $("#show-error span p").html(message[data.error - 1]);
            $("#show-error").show();
        }

    });

});

function slideFunction(angle) {
    var data = {};
    data.angle = angle;
    console.log(data.angle);
    lab_socket.emit('new angle', data);
    $('#send').off();
    $('#send').hide();
    $('#setup').off();
    $('#setup').hide();
}

function exportcsv() {
    console.log("CSV data...");
    var csv = [];
    var data = [];
    for (var i = 0; i < readingsfd.length; i++) {
        var dataline = {};
        dataline["Angle"] = readingsfd[i].angle;
        dataline["Force y [N]"] = readingsfd[i].forcey;
        dataline["Force x [N]"] = ((typeof (readingsfd[i].forcex) !== "undefined") ? readingsfd[i].forcex : '?');
        data[i.toString()] = dataline;
        console.log(dataline);

    }

    console.log(data);
    csv.push(data);
    data = [];
    for (var i = 0; i < readings.length; i++) {
        var dataline = {};
        dataline["Angle"] = readings[i].angle;
        for (var j = 0; j < readings[i].time.length; j++) {
            dataline["" + (j * 10) + " cm"] = readings[i].time[j];
        }
        data[i.toString()] = dataline;
        console.log(dataline);
    }
    csv.push(data);
    console.log(data);

    $.redirect('http://relle.ufsc.br/labs/export/', data);

}

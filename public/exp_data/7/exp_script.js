$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

var rpi_server = "http://189.8.209.100:30040";
var rotation = 0;
var readings = [];
var readingsfd = [];
var lab_socket = null;
var force = null;
$(function () {

    $("#slider").roundSlider({
        startAngle: -20,
        endAngle: 90,
        value: 0,
        min: -20,
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

    $.ajax({
        url: rpi_server + '/socket.io/socket.io.js',
        dataType: "script",
        timeout: 5 * 1000
    }).done(function () {
        initLabServerCom();
    }).fail(function () { 
        initLabServerCom({url:'http://relle.ufsc.br', path: '/inclinedplane1' });
    });

   
    function refreshWebCam(address) {
       $('.cam').attr('src', address + '/snapshot.jpg?' + Math.floor((Math.random() * 1000)));
    }

    function initLabServerCom(rpi_server_address) {
        if (typeof (rpi_server_address) != 'undefined') {
            console.log(rpi_server_address);
            lab_socket = io.connect(rpi_server_address.url, {path: rpi_server_address.path+'/socket.io'});
            setInterval(function () {
                refreshWebCam(rpi_server_address.url+rpi_server_address.path);
            }, 1000);
        } else {
            lab_socket = io.connect(rpi_server);
        }
        
        lab_socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});
        
        lab_socket.on('reconnect', function () {
            lab_socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')} );
        });
        
        lab_socket.on('message', function (data) {
            console.log(data);
        });
        $("#show-success span p").html(message[4]);
        $("#show-success").show();

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
                $('#send').on('click', slideFunction);
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

        $.getScript('http://relle.ufsc.br/exp_data/7/welcome.js', function () {
            var shepherd = setupShepherd();
            addShowmeButton('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span></button>')
            $('#btnIntro').on('click', function (event) {
                event.preventDefault();
                shepherd.start();
            });
        });
    }



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

function slideFunction() {
    var data = {};
    data.angle = $("[name='slider']").val();
    console.log(data.angle);
    lab_socket.emit('new angle', data);
    $('#send').off();
    $('#send').hide();
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
                element: '#slider',
                intro: lang.introslider,
                position: 'bottom'
            },
            {
                intro: lang.intro2
            },
            {
                element: '#send',
                intro: lang.introsend,
                position: 'top'
            },
            {
                element: '#drop',
                intro: lang.introdrop,
                position: 'top'
            },
            {
                element: 'div.tabela',
                intro: lang.introtabela,
                position: 'bottom'
            },
            {
                intro: lang.intro3
            },
            {
                element: 'div.forcay',
                intro: lang.introforcay,
                position: 'right'
            },
            {
                element: 'div.forcax',
                intro: lang.introforcax,
                position: 'left'
            },
            {
                element: '#alerts',
                intro: lang.introalerts,
                position: 'top'
            }

        ]
    });
    tour.start();
}
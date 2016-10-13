
var rpi_server = "http://disconewton1.relle.ufsc.br";
var results;
var socket = '';

$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

$.getScript('http://relle.ufsc.br/exp_data/9/welcome.js', function () {
    var shepherd = setupShepherd();
    $('#return').append('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span></button>');
    $('#btnIntro').on('click', function (event) {
        event.preventDefault();
        shepherd.start();
    });


});
$(function () {

    $.getScript("http://lab.subinsb.com/projects/jquery/colorDisc/raphael.js", function () {
        $.getScript('http://relle.ufsc.br/js/newtonDisk.js', function () {
            $(".quart .controllers").show();
            $(".quart .loading").hide();
            
            var speed = 0.01;
            var cd = $("#holder").colorDisc();

            $(".controls a").on("click", function () {
                s = speed;

                if ($(this).find('i').hasClass('fa-minus')) {
                    speed = speed * 2;
                } else if ($(this).find('i').hasClass('fa-plus')) {
                    speed = speed / 2;
                } else {
                    speed = s = prompt(message[1]);
                }
                $("#periodo").val(1 / s);
                s != null ? $("#holder").colorDisc("speed", s) : "";

            });

            $(".discs a").on("click", function () {
                color = $(this).data("color");
                if (color == "") {
                    color = prompt(message[0]);
                }
                colors = color.split(",");
                $("#holder").colorDisc(colors);
            });

        });
    });


    $('.switch').bootstrapToggle({
        onstyle: "success",
        offstyle: "danger",
        size: "small"
    });

    function sendMessage() {
        var message = {};
        message.sw = {};
        message.pass = $("#pass").html();
        for (var i = 0; i < 1; i++) {
            if ($("input[id='sw']:checked").length) {
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
        $(".switch.controllers").show();
        $(".terc .loading").hide();
        socket.on('new message', function (data) {
            console.log(data);
        });


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

function startTour() {
    var tour = introJs();
    tour.setOption('tooltipPosition', 'auto');
    tour.setOption('positionPrecedence', ['left', 'right', 'bottom', 'top']);
    tour.setOption("skipLabel", lang.leave);
    tour.setOption("prevLabel", lang.previous);
    tour.setOption("nextLabel", lang.next);
    tour.setOption("doneLabel", lang.done);
    tour.start();
}

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

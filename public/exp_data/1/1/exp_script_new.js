$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

$.getScript('http://relle.ufsc.br/exp_data/1/welcome.js', function () {
    var shepherd = setupShepherd();
    addShowmeButton('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span></button>')
    $('#btnIntro').on('click', function (event) {
        event.preventDefault();
        shepherd.start();
    });


});

var rpi_server = "http://paineldc1.relle.ufsc.br";
var results;
var lab_socket = '';
var switches = 0;
var UIimg_interval = null;
var circuit_images = [10, 12, 13, 14, 17, 18, 20, 21, 24, 30, 32, 34, 36, 37, 38, 4, 40, 42, 48, 5, 54, 58, 64, 65, 66, 67, 68, 69, 7, 70, 72, 73, 74, 8, 80, 81, 9, 96, 97];
$(function () {



    $('.switch').bootstrapToggle({
        onstyle: "success",
        offstyle: "danger",
        size: "small"
    });

    function reset() {
        var message = {};
        message.sw = {};
        message.pass = $('meta[name=csrf-token]').attr('content');

        for (var i = 0; i < 7; i++) {
            message.sw[i] = 0;
        }
        if (message && lab_socket) {
            message.pass = $('meta[name=csrf-token]').attr('content');
            lab_socket.emit('new message', message);
        }
    }

    function sendMessage() {
        clearTimeout(UIimg_interval);
        switches = 0;
        var message = {};
        message.sw = {};
        message.pass = $('meta[name=csrf-token]').attr('content');
        for (var i = 0; i < 7; i++) {
            if ($("input[id='sw" + i + "']:checked").length) {
                message.sw[i] = 1;
                switches = switches | 1 << i;
                console.log('switches: ' + switches);
            } else {
                message.sw[i] = 0;
            }
        }
        if (message && lab_socket) {
            message.pass = $('meta[name=csrf-token]').attr('content');
            lab_socket.emit('new message', message);
        }
        UIimg_interval = setTimeout(function () {
            if (circuit_images.indexOf(switches) >= 0) {
                console.log('loading /exp_data/3/resultante/' + switches + '.png');
                $('.equivalent').attr('src', '/exp_data/3/equivalent/' + switches + '.png');
                $('.default_circuit').hide().addClass('hiddencircuit');
                $('.equivalent').show().removeClass('hiddencircuit');
            } else {
                $('.equivalent').hide().addClass('hiddencircuit');
                $('.default_circuit').show().removeClass('hiddencircuit');
                console.log('resultante ' + switches + ' nao criada ainda');
            }
        }, 3000);
    }

    $('.switch').change(function () {
        sendMessage();
    });


    // Initialize varibles
    // Prompt for setting a username
    lab_socket = io.connect(rpi_server);
    lab_socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});

    $(".controllers").show();
    $(".loading").hide();

    lab_socket.on('new message', function (data) {
        console.log(data);
    });


    lab_socket.on('data received', function (data) {
        //printLog(data);
        results = $.parseJSON(data);
        console.log("I'm receiving " + data);

        for (var i = 0; i < 7; i++) {
            if (!isNaN(results.amperemeter[i])) {
                $("#a" + i).html(parseFloat(results.amperemeter[i] / 1000).toFixed(1) + " mA");
            }
        }
        for (var i = 0; i < 2; i++) {
            if (!isNaN(results.amperemeter[i])) {
                $("#v" + i).html(parseFloat(results.voltmeter[i] / 1000).toFixed(2) + " V");
            }
        }

    });
    
    lab_socket.on('reconnect', function() {
            alert('reconnect fired!');
    });
});

function report(id) {
    var array = results;
    var image = '';
    if ($('.equivalent.hiddencircuit').length > 0) {
        image = $('img.default_circuit').attr('src');
    } else {
        image = $('.equivalent').attr('src');
    }

    array.equivalent = image;
//$.parseJSON(results);   //JSON formatado como variável results no topo
    //$.redirect('http://relle.ufsc.br/labs/'+ id + '/report', array);
    $.ajax({
        type: "POST",
        url: location.pathname + "/report/",
        data: array, // results, //{a2: 'i'}, // results,
        success: function (pdf) {
            var win = window.open(location.pathname + "/report", '_blank');
            //   win.focus();
            console.log("Report created.");
        }
    });
}


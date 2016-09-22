$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

var rpi_server = "http://relle.ufsc.br:8090";



function setupUI(id) {
    $("#plant").attr('src', path + image[id]);
    $("#sample").text(sample[id]);
    $("#sampledescription").text(description[id]);

}

$(function () {


    $.getScript(rpi_server + '/socket.io/socket.io.js', function () {
        // Initialize varibles
        // Prompt for setting a username
        var socket = io.connect(rpi_server);
        socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});

        function sendMessage(key) {
            var message = {};
            message.key = key;
            message.sw = {};
            socket.emit('new message', message);
        }

        // Eventos nas chaves
        $('.chave').click(function () {
            var key = $(this).attr("name");
            console.log(key);
            sendMessage(key);

        });

        socket.on('initial', function (data) {
            console.log("Iniciou em: " + data.pos);
            setupUI(parseInt(data.pos));

        });

        $("#loading-button").hide();
        $(".content-micro").show();
        
           
        $.getScript('http://relle.ufsc.br/exp_data/6/welcome.js', function () {
            var shepherd = setupShepherd();
             $('#return').prepend('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span> </button>');
             $('#btnIntro').on('click', function (event) {
                 event.preventDefault();
                 shepherd.start();
             });
        });


    });
    
    $.getScript('http://relle.ufsc.br/exp_data/6/zoom.js', function () {
        $('#img-zoomed').zoom({on: 'mouseover'});
    });


});


function report(id) {
    var array = $.parseJSON(results);   //JSON formatado como variável results no topo
    console.log(array);
    $.ajax({
        type: "POST",
        url: "/lara/labs/" + id + "/report/",
        data: array, // results, //{a2: 'i'}, // results,
        success: function (pdf) {
            // window.open("https://relle.ufsc.br/lara/labs/" + id + "/report", "_TOP");
            //safari.self.browserWindow
            //window.focus();
            var win = window.open("https://relle.ufsc.br/lara/labs/" + id + "/report", '_blank');
            win.focus();
            console.log("Report created.");
        }
    });
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
                intro: lang.camera1
            },
            {
                element: 'span.zoom',
                intro: lang.camera2
            },
            {
                element: 'div.content-micro.samples',
                intro: lang.samples
            },
            {
                element: 'div.content-micro.buttons',
                intro: lang.buttons
            }        
        ]
    });
    
    tour.start();
}
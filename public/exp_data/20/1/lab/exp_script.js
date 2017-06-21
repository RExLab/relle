$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');

var rpi_server = "http://microscopio1.relle.ufsc.br";
var lab_socket = null; 

$.getScript('http://relle.ufsc.br/exp_data/6/welcome.js', function () {
    var shepherd = setupShepherd();
    addShowmeButton('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span></button>')
    $('#btnIntro').on('click', function (event) {
        event.preventDefault();
        shepherd.start();
    });
});

function setupUI(id) {
    $("#plant").attr('src', path + '/' + image[id]);
    $("#sample").text(sample[id]);
    $("#sampledescription").text(description[id]);

}

$.getScript('http://relle.ufsc.br/exp_data/6/zoom.js', function () {
    $('#img-zoomed').zoom({on: 'mouseover'});
});

$(function () {


    $.getScript(rpi_server + '/socket.io/socket.io.js', function () {
        // Initialize varibles
        // Prompt for setting a username
        lab_socket = io.connect(rpi_server);
        lab_socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});
        
        lab_socket.on('reconnect', function () {
            lab_socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')} );
        });
        
        function sendMessage(key) {
            var message = {};
            message.key = key;
            message.sw = {};
            lab_socket.emit('new message', message);
        }

        // Eventos nas chaves
        $('.chave').click(function () {
            var key = $(this).attr("name");
            console.log(key);
            sendMessage(key);

        });

        lab_socket.on('initial', function (data) {
            console.log("Iniciou em: " + data.pos);
            setupUI(parseInt(data.pos));

        });

        $(".controllers").show();
        $(".loading").hide();

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

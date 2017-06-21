var chat_server = "http://rexlab.ufsc.br:3000";
var socket;
var $window = $(window);

$('#name').val(Math.floor(Math.random() * 1000));

var commands = ["cima", "baixo", "direita", "esquerda", "agarra", "solta"];

var myUser = {username: $('#name').val(),
    avatar: "lea",
    id: Math.floor((Math.random() * 1000) + 1)
};

function add_move(event, ui) {

    if ($(".final").last().hasClass('cima') && ui.draggable.hasClass("cima") ||
            $(".final").last().hasClass('baixo') && ui.draggable.hasClass("baixo") ||
            $(".final").last().hasClass('agarra') && ui.draggable.hasClass("agarra") ||
            $(".final").last().hasClass('solta') && ui.draggable.hasClass("solta")
            ) {
        red = ' red';
        $(".order").sortable('refresh');
    }
    var obj = '<li class="final ' + ui.draggable.attr("class") + red + '"></li>';
    $('.espera').before(obj);
    $(".order").sortable('refresh');
    $(".cmd").draggable({
        helper: "clone",
        snap: '.espera',
        revert: "invalid"
    });
    red = '';
    /*var data = {
     direction: collect_list()
     };
     data.user = myUser;
     console.log(data);
     socket.emit('move', data); */
}

function collect_list() {
    var list = [];
    for (var i = 0; i < $('.final').length; i++) {
        var className = $('.final')[i].className.split(' ')[5];
        list.push(className);
    }
    console.log(list);
    return list;
}
function add_avatars(avatar) {
    avatar = (avatar == 'undefined') ? 'max' : avatar;
    //$(".avatar-box").append('<img src="'+avatar+'.png" >'); 
    console.log(avatar);
}

function add_commands(list) {
    $('.cmd_box .row div').remove();
    console.log(list);
    for (var i = 0; i < list.length; i++) {
        $(".cmd_box .row").append("<div class='col-lg-6 col-sm-6 col-xs-6 cmd " + commands[parseInt(list[i])] + " ui-draggable ui-draggable-handle' id='btn_" + commands[parseInt(list[i])] + "'></div>");
    }
    $(".cmd").draggable({
        helper: "clone",
        snap: '.espera',
        revert: "invalid"
    });
}

function receive_move(direction) {
    $('.final').remove();
    console.log(direction);
    for (var i = 0; i < direction.length; i++) {
        $('.espera').before('<li class="final col-lg-6 col-sm-6 col-xs-6 cmd ' + direction[i] + ' ui-draggable ui-draggable-handle"></li>');
    }
    $(".order").sortable('refresh');

    $(".cmd").draggable({
        helper: "clone",
        snap: '.espera',
        revert: "invalid"
    });

}

function receive_rooms(direction) {
    $('.final').remove();
    console.log(direction);
    for (var i = 0; i < direction.length; i++) {

        $('.espera').before('<li class="final col-lg-6 col-sm-6 col-xs-6 cmd ' + direction[i] + ' ui-draggable ui-draggable-handle"></li>');
    }
}

function animatePoof() {
    var bgTop = 0;

    var frames = 5;
    var frameSize = 32;
    var frameRate = 80;
    for (i = 1; i <= frames; i++) {
        $('#puff').animate({
            backgroundPosition: '0 ' + (bgTop + frameSize) + 'px'
        }, frameRate);
        bgTop += frameSize;
        console.log($('#puff').css('backgroundPosition'));
    }
    setTimeout("$('#puff').hide()", frames * frameRate);
}



$.getScript('http://rexlab.ufsc.br:3000/socket.io/socket.io.js', function () {

    socket = io.connect(chat_server);

    var myTurn = false;

    socket.on('available rooms', function (data) {
        console.log(data);
        $('#room option').remove();
        for (var i = 0; i < data.name.length; i++) {
            $("#room").append($('<option>', {
                value: data.name[i],
                text: data.name[i] + " - " + data.nUsers[i]
            }));
        }

    });

    socket.on('move', function (data) {
        console.log("move");
        console.log(data);
        receive_move(data.direction);
    });



    socket.on('user disconnected', function (data) {
        console.log(data);
        for(var i = 0; i < data.length; i++){
            if(data[i].username === myUser.username){
                add_commands(data[i].commands);
            }
        }
    });

    socket.on('changeround', function (data) {
        console.log(" vez de " + data.username + " jogar");
        myTurn = (data.username === myUser.username);

    });


    socket.on('preemption', function (data) {
        console.log("preemption");
        if (myTurn) {
            data = {
                direction: collect_list()
            };
            socket.emit('move', data);
        }
    });



    socket.on('user joined', function (data) {
        console.log(data);
        if (data.username === myUser.username) {
            add_commands(data.commands);
        } else {
            add_avatars(data.avatar);
        }
    });

    $window.keydown(function (event) {
        if (event.which === 13) {
            var res = {selectedRoom: $("#room").val()};
            $("#teamname").html($("#room").val());
            res.user = myUser;
            socket.emit('new connection', res);
            $("#front").hide();
            $("#lista").show();
        }
    });

});


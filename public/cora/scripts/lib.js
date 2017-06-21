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
    red = '';
    
    move(obj);
}

function receive_move(direction){
    $('.espera').before(direction);
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
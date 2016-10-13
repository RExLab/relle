$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');
$(function () {


    $.getScript('http://relle.ufsc.br/exp_data/16/welcome.js', function () {
        var shepherd = setupShepherd();
        $('#return').prepend('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span> </button>');
        $('#btnIntro').on('click', function (event) {
            event.preventDefault();
            shepherd.start();
        });

    });

});


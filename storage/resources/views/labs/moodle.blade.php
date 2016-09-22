
<meta name="csrf-token" content="{{ csrf_token() }}" />

<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('/css/btn.css') }}" rel="stylesheet">
<link href="{{ asset('/css/jasny-bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('/css/switch.css') }}" rel="stylesheet">

<link rel="shortcut icon" type="image/x-icon" href="{{asset('/favicon.png')}}"/> 


<!-- Fonts -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
<script src="{{ asset('/js/jasny-bootstrap.js') }}"></script>
<script src="{{ asset('/js/switch.js') }}"></script>

<div id='body' style="height: 800px; margin-top:40px;">

<?php
$files = 'exp_data/' . $exp['id'] . '/';
?>

<!--{{$name='name_'.App::getLocale()}}
<!--{{$desc='description_'.App::getLocale()}}
-->

<link href="http://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="http://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>

<div id='identifier'></div>
<div id='close'></div>
<div id='return'></div>
<div id='error'></div>

<div id='pre_experiment'>
    <div class="col-lg-4">
        <img src='{{asset($exp['thumbnail'])}}' width="350px" />
    </div>
    <div class="col-lg-8">
        <h1>{{$exp[$name]}}</h1>
        <p>
            <strong>{{trans('labs.description')}}: </strong>
            {{$exp[$desc]}}
        </p>
        <p>
            <strong>{{trans('labs.subject')}}: </strong>
            <span id="subject"> {{trans('labs.'.$exp['subject'])}}</span> 
        </p>
        <p>
            <strong>{{trans('labs.duration')}}: </strong>
            <span id="duration"> {{$exp['duration']}}</span> 
            {{trans('interface.minutes')}}
        </p>


        <a href="#" id="access" class="btn btn-fresh" role="button">{{trans('interface.access')}}</a>
    </div>
</div> 

<center><div id='exp'></div></center>

</div>
<script>
        $("#link").click(function () {
$("#embeed").show().select();
});
        $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
        });
<?php
if (Auth::check()) {
    $user = Auth::user()->id;
} else {
    $user = 0;
}
?>

function log_entry() {
var json = {
user_id: '{{$user}}',
        lab_id: '{{$exp['id']}}'
        };
        $.ajax({
        type: "POST",
                url: "http://relle.ufsc.br/log/put",
                data: json
        });
}
</script>


<script>
    var url = '{{asset("/exp_data/".$exp['id'])}}';
            var html = url + "/{{App::getLocale()}}.html";
            var js = url + '/exp_script.js';
            var css = url + '/exp_style.css';
            var urlqueue = 'http://' + window.location.hostname + '/api';
            var duration = parseInt('{{$exp['duration']}}');
            var exp_id = parseInt('{{$exp['id']}}');
            var close_message = "<p> {{trans('interface.closelab')}}</p> <p>{{trans('interface.redirect')}}</p><br>";
            function loadLab(data){
            $('#pre_experiment').remove();
                    log_entry();
                    $('#error').html("");
                    $('head').append('<link rel="stylesheet" href=' + css + ' type="text/css" />');
                    $('#return').css('margin-top', '-3%');
                    $('#return').css('margin-bottom', '3%');
                    $('#return').addClass('well well-sm');
                    $('#return').html('<button id="btnLeave" class="btn btn-sm btn-default" name="leave" >{{trans('interface.leave')}}</button>' +
                    "{{trans('interface.timeleft')}}: " +
                    "<span id='min'>" + data.clock.min + "</span>:<span id='seg'>" + data.clock.seg + "</span>");
                    $('#exp').load(html, function() {
            $.getScript(js);
                    $.getScript("/js/queue.js", function () {
                    refresh = setInterval(RefreshTimeAlive, 5000); // Intervalo para refresh da fila (5 em 5 segundos deve mandar um POST para identificar que usuario continua conectado)  
                            setTimeout(LeaveExperiment, duration * 60 * 1000); // Agenda a execucao da funcao que envia um POST com action de deixar experimento
                            timer = setInterval(TimerMinus, 1000); // Refresh do contador visual
                            $("#btnLeave").click(LeaveExperiment);
                    });
                    $('#report').replaceWith('<input class="btn" onClick="report({{$exp['id']}})" type="button"  value="{{trans('labs.report')}}">');
                    $("#exp").find('img').each(function () {
            if ($(this).prop("src").indexOf("exp_data") == - 1 && $(this).prop("src").indexOf("relle") > 0) {
            var url = $(this).prop("src");
                    console.log('!:' + url);
                    var right = url.replace('http://relle.ufsc.br/labs', 'http://relle.ufsc.br/exp_data/{{$exp['id']}}');
                    $(this).attr('src', right);
            }
            });
            });
            }



    function waitLab(data){
    $('#error').html("");
            $('#return').html("");
            if (data.clock.min < 0 || data.clock.seg < 0){
    data.clock.min = data.clock.seg = 0;
    }
    $('#error').append(
            "<div class='alert alert-warning alert-dismissible'>" +
            "<button id='btnLeave' class='btn btn-warning btn-sm' name='leave'>{{trans("interface.leave")}}</button>&nbsp;&nbsp;" +
            "<div class='col-xs-4'>" +
            "<strong>{{trans('interface.wait')}}</strong><span id='nwait'>" + data.wait + " </span>&nbsp;&nbsp;" +
            "</div><div class='col-xs-4'>" +
            "<strong>{{trans('interface.timeleft')}}: </strong>" +
            "<span id='min'>" + data.clock.min + "</span>:<span id='seg'>" + data.clock.seg + "</span>" +
            '</div>' +
            '</div>');
            $("#access").css("display", "none");
            $.getScript("/js/queue.js", function () {
            refresh = setInterval(Refresh, 200);
                    timer = setInterval(TimerMinus, 1000);
                    $("#btnLeave").click(LeaveExperiment);
            });
    }

    function errorLab(){
    $('#error').html("");
            $('#error').html(
            "<div class='alert alert-warning alert-dismissible'>" +
            '<button id="btnLeave" class="btn btn-warning btn-sm" name="leave">{{trans("interface.leave")}}</button>' +
            "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
            "{{trans('message.tab')}}" +
            '</div>'
            );
            $.getScript("/js/queue.js", function () {
            $("#btnLeave").click(LeaveExperiment);
            });
    }

    $("#access").click(function () {
    var json = { 'exp_id': exp_id,
            'pass': $('meta[name=csrf-token]').attr('content'),
            'exec_time':duration };
            $.ajax({
            type: "POST",
                    url: urlqueue + "/queue",
                    data: json,
                    success:function(data){
                    data = $.parseJSON(data);
                            if (data['message'] == 'first'){
                    loadLab(data);
                    } else if (data.wait) {
                    waitLab(data);
                    } else{
                    errorLab();
                    }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                    errorLab();
                    }

            });
            $(window).on('beforeunload', function () {
    var jsonlogout = {
    time: Math.round( + new Date() / 1000),
            lab_id: exp_id
    };
            $.ajax({
            type: "POST",
                    url: "http://relle.ufsc.br/log/end",
                    time: jsonlogout
            });
            LeaveExperiment();
    });
    });

</script>

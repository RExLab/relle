@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>$exp['name_'.App::getLocale()]])}}
@stop

<?php
$files = 'exp_data/' . $exp['id'] . '/';
?>

<!--{{$name='name_'.App::getLocale()}}
<!--{{$desc='description_'.App::getLocale()}}
-->
@section ('content')

<div id='identifier'></div>
<div id='close'></div>
<div id='return'></div>
<div id='error'></div>


<div id='pre_experiment'>
<?php
$browser = get_browser($_SERVER['HTTP_USER_AGENT'], true)['browser'];
$mobile = get_browser($_SERVER['HTTP_USER_AGENT'], true)['ismobiledevice'];
if ($exp['id']=='6' && $browser == 'Safari') {
echo '<div class="alert alert-danger" role="alert" style="height:30px; padding-top:5px">'
. '<b>' . trans('message.sorry') . '. </b>'
. trans('message.browser_micro')
. '</div>';
}

if($exp['id']=='8'){
    if(App::getLocale()=='pt'){
        $exp[$desc] = substr($exp[$desc], 41, 74);
    }else{
        $exp[$desc] = substr($exp[$desc], 41, 61);
    }
}
?>
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
        <p>
            <a href='#'id='link' >{{trans('labs.embeed')}}</a><br>
            <input id='embeed' style='display:none;' type='text' 
                   value='<object width="100%" height="450px" data="http://relle.ufsc.br/labs/{{$exp['id']}}/moodle"></object>' 
                   class='col-lg-6' readonly/><br>
        </p>

        <a href="#" id="access" class="btn btn-fresh" role="button">{{trans('interface.access')}}</a>
    </div>
</div> 

<center><div id='exp'></div></center>
<div id="leave"></div> 
@stop   

@section('script')

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
<?php if (!$exp['queue']) { ?>
    <script>
        $(function(){

        var url = '{{asset("/exp_data/".$exp['id'])}}';
                var html = url + "/{{App::getLocale()}}.html";
                var js = url + '/exp_script.js';
                var css = url + '/exp_style.css';
        $('#access').click(function(){
                $('#pre_experiment').remove();
                //log_entry();
                $('head').append('<link rel="stylesheet" href=' + css + ' type="text/css" />');
                $('#exp').load(html)
                $.getScript(js);
        });
        });</script>
<?php } ?>




<?php if ($exp['queue']) { ?>
    <script>
                var url = '{{asset("/exp_data/".$exp['id'])}}';
                var html = url + "/{{App::getLocale()}}.html";
                var js = url + '/exp_script.js';
                var css = url + '/exp_style.css';
                var urlqueue = 'http://' + window.location.hostname + '/api/';
                var duration = parseInt('{{$exp['duration']}}');
                var exp_id = parseInt('{{$exp['id']}}');
                var close_message = "<p> {{trans('interface.closelab')}}</p> <p>{{trans('interface.redirect')}}</p><br>";
                var rep = '';
                var popup = '';
                function loadLab(data){
                    
                    $('#pre_experiment').remove();
                    log_entry();
                    $('#error').html("");
                    $('head').append('<link rel="stylesheet" href=' + css + ' type="text/css" />');
                    $('#return').css('margin-top', '-3%');
                    $('#return').css('margin-bottom', '3%');
                    $('#return').addClass('well well-sm');
                    $('#return').html('<button id="btnLeave" class="btn btn-sm btn-default" name="leave">{{trans('interface.leave')}}</button>' +
                    "{{trans('interface.timeleft')}}: " + "<span id='min'>" + data.clock.min + "</span>:<span id='seg'>" + data.clock.seg + "</span>");
                    $('#exp').load(html, function() {
                        
                        $.getScript(js);
                        $.getScript("/js/queue.js", function () {
                        refresh = setInterval(RefreshTimeAlive, 5000); // Intervalo para refresh da fila (5 em 5 segundos deve mandar um POST para identificar que usuario continua conectado)  
                                setTimeout(LeaveExperiment, duration * 60 * 1000); // Agenda a execucao da funcao que envia um POST com action de deixar experimento
                                timer = setInterval(TimerMinus, 1000); // Refresh do contador visual

                            $("#btnLeave").click(function(){
                                $('#exp').hide();
                                $('#return').remove();
                                var end = '{{trans("labs.end")}}';

                                if ($('#report').length != 0){
                                    popup = '<div class="alert alert-info" role="alert"><strong>{{trans('interface.atention')}}, </strong>{{trans('interface.popup')}}</div>';
                                    rep = '<input class="btn" onClick="report({{$exp['id']}})" type="button"  value="{{trans('labs.report')}}"/>';
                                    end = '{{trans("labs.end_rep")}}';

                                }
                                 if ($('#csv').length != 0){
                                    popup = '<div class="alert alert-info" role="alert"><strong>{{trans('interface.atention')}}, </strong>{{trans('interface.popup')}}</div>';
                                    console.log("csv ok");
                                    rep += ' <input class="btn" onClick="exportcsv()" type="button"  value="{{trans('labs.csvexport')}}"/>';                                   
                                 }

                                $('#leave').replaceWith(
                                        popup+
                                        '<div class="well">' +
                                        '<center>' +
                                        end +  
                                        '<br><br>' +
                                        '<input class="btn" onClick="LeaveExperiment()" type="button"  value="{{trans('interface.leave')}}"/>' +
                                        rep +
                                        '</center>' +
                                        '</div>'
                                );
                            });

                        });
                                //$('#report').append('<input class="btn" onClick="report({{$exp['id']}})" type="button"  value="{{trans('labs.report')}}">');
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
                if (data.clock.min <= 0 || data.clock.seg <= 0){
                     data.clock.min = data.clock.seg = 0;
                }else{
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
                }
                $("#access").css("display", "none");
                $.getScript("/js/queue.js", function () {
                    refresh = setInterval(Refresh, 1);
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
             $("#access").off();
            var json = { 'exp_id': exp_id,
                'pass': $('meta[name=csrf-token]').attr('content'),
                'exec_time':duration };
                $.ajax({
                    type: "POST",
                    url: urlqueue + "queue",
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
       
        });

    </script>
<?php } ?>
@stop
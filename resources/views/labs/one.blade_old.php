@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>$exp['name_'.App::getLocale()]])}}
@stop
{{Analytics::trackEvent('Experimento', $exp['name_pt'])}}

@section('head')
<link href="{{ asset('/css/one.css') }}" rel="stylesheet">
@stop
<!-- Facebook Comments  -->
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=1771373809748322";
            fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<div id="fb-root"></div>
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

    if ($exp['id'] == '8') {
        if (App::getLocale() == 'pt') {
            $exp[$desc] = substr($exp[$desc], 41, 74);
        } else {
            $exp[$desc] = substr($exp[$desc], 41, 61);
        }
    }
    ?>

    <div class="row">
        <div class="col-md-8 col-sm-12">
            <h3>{{$exp[$name]}}</h3>
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
                <strong>Tags: </strong> <span id="tags-lab"></span>

                </span> 
            </p>
            <p>
                <strong>{{trans('labs.embeed')}}: </strong>
                <input id='embeed' type='text' 
                       value='<object width="100%" height="450px" data="http://relle.ufsc.br/labs/{{$exp['id']}}/moodle"></object>' 
                       readonly/><br>
            </p>  


            <a href="#" id="access" class="btn btn-primary" role="button">{{trans('interface.access')}}</a>


            <?php if (!isMobile($_SERVER['HTTP_USER_AGENT'])) { ?>
                @include('labs.suggestion') 

            <?php } ?>
        </div>
        <!-- END OF LEFT -->

        <div class="col-md-4 col-sm-12 right-menu">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#tab_video" aria-expanded="true" aria-controls="collapseOne">
                    <div class="panel">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <i class="fa fa-play" aria-hidden="true" style="padding-right: 10px"></i>  Vídeo
                            </h4>
                        </div>
                    </div>
                </a>
                <div id="tab_video" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body tab-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{$exp['video']}}" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#tab_tutorial" aria-expanded="true" aria-controls="collapseOne">
                    <div class="panel">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <i class="fa fa-info" aria-hidden="true" style="padding-right: 10px"></i>  Tutorial
                            </h4>
                        </div>
                    </div>
                </a>
                <div id="tab_tutorial" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body  tab-body">
                        <?php echo $exp['tutorial_' . App::getLocale()]; ?>
                    </div>
                </div>
            </div>
            @if(!empty($docs['did']))
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#tab_material" aria-expanded="true" aria-controls="collapseOne">
                    <div class="panel">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <i class="fa fa-book" aria-hidden="true" style="padding-right: 10px"></i>  Material Didático
                            </h4>
                        </div>
                    </div>
                </a>

                <div id="tab_material" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body tab-body" style="padding:10px 0;">
                        @foreach($docs['did'] as $doc)
                        <div class="col-md-6">
                            <a href="{{asset($doc['url'])}}" target="_blank">
                                <img src="{{asset('img/docs/'.formatIcon($doc['format']).'.png')}}" height="60px" align="left" style="padding-left:0;">
                                <span style="font-size: 10pt; line-height: 1; color:#7B8996">{{$doc['title']}}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if(!empty($docs['tec']))
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#tab_docs" aria-expanded="true" aria-controls="collapseOne">
                    <div class="panel">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <i class="fa fa-file-text-o" aria-hidden="true" style="padding-right: 10px"></i>  Documentação
                            </h4>
                        </div>
                    </div>
                </a>
                <div id="tab_docs" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body tab-body"  style="padding:10px 0;">
                        @foreach($docs['tec'] as $doc)
                        <div class="col-md-6">
                            <a href="{{asset($doc['url'])}}" target="_blank">
                                <img src="{{asset('img/docs/'.formatIcon($doc['format']).'.png')}}" height="60px" align="left" style="padding-left:0;">
                                <span style="font-size:10pt; line-height: 1; color:#7B8996">{{$doc['title']}}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        <?php if (isMobile($_SERVER['HTTP_USER_AGENT'])) { ?>
            <div class="col-md-8 col-sm-12">
                @include('labs.suggestion')
            </div>
        <?php } ?>

    </div>
</div>
<center><div id='exp'></div></center>
<div id="leave"></div> 
@stop   

@section('script')
<script src="{{ asset('js/tether.js') }}"></script>
<script src="{{ asset('js/shepherd.js') }}"></script>

<script>
            $(function(){
            var str = "{{$exp['tags']}}";
                    var tags = str.split(", ");
                    for (var i = 0; i < tags.length; i++) {
            $('#tags-lab').append("<a href='#' class='tag-lab' data-tag='" + tags[i] + "' >" + tags[i] + "</a>")
            }

            $("#link").click(function () {
            $("#embeed").show().select();
            });
                    $('.tag-lab').click(function(){
            $.redirect("{{url('search')}}", { terms: $(this).attr('data-tag')});
            });
                    $('#embeed').select();
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
                $('head').append('<link rel="stylesheet" href="' + css + '" type="text/css" />');
                $('#exp').load(html);
                $.getScript(js);
        });
        });</script>
<?php } ?>





<script src="{{ asset('/js/jquery.redirect.js') }}" type="text/javascript"></script>

<?php if (isMobile($_SERVER['HTTP_USER_AGENT'])) { ?>
    <script>
    //                $(function(){
    //                    $('.collapse').addClass('in');
    //                })
    </script>

<?php } if ($exp['queue']) { ?>
    <script>
                /*
                 $(window).resize(function () {
                 if ($(window).width() < 1050) {
                 $('#goup').removeClass('in');
                 } else {
                 $('#goup').addClass('in');
                 }
                 }).resize(); */
    </script>
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
                        $('#error').html("");
                        $('head').append('<link rel="stylesheet" href="' + css + '" type="text/css" />');
                        $('#return').css('margin-top', '-20px');
                        $('#return').addClass('well well-sm');
                        $('#return').html("<span class='timeleft'>{{trans('interface.timeleft')}}: " + "<span id='min'>" + data.clock.min + "</span>:<span id='seg'>" + data.clock.seg + "</span> </span>" +
                        "<button id='btnLeave' class='btn btn-sm btn-default' style='float:right;' name='leave'>" + '{{trans('interface.leave')}}</button>');
                        console.log('lab css loaded');
                        console.log($('#exp'));
                        $('#exp').load(html, function() {
                console.log('lab html loaded');
                        $.getScript(js);
                        console.log('lab js loaded');
                        $.getScript("/js/queue.js", function () {
                        console.log('queue js loaded');
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
                                popup +
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
        } else{
        $('#error').append(
                "<div class='alert alert-warning alert-dismissible' style='overflow: hidden;'>" +
                "<button id='btnLeave' class='btn btn-warning btn-sm' name='leave'>{{trans("interface.leave")}}</button>&nbsp;" +
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

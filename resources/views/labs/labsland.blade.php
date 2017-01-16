
<?php 
$query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

parse_str($query, $params);
$extract = $params;

$langURL = $extract['lang'];
$retrunURL = $extract['return'];
//var_dump($retrunURL);
// Example of URL http://relle.ufsc.br/labs/7/labsland?access=direct&lang=en&return=http://labsland.com/labs/relle/7
?>
@section('page')
{{trans('interface.name', ['page'=>$exp['name_'.App::setLocale("$langURL")]])}}
@stop

{{ App::setLocale("$langURL") }}
{{ Analytics::trackEvent('Experimento', $exp['name_pt'])}}
{{ Analytics::trackEvent('Origem', 'LabsLand')}}
{!! Analytics::render() !!}
<meta name="csrf-token" content="{{ csrf_token() }}" />

<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">

<link rel="shortcut icon" type="image/x-icon" href="{{asset('/favicon.png')}}"/> 

<!-- Fonts -->
<link href='//cdn.jsdelivr.net/jquery.roundslider/1.0/roundslider.min.css' rel="stylesheet">

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href="{{ asset('/css/one.css') }}" rel="stylesheet">
<link href="{{ asset('flat/dist/css/flat-ui.css') }}" rel="stylesheet">

<div id='body' class="container " style="height: 800px; margin-top:40px;">
    <!--{{$name='name_'.App::getLocale()}}
    <!--{{$desc='description_'.App::getLocale()}}
    -->
    <style>
        #labsland-logo{
            position:relative;
            margin-left: 3%;
            margin-right: 3%;
        }
    </style>


    <link href="http://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="http://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>
    <!--   <div id='pre_experiment'></div>  -->
    <div id="return"></div>
    <div id='error'></div>
    <div id='identifier'></div>
    <div id="labsland-logo">
        <a href="http://relle.ufsc.br/en" target="_blank"><img height="10px" width="200px" class="img-responsive img-rounded pull-left" alt="RELLE Logo" src="{{ asset("img/logos/logo.png")}}"></a>
        <a href="http://rexlab.ufsc.br/en" target="_blank"><img height="60px" width="200px" class="img-responsive img-rounded pull-right" alt="RExLab Logo" src="{{ asset("img/footer/r-variacao.jpg")}}"></a>
    </div>
    <center><div id='exp'></div></center> 

    <div id="access"></div>  
</div>

@section('script')

<!-- For direct access -->
<script>
document.addEventListener('DOMContentLoaded', function() {
$("#access").click();
$('#btnIntro').nextAll().remove();
//alert({{$exp['duration']}});
/*function pageRedirect() {
        window.location.replace("http://www.tutorialrepublic.com/");
    } 
    
setTimeout(pageRedirect, {{$exp['duration']}}*60000);*/
   
});</script>
<script src="{{ asset('js/tether.js') }}"></script>
<script src="{{ asset('js/shepherd.js') }}"></script>

<script>
    $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
    });

</script>


<script>

    var url = '{{asset("/exp_data/".$exp['id'])}}';
    var html = url + '/<?php echo($langURL) ?>.html';
    var js = url + '/exp_script.js';
    var css = url + '/exp_style.css';
    var urlqueue = 'http://' + window.location.hostname + '/api/';
    var duration = {{$exp['duration']}};
    var exp_id = {{$exp['id']}};
    var locale = '<?php echo($langURL)?>';
    var uilang = {};
    uilang.close_message = "<p> {{trans('interface.closelab')}}</p> <p>{{trans('interface.redirect')}}</p><br>";
    uilang.end = "{{trans('labs.end')}}";
    uilang.leave = "{{trans('interface.leave')}}";
    uilang.end_rep = "{{trans('labs.end_rep')}}";
    uilang.report = "{{trans('labs.report')}}";
    uilang.csvreport = "{{trans('labs.csvexport')}}";
    uilang.attention = "{{trans('interface.atention')}}";
    uilang.popup = "{{trans('interface.popup')}}";
    uilang.wait = "{{trans('interface.wait')}}";
    uilang.message_error = "{{trans('message.tab')}}";
    uilang.timeleft = "{{trans('interface.timeleft')}}";
    uilang.reconnectingheader = "{{trans('interface.reconnecting_header')}}";
    uilang.reconnectingbody = "{{trans('interface.reconnecting_body')}}";
    uilang.labsunavailable = "{{trans('interface.labs_unavailable')}}";
    uilang.resources = "{{trans('interface.resources')}}";
    
   
</script>

<script src="{{ asset('js/queue_design.js') }}"></script>
<script src="{{ asset('js/queue.js') }}"></script>
<script src="{{ asset('js/socket.io.js') }}"></script>
    <script src='//cdn.jsdelivr.net/jquery.roundslider/1.0/roundslider.min.js'></script>


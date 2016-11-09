
<meta name="csrf-token" content="{{ csrf_token() }}" />

<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('/css/btn.css') }}" rel="stylesheet">
<link href="{{ asset('/css/jasny-bootstrap.css') }}" rel="stylesheet">

<link rel="shortcut icon" type="image/x-icon" href="{{asset('/favicon.png')}}"/> 

<!-- Fonts -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
<script src="{{ asset('/js/jasny-bootstrap.js') }}"></script>
<link href="{{ asset('/css/one.css') }}" rel="stylesheet">
<link href="{{ asset('flat/dist/css/flat-ui.css') }}" rel="stylesheet">

<style>
    .shepherd-element.shepherd-theme-arrows .shepherd-content .shepherd-text {
        padding: 0.5em 0.9em 0.9em 0.9em; 
        min-height: 50px !important; 
        padding-bottom: 80px;
    }
</style>
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


        <a href="#" id="access" class="btn btn-primary" role="button">{{trans('interface.access')}}</a>
    </div>
</div> 

<center><div id='exp'></div></center>

</div>
<script src="{{ asset('js/tether.js') }}"></script>
<script src="{{ asset('js/shepherd.js') }}"></script>
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

</script>


<script>
       
        var url = '{{asset("/exp_data/".$exp['id'])}}';
        var html = url + "/{{App::getLocale()}}.html";
        var js = url + '/exp_script.js';
        var css = url + '/exp_style.css';
        var urlqueue = 'http://' + window.location.hostname + '/api/';
        var duration = {{$exp['duration']}};
        var exp_id = {{$exp['id']}};
        var locale = "{{App::getLocale()}}";
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

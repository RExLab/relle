@extends('layout.default')

@section('head')
<link href="{{ asset('/css/dash_styles.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('content')
<div class="row" style="margin:0; padding:0;">
    <div class="col-md-3">
        <div class="sidebar content-box" style="display: block;">
            <ul class="nav">
                <!-- Main menu -->
                <li class="current visible-xs visible-sm">
                    <a href="#" data-toggle="collapse" 
                       data-target="#goup" aria-expanded="true" aria-controls="goup">
                        <i class="glyphicon glyphicon-th-large"></i> {{trans('interface.menu')}}
                        <i class="caret pull-right"></i>
                    </a>
                </li>
            </ul>
            <ul id='goup' class='nav collapse in'>
                <li>
                    <a href='{{url('dashboard')}}'>
                        <i class="glyphicon glyphicon-home"></i> {{trans('dashboard.title')}}
                    </a>
                </li>
                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-flask"></i> {{trans('labs.title')}}
                        <span class="caret pull-right"></span>
                    </a>
                    <!-- Sub menu -->
                    <ul>
                        @if(admin())
                        <li><a href="{{url('/labs/create')}}">{{trans('labs.create')}}</a></li>
                        @endif
                        <li><a href="{{url('/labs/all')}}">{{trans('labs.all')}}</a></li>
                    </ul>
                </li>
                @if(admin())
                        
                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-users"></i> {{trans('users.title')}}
                        <span class="caret pull-right"></span>
                    </a>
                    <!-- Sub menu -->
                    <ul>
                        <li><a href="{{url('/users/create')}}">{{trans('users.create')}}</a></li>
                        <li><a href="{{url('/users')}}">{{trans('users.all')}}</a></li>
                        <li><a href="{{url('/users/bulk')}}">{{trans('users.bulk')}}  </a></li>
                        <li><a href="{{url('/users/import')}}">{{trans('users.import')}}  <i class="fa fa-arrow-up"></i></a></li>
                        <li><a href="{{url('/users/export')}}">{{trans('users.export')}}  <i class="fa fa-arrow-down"></i></a></li>
                        
                    </ul>
                </li>
                <li><a href="{{url('log/all')}}"><i class="fa fa-file-text-o"></i></i> Logs</a></li>
                <li><a href="http://relle.ufsc.br/moodle/admin/"><i class="fa fa-cogs"></i></i> Moodle</a></li>
                @endif
                <li><a href="{{url('/users/edit')}}"><i class="fa fa-pencil"></i> {{trans('users.edit')}}</a></li>
                <li><a href="{{url('/users/delete')}}"><i class="fa fa-trash-o"></i> {{trans('users.delete')}}</a></li>
            </ul>

        </div>
    </div>
    <div class="col-md-9 content-box-large">
        <h2 style='padding:0 0 10px; margin:0;'>@yield('title_inside')</h2>
        @yield('inside')
    </div>
</div>
@stop

@section('script')
<script src="{{ asset('/js/script.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/dash_custom.js') }}" type="text/javascript"></script>
<script>

$(window).resize(function () {
    if ($(window).width() < 1050) {
        $('#goup').removeClass('in');
    } else {
        $('#goup').addClass('in');
    }
}).resize();
</script>
@yield('script_dash')
@stop
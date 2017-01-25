@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('log.title')])}}
@stop

@section("title_inside")
{{trans('log.title')}} <a href="/log/export" class="btn btn-default">{{trans('interface.export')}}</a>
@stop

@section ('inside')
<?php

use App\Labs;
use App\User;
?>
<style>
    .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus{
        color:white;
        background: #00AA8A;
        border: 1px solid #dddddd;
    }
</style>
    
<table class="table table-responsive table-condensed table-hover" style="width: 100%;">
    <thead>
        <tr>
            <th>{{trans('log.lab')}}</th>
            <th>{{trans('log.username')}}</th>
            <th>{{trans('log.start')}}</th>
            <th>{{trans('log.end')}}</th>
            <th>{{trans('log.ip')}}</th>     
            <th>{{trans('log.os')}}</th>     
            <th>{{trans('log.browser')}}</th>     
            <th>{{trans('log.mobile')}}</th>     
            <th>{{trans('log.language')}}</th>     
            <th>{{trans('log.country')}}</th>     
            <th>{{trans('log.city')}}</th>     

        </tr>
    </thead>
    <tbody>

        @foreach($logs as $log)
        <tr>

            <?php
            $idExp = $log->lab_id;
            $lab = Labs::find($idExp);
            if ($log->user_id) {
                $idUser = $log->user_id;
                $user = User::find($idUser);
            } else {
                $user['username'] = 'guest';
            }
            $locale = 'name_' . App::getlocale();
            $name = "";
            if ($log->mobile == "1") {
                $name = trans('log.true');
            } else {
                $name = trans('log.false');
            }
            ?>

            <td>{{$lab[$locale]}}</td>
            <td>{{ $user['username'] }}</td>
            <td>{{$log->start}}</td>
            <td>{{$log->end}}</td>
            <td>{{$log->ip}}</td>
            <td>{{$log->os}}</td>
            <td>{{$log->browser}}</td>
            <td>{{$name}}</td>
            <td>{{$log->language}}</td>
            <td>{{$log->country}}</td>
            <td>{{$log->city}}</td>

        </tr>
        @endforeach
    </tbody>
</table>
<center><?php echo $logs->render(); ?></center>

@stop

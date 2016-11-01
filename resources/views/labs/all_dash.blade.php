@extends ('layout.dashboard')
@section('page')
{{trans('interface.name', ['page'=>trans('labs.title')])}}
@stop

@section ('title_inside')
{{trans('labs.all')}}
@stop


@section ('inside')
<table class="table">
    <tr>
        <th>ID</th>
        <th>{{trans('labs.name')}}</th>
        <th>{{trans('labs.target')}}</th>
        <th>{{trans('labs.subject')}}</th>
        <th>{{trans('labs.difficulty')}}</th>
        <th>{{trans('labs.interaction')}}</th>
        <th></th>
    </tr>
<!--{{$name='name_'.App::getLocale()}}-->
@foreach($labs as $lab)
<tr>
    <td id="exp_id">{{$lab->id}}</td>
    <td>{{$lab->$name}}</td>
    <td class="multiples_table">
        @foreach(explode(',',$lab->target) as $one)
        {{trans('labs.'.$one)}}<br>
        @endforeach
    </td>
    <td class="multiples_table">
        @foreach(explode(',',$lab->subject) as $one)
        {{trans('labs.'.$one)}}<br>
        @endforeach
    </td>
    <td>{{trans('interface.' . $lab->difficulty)}}</td>
    <td>{{trans('interface.' . $lab->interaction)}}</td>
    <td>
        <a href="{{url(trans('routes.labs').'/'.$lab->id.'/'.trans('routes.delete'))}}"><span class="glyphicon glyphicon-trash text-danger"/></a>
        <a href="{{url(trans('routes.labs').'/'.$lab->id.'/'.trans('routes.edit'))}}"><span class="glyphicon glyphicon-pencil text-success"/></a>
        <a href="{{url(trans('routes.labs').'/'.$lab->id)}}"><i class="fa fa-external-link"></i></a>
    </td>
</tr>
@endforeach
</table>
@stop

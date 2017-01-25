@extends ('layout.dashboard')
@section('page')
{{trans('interface.name', ['page'=>trans('labs.delete')])}}
@stop

@section ('title_inside')
{{trans('labs.delete')}}
@stop

@section ('inside')
<h4>{{trans('message.delete_lab')}}</h4>


<table class="table">
    <tr>
        <th>ID</th>
        <th>Lab ID</th>
        <th>{{trans('labs.description')}}</th>
        <th></th>
    </tr> 
@foreach($instances as $instance) 
<tr>
    <td id="id">{{$instance->id}}</td>
    <td id="lab_id">{{$instance->lab_id}}</td>
    <td id="description">{{$instance->description}}</td>
    <td><a href="{{url(trans('routes.labs').'/'.$id.'/'.trans('routes.instance').'/'. $instance->id .'/delete')}}"><span class="glyphicon glyphicon-trash text-danger"/></a></td>

</tr>
@endforeach
</table>

@stop
@stop


@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('users.delete')])}}
@stop


@section ('title_inside')
{{trans('users.delete')}}
@stop

@section ('inside')
{!!
Form::open([
'action' => 'UsersController@doDelete',
])
!!}
<h4>{{trans('message.delete_user')}}</h4>
<h4>{{trans('message.action')}}</h4>
<input type="hidden" name='id' value="{{$id}}"/>
<a href="{{url('dashboard')}}" role="button"  class="btn btn-success">{{trans('interface.cancel')}}</a>
<input class="btn btn-danger" type="submit" value="{{trans('interface.delete')}}">

{!!
Form::close()
!!}
@stop

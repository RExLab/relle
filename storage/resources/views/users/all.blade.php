@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('users.title')])}}
@stop

@section("title_inside")
{{trans('users.title')}} <a href="/users/export" class="btn btn-default">{{trans('interface.export')}}</a>
@stop



@section ('inside')
<style>
    .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus{
        color:white;
        background: #00AA8A;
        border: 1px solid #dddddd;
    }
</style>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>{{trans('users.username')}}</th>
            <th>{{trans('users.name')}}</th>
            <th>{{trans('users.email')}}</th>
            <th>{{trans('users.organization')}}</th>
            <th>{{trans('users.type')}}</th>     

        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->username}}</td>
            <td>{{$user->firstname}} {{$user->lastname}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->organization}}</td>
            <td>{{$user->type}}</td>
            <td>
                <a href="{{url('users/'.$user->id.'/delete')}}"><span class="glyphicon glyphicon-trash text-danger"/></a>
                <a href="{{url('users/'.$user->id.'/edit')}}"><span class="glyphicon glyphicon-pencil text-success"/></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<center><?php echo $users->render(); ?></center>

@stop

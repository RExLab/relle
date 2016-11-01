@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>trans('users.signup')])}}
@stop

@section ('title')
{{trans('users.signup')}}
@stop

@section ('content')
{!!
Form::open([
'action' => 'UsersController@doSignUp',
'files' => true,
'enctype'=> 'multipart/form-data'
])
!!}


<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class='form-group'>
            {!! Form::label('firstname', trans('users.firstname')) !!}
            {!! Form::text('firstname', null,['class'=>'form-control', 'value'=>Input::get('firstname')]) !!}
            @if ($errors->has('firstname')) <p class="text-danger">{{ $errors->first('firstname') }}</p> @endif
        </div>
        <div class='form-group'>
            {!! Form::label('lastname', trans('users.lastname')) !!}
            {!! Form::text('lastname', null, ['class'=>'form-control']) !!}
            @if ($errors->has('lastname')) <p class="text-danger">{{ $errors->first('lastname') }}</p> @endif
        </div>
        <div class='form-group'>
            {!! Form::label('email', trans('users.email')) !!}
            {!! Form::text('email', null, ['class'=>'form-control']) !!}
            @if ($errors->has('email')) <p class="text-danger">{{ $errors->first('email') }}</p> @endif
        </div>
        <div class='form-group'>

            {!! Form::label('username', trans('users.username')) !!}
            {!! Form::text('username', null, ['class'=>'form-control']) !!}
            @if ($errors->has('username')) <p class="text-danger">{{ $errors->first('username') }}</p> @endif
        </div>
             
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class='form-group'>
            {!! Form::label('password', trans('users.password')) !!}
            {!! Form::input('password', 'password', null, ['class'=>'form-control']) !!}
            @if ($errors->has('password')) <p class="text-danger">{{ $errors->first('password') }}</p> @endif
        </div>
        <div class='form-group'>
            {!! Form::label('repeat', trans('users.repeat')) !!}
            {!! Form::input('password', 'repeat', null, ['class'=>'form-control']) !!}
            @if ($errors->has('repeat')) <p class="text-danger">{{ $errors->first('repeat') }}</p> @endif
        </div>
        <div class='form-group'>
            {!! Form::label('country', trans('users.country')) !!}
            {!! Form::text('country', null, ['class'=>'form-control']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('organization', trans('users.organization')) !!}
            {!! Form::text('organization', null, ['class'=>'form-control']) !!}
        </div>
        
        <div class='form-group'>
            {!! Form::label(trans('users.avatar')) !!} 
            </br>
            {!! Form::input('file', 'avatar')!!}
        </div>
        {!! Form::submit(trans('interface.submit'), ['class'=>'btn btn-success pull-right'])!!}
    </div>
</div>
{!!
Form::close()
!!}
@stop

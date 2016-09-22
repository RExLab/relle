@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('users.edit')])}}
@stop

{{Analytics::trackEvent('Páginas', 'Editar Usuário')}}

@section ('title_inside')
{{trans('users.edit')}}
@stop

@section ('inside')
{!!
Form::open([
'action' => 'UsersController@edit',
'files' => true,
'enctype'=> 'multipart/form-data'
])
!!}
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class='form-group'>
            {!! Form::label('firstname', trans('users.firstname')) !!}
            {!! Form::text('firstname', $users->firstname, ['class'=>'form-control']) !!}
            @if ($errors->has('firstname')) <p class="text-danger">{{ $errors->first('firstname') }}</p> @endif
        </div>
        <div class='form-group'>
            {!! Form::label('lastname', trans('users.lastname')) !!}
            {!! Form::text('lastname', $users->lastname, ['class'=>'form-control']) !!}
            @if ($errors->has('lastname')) <p class="text-danger">{{ $errors->first('lastname') }}</p> @endif
        </div>
        <div class='form-group'>
            {!! Form::label('email', trans('users.email')) !!}
            {!! Form::text('email', $users->email, ['class'=>'form-control']) !!}
            @if ($errors->has('email')) <p class="text-danger">{{ $errors->first('email') }}</p> @endif
        </div> 
        <div class='form-group'>
            {!! Form::label('password', trans('users.password')) !!}
            {!! Form::input('password', 'password', null, ['class'=>'form-control']) !!}
            @if ($errors->has('password')) <p class="text-danger">{{ $errors->first('password') }}</p> @endif
        </div>
        {!! Form::submit(trans('interface.submit'), ['class'=>'btn btn-success'])!!}
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class='form-group'>
            {!! Form::label('country', trans('users.country')) !!}
            {!! Form::text('country', $users->country, ['class'=>'form-control']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('organization', trans('users.organization')) !!}
            {!! Form::text('organization', $users->organization, ['class'=>'form-control']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('type', trans('users.type')) !!}
            {!! Form::select('type', 
                [null=> trans('interface.select')] +
            [
                    "admin"=> trans('users.admin'), 
                    "user"=> trans('users.user') 
                ], 
                $users->type, ['class' => 'form-control']) 
            !!}
        </div>
        <div class='form-group'>
            {!! Form::label(trans('users.avatar')) !!} 
            </br>
            {!! Form::input('file', 'avatar')!!}
        </div>
        <input type="hidden" name='id' value="{{$users->id}}"/>
    </div>
</div>

{!!Form::close()!!}
@stop

@section('script_dash')

<script>
$(document).ready(function() {
    $('.select2-choice').css({'padding': '0px'});
});
</script>
@stop
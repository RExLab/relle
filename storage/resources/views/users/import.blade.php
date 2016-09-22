@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('users.import')])}}
@stop


@section ('title_inside')
{{trans('users.import')}}
@stop



@section ('inside')
{!!
Form::open([
'files' => true,
'enctype'=> 'multipart/form-data'
])
!!}

<div class="fileinput fileinput-new input-group col-lg-6" data-provides="fileinput">
    <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
    <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">{{trans('interface.select')}}</span><span class="fileinput-exists">{{trans('interface.change')}}</span><input type="file" name="file" accept=".csv, .xls, .xlsx"></span>
    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('interface.remove')}}</a>
</div>
<i>.csv, .xls, .xlsx</i>

{!! Form::submit(trans('interface.submit'), ['class'=>'btn btn-success pull-right'])!!}

{!!Form::close()!!}
@stop
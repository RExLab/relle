@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('docs.create')])}}
@stop

<link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>


@section ('title_inside')
{{trans('docs.create')}}
@stop

@section ('inside')
<style>
    .btn-file{
        border-radius: 5px;
        margin:3px;
    }
    .bootstrap-tagsinput{
        border: 2px solid #bdc3c7;
    }
    .bootstrap-tagsinput:focus{
        border: 2px solid #1abc9c;
    }
</style>
{!!
Form::open([
'files' => true,
'enctype'=> 'multipart/form-data',
'class' => 'dropzone'
])
!!}


<div class="row">
    @if ($errors->has())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>{{trans('interface.sorry')}}.</strong>
        {{ $error }}
    </div>
    @endforeach
    @endif

    <div class="form-group col-md-6 col-sm-12">
        <label>{{trans('docs.title')}}</label>
        <input type="text" name="title" class="form-control" required/>
    </div>

    <div class="form-group col-md-3 col-sm-12">
        <label>{{trans('docs.type')}}</label>
        <select class="form-control select select-default" name="type">
            <optgroup label="{{trans('docs.technical')}}">
                <option value="manual">{{trans('docs.manual')}}</option>
            </optgroup>
            <optgroup label="{{trans('docs.didactic')}}">
                <option value="teaching">{{trans('docs.teaching')}}</option>
                <option value="plan">{{trans('docs.plan')}}</option>
                <option value="guide">{{trans('docs.guide')}}</option>
            </optgroup>
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6 col-sm-12">
        <label>Tags</label>
        <input name="tags" class="tagsinput form-control" data-role="tagsinput"/>
    </div>
    <div class="form-group col-md-3 col-sm-12">
        <label>{{trans('docs.lang')}}:</label>
        <select class="form-control select select-default " name='lang'>
            <option value="en">{{trans("interface.pt")}}</option>
            <option value="pt">{{trans("interface.en")}}</option>
        </select>        
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6 col-sm-12">
        <label>{{trans('docs.file')}}</label>
        <input type="file" name="file" required/>
        <!--
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
            <span class="input-group-addon btn btn-default btn-file input-group-btn"><span class="fileinput-new">{{trans('interface.select')}}</span><span class="fileinput-exists">{{trans('interface.change')}}</span><input type="file" name="file" required></span>
            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('interface.remove')}}</a>
        </div>
        -->
    </div>
    <div class="form-group col-md-12">
        <button class="btn btn-primary btn-wide">{{trans("interface.submit")}}</button>
    </div>
</div>
{!!Form::close()!!}
@stop

@section('post_body')
<script src="{{asset('js/dropzone.js')}}"></script>
<script>
    $('.btnNext').click(function () {
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function () {
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });
</script>
@stop


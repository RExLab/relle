@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('labs.create')])}}
@stop


@section ('title_inside')
{{trans('labs.create')}}
@stop

{{$url = trans('routes.labs') . '/' . trans('routes.create')}}


@section ('inside')
{!!
Form::open([
'files' => true,
'enctype'=> 'multipart/form-data'
])
!!}

<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">{{trans('labs.description')}}</a></li>
                    <li><a href="#tab2" data-toggle="tab">{{trans('labs.details')}}</a></li>
                    <li><a href="#tab3" data-toggle="tab">{{trans('labs.files')}}</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <!--
                        TAB 1
                    -->
                    <div class="tab-pane active" id="tab1">

                        <div class='lang-box col-lg-12'>
                            <h5>{{trans('labs.pt')}}</h5>
                            <div class='form-group col-lg-6 col-xs-12 pt'>
                                <label for='name_pt'>{{trans('labs.name')}}</label>
                                <input name='name_pt' id='name_en' class='form-control pt' type='text'/>
                                @if ($errors->has('name_pt')) <p class="text-danger">{{ $errors->first('name_pt') }}</p> @endif
                            </div>
                            <div class='form-group col-lg-6 col-xs-12 pt'>
                                <label for='description_pt'>{{trans('labs.description')}}</label>
                                <textarea name='description_pt' id='description_en' class='form-control pt'  maxlength='105'/></textarea>
                                @if ($errors->has('description_pt')) <p class="text-danger">{{ $errors->first('description_pt') }}</p> @endif
                            </div>
                        </div>
                        <div class='lang-box col-lg-12'>
                            <h5>{{trans('labs.en')}}</h5>
                            <div class='form-group col-lg-6 col-xs-12 en'>
                                <label for='name_en'>{{trans('labs.name')}}</label>
                                <input name='name_en' id='name_en' class='form-control en' type='text'/>
                                @if ($errors->has('name_en')) <p class="text-danger">{{ $errors->first('name_en') }}</p> @endif
                            </div>
                            <div class='form-group col-lg-6 col-xs-12 en'>
                                <label for='description_en'>{{trans('labs.description')}}</label>
                                <textarea name='description_en' id='description_en' class='form-control en' maxlength='105'></textarea>
                                @if ($errors->has('description_en')) <p class="text-danger">{{ $errors->first('description_en') }}</p> @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                <div class='form-group'>
                                    {!! Form::label('tags', trans('labs.tags')) !!}
                                    {!! Form::text('tags', null, ['class'=>'form-control']) !!}
                                    @if ($errors->has('tags')) <p class="text-danger">{{ $errors->first('tags') }}</p> @endif
                                </div>
                            </div>
                            <div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                <div class='form-group'>
                                    {!! Form::label('duration', trans('labs.duration')) !!}
                                    {!! Form::input('number','duration', null, ['class'=>'form-control']) !!}
                                    @if ($errors->has('duration')) <p class="text-danger">{{ $errors->first('duration') }}</p> @endif
                                </div>
                            </div>
                            <a class="btn btn-success pull-right btnNext">{{trans('interface.next')}}</a>
                        </div>
                    </div>
                    <!--
                        TAB 2
                    -->
                    <div class="tab-pane fade" id="tab2">
                        <label for='queue'>{{trans('labs.queue')}}: </label>
                        <input class='switch' name='queue' type="checkbox" data-toggle="toggle" 
                               data-onstyle="success" data-offstyle= "danger" data-size="small" data-value='off'/><br> 

                        <div class="row">
                            <div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                                {!! Form::label(trans('labs.target')) !!}
                                </br>
                                {!! Form::checkbox('target[]', 'elementary') !!}
                                {!! Form::label(trans('labs.elementary')) !!}
                                </br>
                                {!! Form::checkbox('target[]', 'secondary') !!}
                                {!! Form::label(trans('labs.secondary')) !!}
                                </br>
                                {!! Form::checkbox('target[]', 'high') !!}
                                {!! Form::label(trans('labs.high')) !!}
                                </br>
                                {!! Form::checkbox('target[]', 'higher') !!}
                                {!! Form::label(trans('labs.higher')) !!}
                                @if ($errors->has('target')) <p class="text-danger">{{ $errors->first('target') }}</p> @endif
                            </div>

                            <div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                                {!! Form::label(trans('labs.subject')) !!}
                                </br>
                                {!! Form::checkbox('subject[]', 'physics') !!}
                                {!! Form::label(trans('labs.physics')) !!}
                                </br>
                                {!! Form::checkbox('subject[]', 'biology') !!}
                                {!! Form::label(trans('labs.biology')) !!}
                                </br>
                                {!! Form::checkbox('subject[]', 'chemistry') !!}
                                {!! Form::label(trans('labs.chemistry')) !!}
                                </br>
                                {!! Form::checkbox('subject[]', 'robotics') !!}
                                {!! Form::label(trans('labs.robotics')) !!}
                                </br>
                                {!! Form::checkbox('subject[]', 'science') !!}
                                {!! Form::label(trans('labs.science')) !!}
                                @if ($errors->has('subject')) <p class="text-danger">{{ $errors->first('subject') }}</p> @endif
                            </div>



                            <div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                {!! Form::label(trans('labs.difficulty')) !!}
                                </br>
                                {!! Form::radio('difficulty', 'low') !!}
                                {!! Form::label(trans('interface.low')) !!}

                                {!! Form::radio('difficulty', 'medium') !!}
                                {!! Form::label(trans('interface.medium')) !!}

                                {!! Form::radio('difficulty', 'high') !!}
                                {!! Form::label(trans('interface.high')) !!}
                                @if ($errors->has('difficulty')) <p class="text-danger">{{ $errors->first('difficulty') }}</p> @endif
                            </div>

                            <div class='form-group col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                {!! Form::label(trans('labs.interaction')) !!}
                                </br>
                                {!! Form::radio('interaction', 'low') !!}
                                {!! Form::label(trans('interface.low')) !!}

                                {!! Form::radio('interaction', 'medium') !!}
                                {!! Form::label(trans('interface.medium')) !!}

                                {!! Form::radio('interaction', 'high') !!}
                                {!! Form::label(trans('interface.high')) !!}
                                @if ($errors->has('interaction')) <p class="text-danger">{{ $errors->first('interaction') }}</p> @endif
                            </div>
                        </div>
                        <a class="btn btn-success pull-left btnPrevious">{{trans('interface.previous')}}</a>
                        <a class="btn btn-success pull-right btnNext">{{trans('interface.next')}}</a>
                    </div>
                    <!--
                        TAB 
                    -->
                    <div class="tab-pane fade" id="tab3">
                        <div class='form-group'>
                            {!! Form::label(trans('labs.thumbnail')) !!}
                            <br>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                    <img src="{{asset("/img/exp/default.gif")}}"/>
                                </div>
                                <div>
                                    <span class="btn btn-default btn-file"><span class="fileinput-new">{{trans('interface.select')}}</span><span class="fileinput-exists">Trocar</span><input type="file" name="thumbnail" id="thumbnail"></span>
                                    <a href="#" class="btn btn-hot fileinput-exists" data-dismiss="fileinput">Remover</a>
                                </div>
                            </div>

                            </br>
                            <!--
                            {!! Form::input('file', 'thumbnail')!!}
                            -->
                            @if ($errors->has('thumbnail')) <p class="text-danger">{{ $errors->first('thumbnail') }}</p> @endif
                        </div>
                        <div class='form-group'>
                            {!! Form::label(trans('labs.package')) !!} 
                            </br>
                            <div class="fileinput fileinput-new input-group col-lg-6" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">{{trans('interface.select')}}</span><span class="fileinput-exists">{{trans('interface.change')}}</span><input type="file" name="package"></span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('interface.remove')}}</a>
                            </div>
                            <p>{{trans('labs.pack')}} <a href="https://github.com/RExLab/lab_package" target="_blank">GitHub</a>.</p>

                            <!--
                            {!! Form::input('file', 'package')!!} 
                            -->
                            @if ($errors->has('package')) <p class="text-danger">{{ $errors->first('package') }}</p> @endif
                        </div>

                        <a class="btn btn-success pull-left btnPrevious">{{trans('interface.previous')}}</a>
                        {!! Form::submit(trans('interface.submit'), ['class'=>'btn btn-success pull-right'])!!}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}
@stop

@section('post_body')
<script>
    $('.btnNext').click(function () {
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function () {
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });
</script>
@stop


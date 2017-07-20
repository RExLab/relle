@extends ('layout.dashboard')

@section('inside-head')
<style>
    .entry:not(:first-of-type){
        margin-top: 10px;
    }
    .input-group-btn{
        margin-top:-15px;
    }
</style>
@stop

@section('page')
{{trans('interface.name', ['page'=>trans('labs.create')])}}
@stop


<?php $url = trans('routes.labs') . '/' . trans('routes.create'); ?>


@section ('inside')
<h4>{{trans('labs.create')}}</h4>
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
                    <li class="disabled"><a href="#tab2" data-toggle="tab">{{trans('labs.details')}}</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <!--
                        TAB 
                    -->
                    <div class="tab-pane active" id="tab1">

                        <div class="container">
                            <label>Insira o endereço do experimento:</label>

                            <div class="controls"> 
                                <div class="entry input-group col-lg-5">
                                    <input class="form-control" name="instances[]" type="text" placeholder="IP Público ou Endereço" required>
                                    <span class="input-group-btn">
                                        <button id="btn-get" class="btn btn-primary" type="button" style="margin-top:0">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class='lang-box col-lg-12' style="margin-top:20px;">
                            <h5 style="font-size: 14pt">{{trans('labs.pt')}}</h5>
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
                            <h5 style="font-size: 14pt">{{trans('labs.en')}}</h5>
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

                        <div class="row">
                            <div class="col-lg-6">
                                <div class='form-group'>
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

                                <div class='form-group'>
                                    {!! Form::label(trans('labs.subject')) !!}
                                    </br>
                                    {!! Form::checkbox('subject[]', 'physics') !!}
                                    {!! Form::label(trans('labs.physics')) !!}
                                    </br>
                                    {!! Form::checkbox('subject[]', 'biology') !!}
                                    {!! Form::label(trans('labs.biology')) !!}
                                    </br>

                                    {!! Form::checkbox('subject[]', 'robotics') !!}
                                    {!! Form::label(trans('labs.robotics')) !!}
                                    </br>
                                    {!! Form::checkbox('subject[]', 'science') !!}
                                    {!! Form::label(trans('labs.science')) !!}
                                    @if ($errors->has('subject')) <p class="text-danger">{{ $errors->first('subject') }}</p> @endif
                                </div>

                                <div class='form-group'>
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

                                <div class='form-group'>
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
                            <div class="col-lg-6">
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
                            </div>
                            <div class="col-lg-12">                               
                                <a class="btn btn-success pull-left btnPrevious">{{trans('interface.previous')}}</a>
                                {!! Form::submit(trans('interface.submit'), ['class'=>'btn btn-success pull-right'])!!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}
@stop

@section('script_dash')
<script>
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')}
    });
    $(function () {
        $('#btn-get').click(function () {
            console.log('entrou');
            $.getJSON("{{asset('metadata.json')}}", function (data) {
                console.log('entrou2');
                console.log(data);
            });

        });
    });


    $('.btnNext').click(function () {
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function () {
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });
    $(function ()
    {
        $(document).on('click', '.btn-add', function (e)
        {
            e.preventDefault();

            var controlForm = $('.controls'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

            newEntry.find('input').val('');
            controlForm.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
        }).on('click', '.btn-remove', function (e)
        {
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
        });
    });

</script>
@stop


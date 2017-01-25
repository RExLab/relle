@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('labs.edit')])}}
@stop


@section ('title_inside')
{{trans('labs.edit')}}
@stop

@section ('inside')


{!!
Form::open([
'files' => true,
'enctype'=> 'multipart/form-data'
])
!!}

<?php
    $maintenance = 'off';
    if($lab->maintenance == '1'){
         $maintenance = 'on';
    }
    $queue = 'off';
    if($lab->queue == '1'){
         $queue = 'on';
    }
?>

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
                        @if ($errors->has())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            {{ $error }}<br>        
                            @endforeach
                        </div>
                        @endif
                            <label for='maintenance'>{{trans('labs.maintenance')}}: </label>
                            <input class='switch' name='maintenance' id="maintenance" type="checkbox" data-toggle="toggle" 
                                   data-onstyle="success" data-offstyle= "danger" data-size="small" data-value='{{$maintenance}}'/><br>
                        

                        <div class='lang-box col-lg-12'>
                            <h5>{{trans('labs.pt')}}</h5>
                            <div class='form-group col-lg-6 col-xs-12 pt'>
                                <label for='name_pt'>{{trans('labs.name')}}</label>
                                <input name='name_pt' value='{{$lab->name_pt}}' id='name_en' class='form-control pt' type='text' />
                                @if ($errors->has('name_pt')) <p class="text-danger">{{ $errors->first('name') }}</p> @endif
                            </div>
                            <div class='form-group col-lg-6 col-xs-12 pt'>
                                <label for='description_pt'>{{trans('labs.description')}}</label>
                                <textarea name='description_pt' id='description_en' class='form-control pt'  maxlength='105' />{{$lab->description_pt}}</textarea>
                                @if ($errors->has('description_pt')) <p class="text-danger">{{ $errors->first('name') }}</p> @endif
                            </div>
                        </div>
                        <div class='lang-box col-lg-12'>
                            <h5>{{trans('labs.en')}}</h5>
                            <div class='form-group col-lg-6 col-xs-12 en'>
                                <label for='name_en'>{{trans('labs.name')}}</label>
                                <input name='name_en' value='{{$lab->name_en}}' id='name_en' class='form-control en' type='text' />
                                @if ($errors->has('name_en')) <p class="text-danger">{{ $errors->first('name') }}</p> @endif
                            </div>
                            <div class='form-group col-lg-6 col-xs-12 en'>
                                <label for='description_en'>{{trans('labs.description')}}</label>
                                <textarea name='description_en' id='description_en' maxlength='105' class='form-control en'>{{$lab->description_en}}</textarea>
                                @if ($errors->has('description_en')) <p class="text-danger">{{ $errors->first('name') }}</p> @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                <div class='form-group'>
                                    {!! Form::label('tags', trans('labs.tags')) !!}
                                    {!! Form::text('tags', $lab->tags, ['class'=>'form-control']) !!}
                                </div>
                                @if ($errors->has('tags')) <p class="text-danger">{{ $errors->first('target') }}</p> @endif
                            </div>
                            <div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                <div class='form-group'>
                                    {!! Form::label('duration', trans('labs.duration')) !!}
                                    {!! Form::input('number','duration', $lab->duration, ['class'=>'form-control']) !!}
                                </div>
                                @if ($errors->has('duration')) <p class="text-danger">{{ $errors->first('target') }}</p> @endif
                            </div>
                            <a class="btn btn-success pull-right btnNext">{{trans('interface.next')}}</a>
                        </div>
                    </div>
                    <!--
                        TAB 2
                    -->
                    <div class="tab-pane fade" id="tab2">
                        <label for='queue'>{{trans('labs.queue')}}: </label>
                        <input class='switch' name='queue' type="checkbox" data-toggle="toggle" id='queue'
                               data-onstyle="success" data-offstyle= "danger" data-size="small" data-value='{{$queue}}'/><br> 
                        <div class="row">
                            <div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                                {!! Form::label(trans('labs.target')) !!}
                                </br>
                                <!--
                                {{$target = false}}
                                @if(in_array('elementary', stringToArray($lab->target)))
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::checkbox('target[]', 'elementary', $target) !!}
                                {!! Form::label(trans('labs.elementary')) !!}
                                </br>
                                <!--
                                {{$target = false}}
                                @if(in_array('secondary', stringToArray($lab->target)))
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::checkbox('target[]', 'secondary', $target) !!}
                                {!! Form::label(trans('labs.secondary')) !!}
                                </br>
                                <!--
                                {{$target = false}}
                                @if(in_array('high', stringToArray($lab->target)))
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::checkbox('target[]', 'high', $target) !!}
                                {!! Form::label(trans('labs.high')) !!}
                                </br>
                                <!--
                                {{$target = false}}
                                @if(in_array('higher', stringToArray($lab->target)))
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::checkbox('target[]', 'higher', $target) !!}
                                {!! Form::label(trans('labs.higher')) !!}
                                @if ($errors->has('target')) <p class="text-danger">{{ $errors->first('target') }}</p> @endif
                            </div>
                            <div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                                {!! Form::label(trans('labs.subject')) !!}
                                </br>
                                <!--
                                {{$target = false}}
                                @if(in_array('physics', stringToArray($lab->subject)))
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::checkbox('subject[]', 'physics', $target) !!}
                                {!! Form::label(trans('labs.physics')) !!}
                                </br>
                                <!--
                                {{$target = false}}
                                @if(in_array('biology', stringToArray($lab->subject)))
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::checkbox('subject[]', 'biology', $target) !!}
                                {!! Form::label(trans('labs.biology')) !!}
                                </br>
                                <!--
                                {{$target = false}}
                                @if(in_array('chemistry', stringToArray($lab->subject)))
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::checkbox('subject[]', 'chemistry', $target) !!}
                                {!! Form::label(trans('labs.chemistry')) !!}
                                </br>
                                <!--
                                {{$target = false}}
                                @if(in_array('robotics', stringToArray($lab->subject)))
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::checkbox('subject[]', 'robotics', $target) !!}
                                {!! Form::label(trans('labs.robotics')) !!}
                                <br>
                                {!! Form::checkbox('subject[]', 'science', $target) !!}
                                {!! Form::label(trans('labs.science')) !!}
                            </div>
                            @if ($errors->has('subject')) <p class="text-danger">{{ $errors->first('subject') }}</p> @endif


                            <div class='form-group col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                {!! Form::label(trans('labs.difficulty')) !!}
                                </br>
                                <!--
                                {{$target = false}}
                                @if($lab->difficulty=='low')
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::radio('difficulty', 'low', $target) !!}
                                {!! Form::label(trans('interface.low')) !!}
                                <!--
                                {{$target = false}}
                                @if($lab->difficulty=='medium')
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::radio('difficulty', 'medium', $target) !!}
                                {!! Form::label(trans('interface.medium')) !!}
                                <!--
                                {{$target = false}}
                                @if($lab->difficulty=='high')
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::radio('difficulty', 'high', $target) !!}
                                {!! Form::label(trans('interface.high')) !!}
                            </div>

                            <div class='form-group col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                {!! Form::label(trans('labs.interaction')) !!}
                                </br>
                                <!--
                                {{$target = false}}
                                @if($lab->interaction=='low')
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::radio('interaction', 'low', $target) !!}
                                {!! Form::label(trans('interface.low')) !!}
                                <!--
                                {{$target = false}}
                                @if($lab->interaction=='medium')
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::radio('interaction', 'medium', $target) !!}
                                {!! Form::label(trans('interface.medium')) !!}
                                <!--
                                {{$target = false}}
                                @if($lab->interaction=='high')
                                {{$target = true}}
                                @endif
                                -->
                                {!! Form::radio('interaction', 'high', $target) !!}
                                {!! Form::label(trans('interface.high')) !!}
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
                            </br>
                            <img src='{{asset($lab->thumbnail)}}' height="150px" /> <br><br>
                            {!! Form::input('file', 'thumbnail')!!}
                        </div>
                        <div class='form-group'>

                            {{trans('labs.package')}}
                            </br>
                            {!! Form::input('file', 'package')!!}
                        </div>
                        <input type="hidden" name="id" value="{{$lab->id}}">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
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

@section('script_dash')
<script>
    
  $(function() {
        $('#maintenance').bootstrapToggle('<?php echo $maintenance;?>');
        $('#queue').bootstrapToggle('<?php echo $queue;?>');
        console.log('oi');
    });
    
    $('.btnNext').click(function () {
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function () {
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });
</script>
@stop


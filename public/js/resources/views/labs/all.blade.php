@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>trans('labs.title')])}}
@stop

@section('title')
{{trans('labs.title')}}
@stop

<!--{{$name='name_'.App::getLocale()}}
{{$desc='description_'.App::getLocale()}}-->


@section ('content')
<div class='xs-hidden' style="margin-top:20px;"></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 well"  style=" margin-bottom:0; padding-bottom:0">

    {!! Form::open([
    'url'=>'labs',
    ]) !!}

    <div class="form-group has-feedback">
        <input type="text" name="terms" id='search' placeholder="{{trans('interface.search')}}" class="form-control" />
        <i class="glyphicon glyphicon-search form-control-feedback"></i>
    </div>
    <div class="form-group visible-xs visible-sm'>
         <a href="#" data-toggle="collapse" 
         data-target="#goup" aria-expanded="true" aria-controls="goup">
        {{trans('interface.advanced_search')}}<i class="caret"></i>
        </a>
    </div>
    <ul id='goup' class='nav collapse'>
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
        </br></br>
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
        </br></br>
        {!! Form::label(trans('labs.difficulty')) !!}
        </br>
        {!! Form::checkbox('difficulty[]', 'low') !!}
        {!! Form::label(trans('interface.low')) !!}

        {!! Form::checkbox('difficulty[]', 'medium') !!}
        {!! Form::label(trans('interface.medium')) !!}

        {!! Form::checkbox('difficulty[]', 'high') !!}
        {!! Form::label(trans('interface.high')) !!}
        </br></br>

        {!! Form::label(trans('labs.interaction')) !!}
        </br>
        {!! Form::checkbox('interaction[]', 'low') !!}
        {!! Form::label(trans('interface.low')) !!}

        {!! Form::checkbox('interaction[]', 'medium') !!}
        {!! Form::label(trans('interface.medium')) !!}

        {!! Form::checkbox('interaction[]', 'high') !!}
        {!! Form::label(trans('interface.high')) !!}
        </br></br>

        {!! Form::submit(trans('interface.submit'), ['class'=>'btn btn-fresh'])!!}

        {!! Form::close() !!}
    </ul>
</div>

<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="padding-bottom:75px">
    @foreach($labs as $lab)
    
    <?php 
        if(status($lab->id)){
            $color = "#51bf87";
            $btn='btn-fresh';
            $status = 'Disponível';
            $title = '';
            $txt = trans('interface.access');
        }else{
            $color = "#f44336";
            $btn = 'btn-default disabled';
            $status = 'Indisponível';
            $title = 'Este experimento está indisponível no momento';
            $txt = trans('interface.unavailable');
        }
    ?>
    
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-image">
                <img src="{{asset($lab->thumbnail)}}">
                <span class="card-title"><a href="{{url('/labs/'.$lab->id)}}" class="btn {{$btn}}" title="{{$title}}" role="button">{{$txt}}</a></span>
            </div>
            <div class="card-content">
                <span class="status" id='{{$lab->id}}' style="color:{{$color}};" class="tooltip" title="{{$status}}"><i class="fa fa-circle"></i></span>
                <b>{{$lab->$name}}</b>
                <p>{{$lab->$desc}}</p>
            </div>

        </div>
    </div>
    @endforeach
</div>
@stop

@section('script')
<script>
    $(window).resize(function () {
        if ($(window).width() < 1050) {
            $('#goup').removeClass('in');
        } else {
            $('#goup').addClass('in');
        }
    }).resize();
</script>
@stop



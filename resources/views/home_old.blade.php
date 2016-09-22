@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>trans('index.title')])}}
@stop
<style>
        

@media (max-width: 767px) and (orientation:portrait) {
    .card .card-image img {
            border-radius: 2px 2px 0 0;
            background-clip: padding-box;
            position: relative;
            z-index: -1;
            height: 40%; 
            min-width: 100%;
        }
}

@media (max-width: 767px) and (orientation:landscape) {
    .card .card-image img {
            border-radius: 2px 2px 0 0;
            background-clip: padding-box;
            position: relative;
            z-index: -1;
            height: 50%; 
            min-width: 100%;
        }
}
    @media (min-width: 767px) {
        .card .card-image img {
            border-radius: 2px 2px 0 0;
            background-clip: padding-box;
            position: relative;
            z-index: -1;
            height: 300px; 
            min-width: 100%;
        }
    }
</style>

@section('title')
<div class="visible-sm visible-lg visible-md">
    <h1>{{trans('interface.home')}}</h1> 
    <h4>{{trans('index.description')}}<br>
    {{trans('index.exp')}}</h4>
</div>
@stop

<!--{{$name='name_'.App::getLocale()}}
{{$desc='description_'.App::getLocale()}}-->


@section ('content')
<div class='xs-hidden' style="margin-top:20px;"></div>
<center>
<div class="col-lg-10 col-lg-offset-1 visible-xs visible-sm"  style=" margin-bottom:0; padding-bottom:0">

    {!! Form::open(['url'=>'labs']) !!}
    <div class="form-group has-feedback">
        <input type="text" name="terms" id='search' placeholder="{{trans('interface.search')}}" class="form-control" />
        <i class="glyphicon glyphicon-search form-control-feedback"></i>
    </div>
    {!! Form::close() !!}
    
</div>
</center>

<div class="row" style="padding-bottom:20px">
    @foreach($labs as $lab)

    <?php
    
    
    if (status($lab->id)) {
        $color = "#51bf87";
        $btn = 'btn-fresh';
        $status = 'Disponível';
        $title = '';
        $txt = trans('interface.access');
    
    

    ?>


    <!--<div class="col-md-4" style="margin-left:5px;">
    Se colocar margem não cabe em 3 colunas
    -->
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-10 col-xs-offset-1 col-sm-offset-0 col-lg-offset-0 col-md-offset-0">
            <div class="card">
                <div class="card-image">
                    <img src="{{asset($lab->thumbnail)}}">
                    <span class="card-title"><a href="{{url('/labs/'.$lab->id)}}" class="btn {{$btn}}" title="{{$title}}" role="button">{{$txt}}</a></span>
                </div>
                <div class="card-content">
                    <span class="status" id='{{$lab->id}}' style="color:{{$color}};" class="tooltip" title="{{$status}}"><i class="fa fa-circle"></i></span>
                    <b>{{$lab->$name}}</b>
                    <p><?php echo $lab->$desc;?></p>
                </div>
            </div>
        </div>
    <?php } ?>
    @endforeach

    @foreach($labs as $lab)
    <?php
    if (!status($lab->id)) {
        $color = "#f44336";
        if(admin()||guest()) $btn = 'btn-hot';
        else $btn = 'btn-default disabled';
        $status = 'Indisponível';
        $title = 'Este experimento está indisponível no momento';
        $txt = trans('interface.test');
        ?>
    
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-10 col-xs-offset-1 col-sm-offset-0 col-lg-offset-0 col-md-offset-0">
            <div class="card">
                <div class="card-image">
                    <img src="{{asset($lab->thumbnail)}}">
                    <span class="card-title"><a href="{{url('/labs/'.$lab->id)}}" class="btn {{$btn}}" title="{{$title}}" role="button">{{$txt}}</a></span>
                </div>
                <div class="card-content">
                    <span class="status" id='{{$lab->id}}' style="color:{{$color}};" class="tooltip" title="{{$status}}"><i class="fa fa-circle"></i></span>
                    <b>{{$lab->$name}}</b>
                    <p><?php echo $lab->$desc;?></p>
                </div>
            </div>
        </div>
    <?php } ?>
    @endforeach
    
</div>
@stop

@section('script')
<script>
    /*$(window).resize(function () {
     if ($(window).width() < 1050) {
     $('#goup').removeClass('in');
     } else {
     $('#goup').addClass('in');
     }
     }).resize();*/
</script>
@stop



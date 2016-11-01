@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>trans('labs.title')])}}
@stop
<style>
    .card-content>p{
        font-size: 11pt;
    }   
    .card-content>b{
        font-size: 11pt;
    }   
    .card-content{
        height:120px;
    }

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
    <h1>{{trans('labs.title')}}</h1> 
@stop

<?php
$name='name_'.App::getLocale();
$desc='description_'.App::getLocale();
?>

@section ('content')
<div style="width:100%">
<p style="text-align:right">
    <a href="#" id="all">Todos</a> |
    <a href="#" class="subject" id="physics">Física</a> | 
    <a href="#" class="subject" id="biology">Biologia</a> | 
    <a href="#" class="subject" id="robotics">Robótica</a>
</p>
</div>
<div class="row" style="padding-bottom:20px">
    @foreach($labs as $lab)

    <?php
    
    
    if (status($lab->id)) {
        $color = "#1abc9c";
        $btn = 'btn-primary';
        $status = 'Disponível';
        $title = '';
        $txt = trans('interface.access');
    
    

    ?>


    <!--<div class="col-md-4" style="margin-left:5px;">
    Se colocar margem não cabe em 3 colunas
    -->
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-10 col-xs-offset-1 col-sm-offset-0 col-lg-offset-0 col-md-offset-0 {{$lab->subject}} lab">
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
        if(admin()||guest()) $btn = 'btn-danger';
        else $btn = 'btn-default disabled';
        $status = 'Indisponível';
        $title = 'Este experimento está indisponível no momento';
        $txt = trans('interface.test');
        ?>
    
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-10 col-xs-offset-1 col-sm-offset-0 col-lg-offset-0 col-md-offset-0 {{$lab->subject}} lab">
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
    $(function(){
        $("#all").click(function(){
           $('.lab').show();
       });
       $(".subject").click(function(){
           $('.lab').show();
           var subject = '.'+$(this).attr('id');
           console.log($('.lab').not(subject));
           $('.lab').not(subject).hide("slow");
       }); 
    });
</script>
@stop



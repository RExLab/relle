@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>trans('labs.title')])}}
@stop
<style>
    .panel{
        width: 95%;
        border:none;
        padding:10px;
    }
    .panel-body{
        font-size:12pt;
        background: #ECF0F1;
        min-height: 180px;
        margin:0;
        border:none;
        border-radius: 0 5px;

    }
    .panel-body > .row >  div{
        padding: 0 8px 8px 8px;
    }
    .panel-body > .row >  div > img{
        width: 100%;
    }
    .panel-body > .row >  div > b{
        font-size: 12pt;
    }   
    .panel-body > .row >  div > p{
        font-size: 11pt;
    }

    @media only screen and (min-device-width: 1024px){
        .panel-body > .row >  div > img{
            height: 140px;
            min-width: 80%;
            max-width: 100%;
        }
        .panel-body > .row >  div > b{
            font-size: 16pt;
        }
        .panel-body > .row >  div > p{
            font-size: 14pt;
        }
    }

    @media only screen and (device-width: 601px) 
    and (device-height: 906px) 
    and (-webkit-min-device-pixel-ratio: 1.331) 
    and (-webkit-max-device-pixel-ratio: 1.332){
        .panel-body > .row >  div > b{
            font-size: 16pt;
        }
        .panel-body > .row >  div > p{
            font-size: 14pt;
        }
    }

</style>

@section('title')
{{trans('labs.title')}}
@stop

<?php
$name = 'name_' . App::getLocale();
$desc = 'description_' . App::getLocale();
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

        <div class="col-lg-6 col-md-6 col-sm-6 {{$lab->subject}} lab">
            <div class="panel" style="background: #ECF0F1; ">
                <div class="panel-body">
                    <div class="row">
                        <div class='col-lg-5 col-md-5 col-sm-4 col-xs-12'>
                            <img src="{{asset($lab->thumbnail)}}">
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-8 col-xs-12">
                            <b style="line-height:1">{{$lab->$name}}</b>
                            <p style="font-size:11pt; line-height: 1.2; padding-top:5px;"><?php echo $lab->$desc; ?></p>
                            <a href="{{url('/labs/'.$lab->id)}}" class="{{$btn}} btn-sm" role="button">{{$txt}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    @endforeach

    @foreach($labs as $lab)
    <?php
    if (!status($lab->id)) {
        $color = "#f44336";
        if (admin())
            $btn = 'btn-danger';
        else
            $btn = 'btn-default disabled';
            $status = 'Indisponível';
            $title = 'Este experimento está indisponível no momento';
            $txt = trans('interface.test');
        ?>

        <div class="col-lg-6 col-md-6 col-sm-6 {{$lab->subject}} lab">
            <div class="panel" style="background: #ECF0F1; ">
                <div class="panel-body">
                    <div class="row">
                        <div class='col-lg-5 col-md-5 col-sm-2'>
                            <img src="{{asset($lab->thumbnail)}}" width="100%">
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-10">
                            <b style="line-height:1">{{$lab->$name}}</b>
                            <p style="font-size:11pt; line-height: 1.2; padding-top:5px;"><?php echo $lab->$desc; ?></p>
                            <a href="{{url('/labs/'.$lab->id)}}" class="btn-sm {{$btn}}" role="button">{{$txt}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    @endforeach

</div>
@stop

@section('script')
<script>
    $(function () {
        $("#all").click(function () {
            $('.lab').show();
        });
        $(".subject").click(function () {
            $('.lab').show();
            var subject = '.' + $(this).attr('id');
            console.log($('.lab').not(subject));
            $('.lab').not(subject).hide("slow");
        });
    });
</script>
@stop



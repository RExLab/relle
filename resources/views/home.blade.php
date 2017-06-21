@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>trans('index.title')])}}
@stop

<style>
    .hide-bullets {
        list-style:none;
        margin-left: -40px;
        margin-top:20px;
    }  
    .item{
        height:50%;
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
        .item{
            height:40%;
        }
        .item-img{
            min-width:100%;
            height:200px;
            overflow: hidden;
        }
    }


    @media (min-width: 767px) {
        .item-img{
            min-width:100%;
            height:320px;
            overflow: hidden;
            margin-top: -20px;
        }

    }
    .bloco{
        width: 95%; 
        min-height: 100px; 
        margin-top:15px; 
        margin-left: 10px;
        padding:15px;
        text-align: center;
    }

    .bloco > p{
        color:white;
        font-size: 18pt;
    }
    .bloco-link:link, .bloco-link:visited, .bloco-link:hover, .bloco-link:active{
        text-decoration: none;
    }
</style>


<!--{{$name='name_'.App::getLocale()}}
{{$desc='description_'.App::getLocale()}}-->


@section ('content')

@include('carousel')

<div class="container" style="margin-top:35px;">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <h4 style="font-size: 18pt;">{{trans('index.what')}}</h4>
            <p>{{trans('index.what-desc')}} </p>
            <img src="{{asset('img/acesse.jpg')}}" width="100%">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <h4 style="font-size: 18pt;">{{trans('index.create')}}</h4>
            <p>{{trans('index.create-desc')}}</p>
            <img src="{{asset('img/crie.jpg')}}" width="100%" media="screen and (max-width: 760px)" style="margin-bottom: 10px;" >
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div id='courses'>
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading" style="padding:0 15px 0 15px">
                            <span style="font-size: 18pt;color:#34495e;font-weight: bold">{{trans('index.courses')}}</span>
                            <a href="http://gt-mre.ufsc.br/moodle/course/index.php" target="_blank" style="padding-left:15px; font-size: 12pt">
                                {{trans('index.all-courses')}} >
                            </a>
                    </div>
                    <!-- List group -->
                    <ul class="list-group">
                        @foreach($courses as $course)
                        <li class="list-group-item">
                            <a href="http://gt-mre.ufsc.br/moodle/course/view.php?id={{$course['id']}}" target="_blank">
                                <strong>{{$course['fullname']}}</strong>
                            </a>
                        </li>
                        @endforeach   
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
</script>
@stop



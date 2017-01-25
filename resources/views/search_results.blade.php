@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>trans('labs.title')])}}
@stop

@section('title')
<h2>{{trans('interface.search')}}</h2>
@stop

<?php
$name = 'name_' . App::getLocale();
$desc = 'description_' . App::getLocale();
?>

@section ('content')
<div class="row">    
    <div class="col-md-6 col-sm-12">   
        <h4>{{trans('labs.title')}}</h4>
        @if($result['labs'] != null)
        @foreach($result['labs'] as $lab)
        <div class="panel panel-default" style="background: #ECF0F1">
            <div class="panel-body">
                <?php
                if (status($lab->id)) {
                    $color = "#1abc9c";
                    $btn = 'btn-primary';
                    $status = 'Disponível';
                    $title = '';
                    $txt = trans('interface.access');
                } else {
                    $color = "#f44336";
                    if (admin() || guest())
                        $btn = 'btn-danger';
                    else
                        $btn = 'btn-default disabled';
                    $status = 'Indisponível';
                    $title = 'Este experimento está indisponível no momento';
                    $txt = trans('interface.test');
                }
                ?>
                <div class="row">
                    <div class='col-lg-5 col-md-5 col-sm-2'>
                        <img src="{{asset($lab->thumbnail)}}" class="img-responsive">
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-10">
                        <h5>{{$lab->$name}}</h5>
                        <p style="font-size:12pt; line-height: 1.3"><?php echo $lab->$desc; ?></p>
                        <a href="{{url('/labs/'.$lab->id)}}" class="btn btn-sm {{$btn}}" title="{{$title}}" role="button">{{$txt}}</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <!-- nothing of result -->
        @endif
        
    </div>


    <div class="col-md-6">   
        <h4>{{trans('docs.title_page')}}</h4>
        @if($result['docs'] != null)
        @foreach($result['docs'] as $doc)
        <div class="panel panel-default" style="background: #ECF0F1">
            <div class="panel-body">
                <div class="row">
                    <img src="{{asset('img/docs/'.formatIcon($doc->format).'.png')}}" class="col-md-2 img-responsive" style="margin-top:20px"></td>
                    <div class="col-md-7">
                        <h5>{{$doc->title}}</h5>
                        <p style="font-size:12pt; line-height: 1.3">{{trans('docs.'.$doc->type)}}<br>
                            {{formatSize($doc->size)}}</p>
                        <a href="{{asset($doc->url)}}" class="btn btn-sm btn-primary" role="button">{{trans('interface.access')}}</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <!-- nothing of result -->
        @endif
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



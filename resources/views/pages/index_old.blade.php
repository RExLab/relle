@extends('layout.default')

@section('page')
{{trans('interface.name', ['page'=>trans('index.title')])}}
@stop
<div id="slider_home"></div>
@section('outside')

<div class="hidden-lg hidden-md hidden-sm" style="margin-top: 10%">&nbsp;</div>

<div class="col-lg-8 index">
    <div class="col-lg-11 index_text_title">
        {{Lang::get('interface.home')}}
    </div>
    <div class="col-lg-11 index_text">
        {{Lang::get('index.description')}}
    </div>
    <div class="col-lg-4">
        <a href="{{url('/labs') }}">
            <div class="click_white">
                {{Lang::get('index.access')}}
                <span class="glyphicon glyphicon-menu-right" style="padding-left: 10px;"></span>
            </div>
        </a>
    </div>


</div>

@stop

@section('footer')
<script>
    $(function () {
        $('footer').addClass('home_footer');
        var local = '{{asset("img/slides/")}}';
        var i = 2;
        var interval = setInterval(function () {
            $('#slider_home').animate({opacity: 0.5}, 2500, function () {
                $(this)
                        .css({
                            'background': "url(" + local + '/index' + i + ".gif) no-repeat center center",
                            'background-size': 'cover',
                            'min-width': '100%',
                            'min-height': '100%',
                            'margin-top': '0',
                            'position': 'fixed'
                        })
                        .animate({opacity: 1}, 2500);
                if (i == 3) {
                    i = 1;
                } else {
                    i++;
                }
            });
        }, 7000);
    });

</script>
@stop


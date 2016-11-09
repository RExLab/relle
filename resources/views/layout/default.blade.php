<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield('page')</title>

        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/jasny-bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/select.min.css') }}" rel="stylesheet">


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link href="{{ asset('flat/dist/css/flat-ui.css') }}" rel="stylesheet">


        <link rel="shortcut icon" type="image/x-icon" href="{{asset('/favicon.png')}}"/> 
        <link href="//gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet">


        <!-- Fonts -->
        <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link href='//cdn.jsdelivr.net/jquery.roundslider/1.0/roundslider.min.css' rel="stylesheet">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>

        <!-- jQuery -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>




        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>

            .navbar{
                background:#34495E;
                border-bottom:9pt solid #2C3E50;
                border-radius: 0;

            }
            .navbar-inverse .navbar-nav>li>a{
                font-weight: normal;
            }
            .navbar-brand{
                margin-right:20px;
            }
            .navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus{
                //background: #34495E;
                margin-left: 15px;
                width: 115%;
            }
            .navbar-inverse .navbar-nav > .open > .dropdown-menu{
                margin-right: -20px;
            }
            footer,footer > a{
                color:#828282
            }


        </style>
        <style>
            .btn-default, .btn-default:hover, .btn-default.active, .open > .dropdown-toggle.btn-default {
                color: inherit;
                background-color: inherit;
            }
            .btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default:active.focus, .btn-default:active:focus, .btn-default:active:hover, .open>.dropdown-toggle.btn-default.focus, .open>.dropdown-toggle.btn-default:focus, .open>.dropdown-toggle.btn-default:hover {
                color: inherit;
                background-color: inherit;
            }
            #flag {
                max-width: 80px !important;
                min-width: 50px !important;

            }
        </style>
        @yield('head')
    </head>

    <body>
        {!! Analytics::render() !!}
        <div class="row">
            <div class="col-xs-12">
                <nav class="navbar navbar-inverse " role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
                                <span class="sr-only">Toggle navigation</span>
                            </button>
                            <a class="navbar-brand" href="{{url('/')}}">
                                <img src="{{asset('img/logo_dark.png')}}" height="110%"/>
                            </a>
                        </div>
                        <div class="collapse navbar-collapse" id="navbar-collapse-01">
                            <ul class="nav navbar-nav navbar-left">
                                <li><a href="{{url('labs')}}">{{trans('menu.labs')}}</a></li>
                                <li><a href="http://gt-mre.ufsc.br/moodle" target="_blank">{{trans('menu.courses')}}</a></li> 
                                <li><a href="http://docs.relle.ufsc.br/" target="_blank">{{trans('menu.tutorial')}}</a></li>
                                <li><a href="{{url('about')}}">{{trans('menu.about')}}</a></li>
                                <li><a href="{{url('contact')}}">{{trans('menu.contact')}}</a></li>
                            </ul>
                            <style>

                                 .caret {
                                    border-left: 6px solid transparent;
                                    border-right: 6px solid transparent;
                                    border-top: 8px solid #fff;
                                    left: 90%;
                                    top: 45%;
                                    position: absolute;
                                }
                            </style>
                            <ul class="nav navbar-nav navbar-right">
                                <div class="btn-group">
                                    <button style="color:none" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                      <!--  <span class="caret"></span> -->
                                        <?php
                                        if (App::getLocale() == 'pt') {
                                            ?>
                                            <li><a href="{{url('/pt')}}"><img src="{{asset('img/pt.png')}}"></a></li>
                                            <?php
                                        }
                                        if (App::getLocale() == 'en') {
                                            ?>
                                            <li><a href="{{url('/en')}}"><img src="{{asset('img/en.png')}}"></a></li>
                                            <?php
                                        }
                                        if (App::getLocale() == 'es') {
                                            ?>
                                            <li><a href="{{url('/es')}}"><img src="{{asset('img/es.png')}}"></a></li>
                                            <?php
                                        }
                                        ?>
                                        <center><span class="caret"></span></center>
                                    </button>
                                    <ul id='flag' class="dropdown-menu" role="menu">
                                        <li><a href="{{url('/en')}}"><img src="{{asset('img/en.png')}}"></a></li>
                                        <li><a href="{{url('/pt')}}"><img src="{{asset('img/pt.png')}}"></a></li>
                                        <li><a href="{{url('/es')}}"><img src="{{asset('img/es.png')}}"></a></li>
                                    </ul>
                                </div>
                            </ul>

                            <ul class="nav navbar-nav navbar-right">
                                <?php
                                if (Auth::check()) {
                                    $user = Auth::user();
                                    ?> 
                                    <li class="dropdown" style="margin-right: 35px;" >
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                            {{ $user['firstname']}}
                                            <span class="caret">
                                                <div style=" background-image:url({{asset($user['avatar'])}}); background-size: cover; " class="avatar"></div>
                                            </span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ url('dashboard') }}">{{trans('menu.dashboard')}}</a></li>
                                            <li><a href="{{ url('users/edit') }}">{{trans('users.edit')}}</a></li>
                                            <li class="divider"></li>
                                            <li><a href="{{ url('logout') }}">{{trans('menu.logout')}}</a></li>
                                        </ul>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li><a href="{{ url('login') }}">{{trans('menu.login')}}</a></li>
                                    <?php
                                }
                                ?>
                            </ul>


                            {!! Form::open(['url'=>'search','class'=>'navbar-form navbar-right', 'role'=>'search']) !!}
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" id="search" type="search" name="terms" placeholder="{{trans('interface.search')}}">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn"><span class="fui-search"></span></button>
                                    </span>
                                </div>
                            </div>
                            {!! Form::close() !!}


                        </div><!-- /.navbar-collapse -->
                    </div>
                </nav><!-- /navbar -->
            </div>
        </div> <!-- /row -->

        <div id='content'>
            @yield('outside')
            <div class="container">
                <div class="row">
                    <?php
                    if (App::getLocale() == 'en') {
                        echo '<br>';
                    }


                    $browser = get_browser($_SERVER['HTTP_USER_AGENT'], true)['browser'];
                    $mobile = get_browser($_SERVER['HTTP_USER_AGENT'], true)['ismobiledevice'];
                    if (($browser == 'Edge' || $browser == 'IE') && !$mobile) {
                        echo '<div class="alert alert-danger" role="alert" style="height:30px; padding-top:5px">'
                        . '<strong>' . trans('message.sorry') . '. </strong>'
                        . trans('message.browser1') . ' ' . $browser . '. '
                        . trans('message.browser2')
                        . '</div>';
                    }
                    ?>

                    <h3>@yield('title')</h3>
                    @yield('content')
                </div>
            </div>
        </div>
        @yield('footer')
        <div style="margin-top:150px;"></div>
        <footer class="footer" >
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-md-12 col-xs-12">
                        <p style="padding-bottom:20px">RELLE - Ambiente de Aprendizagem com Experimentos Remotos<br>
                            <a href='https://github.com/RExLab/relle' target='_blank'>GitHub</a>
                        </p>
                    </div> <!-- /col-xs-7 -->

                    <div class="col-lg-5 col-md-5 col-md-12 col-xs-12 logos-wrapper">
                        <center>
                            <ul class="footer-logos" style="padding-left:0">
                                <li><a href="http://www.capes.gov.br" target='_blank'><img src='{{asset('/img/footer/capes.png')}}'></a></li>
                                <li><a href="http://www.rnp.br" target='_blank'><img  style="height: 40px" src='{{asset('/img/footer/rnp.png')}}'></a></li>
                                <li><a href="http://rexlab.ufsc.br/" target='_blank'><img  style="height: 40px" src='{{asset('/img/footer/r.png')}}'></a></li>
                                <li><a href="http://ufsc.br/" target='_blank'><img src='{{asset('/img/footer/ufsc.png')}}'></a></li>
                            </ul>
                        </center>
                    </div>
                </div>
            </div>
        </footer>
    </body>

    <script src="{{ asset('/js/jasny-bootstrap.js') }}"></script>
    <script src="{{ asset('/js/select.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.redirect.js') }}"></script>
    <script src="{{ asset('/js/jquery.hideseek.js') }}"></script>
    <script src="//gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>
    <script src='//cdn.jsdelivr.net/jquery.roundslider/1.0/roundslider.min.js'></script>

    <script src="{{ asset('flat/dist/js/flat-ui.min.js') }}"></script>


    <script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(function () {
    $('radio').radiocheck();
    $('checkbox').radiocheck();
    $("select").select2({dropdownCssClass: 'dropdown-inverse'});
    $(".dropdown-toggle").dropdown();
    $('.selectpicker').selectpicker();
    $(".flat-switch").bootstrapSwitch();

});

    </script>

    @yield('script')

</html>

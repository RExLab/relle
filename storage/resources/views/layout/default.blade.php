<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield('page')</title>

        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/btn.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/jasny-bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/select.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/switch.css') }}" rel="stylesheet">


        <link rel="shortcut icon" type="image/x-icon" href="{{asset('/favicon.png')}}"/> 
        <link href="//gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">

        <!-- Fonts -->
        <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>


        <link href='//cdn.jsdelivr.net/jquery.roundslider/1.0/roundslider.min.css' rel="stylesheet">


        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>




        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        @yield('head')
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav1">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('/img/logos/logo.png') }}" height="40px" />
                    </a>
                </div>
                <?php
                if (App::getLocale() == 'pt')
                    $lang = 'pt_br';
                else
                    $lang = 'en';
                ?>
                <div class="collapse navbar-collapse" id='nav1'>
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/') }}">{{trans('menu.home')}}</a></li>
                        <li><a href="http://relle.ufsc.br/moodle/?lang={{$lang}}">Moodle</a></li>
                        <li><a href="{{ url('tutorial') }}">{{trans('menu.tutorial')}}</a></li>

                        <li><a href="http://rexlab.ufsc.br/gt-mre" target="_target">GT-MRE</a></li>
                        <li><a href="{{ url('contact') }}">{{trans('menu.contact')}}</a></li>
                        <!--
                        <li><a href="{{ url('/'.Lang::get('routes.about')) }}">{{Lang::get('menu.about')}}</a></li>
                        <li><a href="{{ url('/'.Lang::get('routes.contact')) }}">{{Lang::get('menu.contact')}}</a></li>
                        -->      
                        <?php if (!Auth::check()) { ?>
                            <li class="visible-xs"><a href="{{ url('login') }}">{{trans('menu.login')}}</a></li>
                        <?php } ?>
                    </ul>

                    <?php
                    if (App::getLocale() == 'en') {
                        $en = '#';
                        $pt = '/pt';
                    } else {
                        $en = '/en';
                        $pt = '#';
                    }
                    ?>

                    <ul class="nav navbar-nav navbar-right visible-lg visible-md visible-sm">
                        <li><a style='padding-right:0; padding-left:5px;' href="{{url($en)}}"><img src="{{asset('/img/en.png')}}"></a></li>
                        <li><a style='padding-right:0; padding-left:5px;' href="{{url($pt)}}"><img src="{{asset('/img/pt.png')}}"></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right visible-lg visible-md visible-sm">
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
                                    <li><a href="{{ url('logout') }}">{{trans('menu.logout')}}</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right visible-xs">
                            <?php
                            if (App::getLocale() == 'en') {
                                $lang = 'pt';
                            } else {
                                $lang = 'en';
                            }
                            ?>
                            <li><a href = "{{url('dashboard')}}">{{trans('menu.dashboard')}}</a></li>
                            <li><a href = "{{url($lang)}}">{{trans('interface.'.$lang)}}</a></li>
                            <li><a href = "{{url('logout')}}">{{trans('login.logout')}}</a></li>
                        </ul>
                        <?php
                    } else {
                        ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{ url('login') }}">{{trans('menu.login')}}</a></li>
                        </ul>

                        <?php
                    }
                    ?>

                    <ul class="nav navbar-nav navbar-right visible-lg visible-md">

                        <li style='margin-top: 10px; display: none; ' id='search_bar'>
                            {!! Form::open(['url'=>'labs','class'=>'navbar-form']) !!}
                            <div class="form-group has-feedback">
                                <input type="text" name="terms" id='search' placeholder="{{trans('interface.search')}}" class="form-control" />
                            </div>
                            {!! Form::close() !!}
                        </li>
                        <li>
                            <a href="#" id='search_btn'><span class="glyphicon glyphicon-search"></span></a>
                        </li>
                    </ul>
                </div>
            </div>    
        </nav>
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

                    <h1>@yield('title')</h1>
                    @yield('content')
                </div>
            </div>
        </div>
        <footer>
            @yield('footer')

            <a href="http://www.rnp.br" target='_blank'><img src='{{asset('/img/footer/rnp.png')}}'></a>
            <a href="http://www.capes.gov.br" target='_blank'><img src='{{asset('/img/footer/capes.png')}}'></a>
            <a href="http://rexlab.ufsc.br/gt-mre" target='_blank'><img style="height: 40px" src='{{asset('/img/footer/gtmre.png')}}'></a>
            <a href="http://rexlab.ufsc.br/" target='_blank'><img src='{{asset('/img/footer/r.png')}}'></a>
            <a href="http://ufsc.br/" target='_blank'><img src='{{asset('/img/footer/ufsc.png')}}'></a>
        </footer>
    </body>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{ asset('/js/jasny-bootstrap.js') }}"></script>
    <script src="{{ asset('/js/select.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.redirect.js') }}"></script>
    <script src="{{ asset('/js/switch.js') }}"></script>
    <script src="//gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>
    <script src='//cdn.jsdelivr.net/jquery.roundslider/1.0/roundslider.min.js'></script>
    <script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(function () {
    $('.selectpicker').selectpicker();

    $('#search_btn').click(function (e) {
        $('#search_bar').toggle('slide', {direction: 'right'}, 500);
    });
});

    </script>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-66969703-1', 'auto');
        ga('send', 'pageview');

        (function (h, o, t, j, a, r) {
            h.hj = h.hj || function () {
                (h.hj.q = h.hj.q || []).push(arguments)
            };
            h._hjSettings = {hjid: 82466, hjsv: 5};
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script');
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, '//static.hotjar.com/c/hotjar-', '.js?sv=');


    </script>
    @yield('script')

</html>

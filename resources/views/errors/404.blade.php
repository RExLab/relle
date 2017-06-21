@extends ('layout.default')

@section ('page')
Error 404
@stop


@section ('content')
    {{Analytics::trackEvent('Página', 'Erro 404')}}

<center>
    <br><br>
    <img src="img/404_{{App::getLocale()}}.png" width="25%"/>
</center>
@stop




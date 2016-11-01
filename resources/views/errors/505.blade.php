@extends ('layout.default')

@section ('page')
{{trans('errors.error5')}}
@stop
    {{Analytics::trackEvent('Página', 'Erro 505')}}


@section('content')

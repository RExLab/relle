@extends('layout.default')
    {{Analytics::trackEvent('Página', 'Sobre')}}

@section('page', trans('menu.about'))
@section('title', trans('menu.about'))

@section('content')
<div class="row">
    <div class="col-lg-8 col-xs-12">
        <h4><?php echo trans('about.what');?></h4>
        <p><?php echo trans('about.what-desc');?></p>
        <h4><?php echo trans('about.who');?></h4>
        <p><?php echo trans('about.who-desc');?></p>
        <h4><?php echo trans('about.can-use');?></h4>
        <p><?php echo trans('about.can-use-desc');?></p>
        
        <h4><?php echo trans('about.can-create');?></h4>
        <p><?php echo trans('about.can-create-desc');?></p>
        
        <h4><?php echo trans('about.can-install');?></h4>
        <p><?php echo trans('about.can-install-desc');?></p>
    </div>
    <div class="col-lg-6 col-xs-12">
        
    </div>
</div>
@stop
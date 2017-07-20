@extends ('layout.default')

@section ('page')
{{trans('contact.title')}}
@stop
@section('content')
{{Analytics::trackEvent('Página', 'Contato')}}

@if ($errors->has('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>{{trans('interface.sorry')}}.</strong> {{trans('message.contact_error')}}
</div>
@endif

@if ($errors->has('sent'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{trans('message.contact_sent')}}
</div>
@endif
<h1><center>{{trans('contact.title')}}</center></h1><br>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <form class="form-horizontal" method="POST" action="contact" accept-charset="UTF-8">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <fieldset>


                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="email">E-mail</label>  
                    <div class="col-md-4">
                        <input id="email" name="email" type="text" placeholder="E-mail" class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">{{ trans('contact.name') }}</label>  
                    <div class="col-md-4">
                        <input id="textinput" name="name" type="text" placeholder="{{ trans('contact.name') }}" class="form-control input-md">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">{{ trans('contact.subject') }}</label>  
                    <div class="col-md-4">
                        <input id="textinput" name="subject" type="text" placeholder="{{ trans('contact.subject') }}" class="form-control input-md">
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="content">{{ trans('contact.content')}}</label>
                    <div class="col-md-4">                     
                        <textarea class="form-control" name='message' id="textarea"></textarea>
                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-4">                     
                        <button id="singlebutton" name="{{ trans('contact.send')}}" class="btn btn-default pull-right">{{ trans('contact.send')}}</button>
                    </div>
                </div>

            </fieldset>
        </form>

    </div>
</div>

@stop

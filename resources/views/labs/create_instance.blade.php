@extends ('layout.dashboard')

@section('inside-head')
<style>
    .entry:not(:first-of-type){
        margin-top: 10px;
    }
    .input-group-btn{
        margin-top:-15px;
    }
</style>
@stop

@section('page')
{{trans('interface.name', ['page'=>trans('labs.create')])}}
@stop


<?php $url = trans('routes.labs') . '/' . trans('routes.create'); ?>

 
@section ('inside')
<h4>{{trans('labs.createInstance')}}</h4>
{!!
Form::open([
'files' => true,
'enctype'=> 'multipart/form-data'
])
!!}
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">{{trans('labs.description')}}</a></li>
                    <li><a href="#tab2" data-toggle="tab">{{trans('labs.files')}}</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    
                    <!--
                        TAB 1
                    -->
                    
                    

                    <div class="tab-pane active" id="tab1">
                    <div class='lang-box col-lg-12' style="margin-top:20px;">
                        <div class='form-group col-lg-6 col-xs-12 pt'>
                            

                        {!! Form::Label('lab_id', 'Item:') !!}
                        {!! Form::select('lab_id', $labs, null, ['class' => 'form-control select select-primary select-block mbl']) !!}

                        </div>
                    </div>

                        <div class='lang-box col-lg-12'>
                            <div class='form-group col-lg-6 col-xs-12 pt'>
                                <label for='description'>{{trans('labs.description')}}</label>
                                <input name='description' placeholder="My Lab Description" id='description' class='form-control' type='text'/>
                                @if ($errors->has('description')) <p class="text-danger">{{ $errors->first('description') }}</p> @endif
                            </div>
                            <div class='form-group col-lg-6 col-xs-12 pt'>
                                <label for='address'>{{trans('labs.address')}}</label>
                                <input name='address' placeholder="mylab.address.com" id='description' class='form-control' type='text'/>
                                @if ($errors->has('address')) <p class="text-danger">{{ $errors->first('address') }}</p> @endif
                            </div>
                        </div>

                        <div class='lang-box col-lg-12' style="margin-top:20px;">
                            <div class='form-group col-lg-6 col-xs-12 pt'>
                                {!! Form::label('duration', trans('labs.duration')) !!}
                                    {!! Form::input('number','duration', null, ['class'=>'form-control']) !!}
                                    @if ($errors->has('duration')) <p class="text-danger">{{ $errors->first('duration') }}</p> @endif
                            </div>
                            <div class='form-group col-lg-6 col-xs-12 pt'>
                                <label for='maintenance'>{{trans('labs.maintenance')}}</label><Br>
                                <input type="checkbox" class="flat-switch" name="maintenance" id="maintenance" />
                            </div>
                        </div>
                        <a class="btn btn-success pull-right btnNext">{{trans('interface.next')}}</a>
                    </div>

                    <!--
                        TAB 2
                    -->

                     <div class="tab-pane fade" id="tab2">

                        <div class='form-group'>

                            <h6>{{trans('labs.files')}}</h6>
                            <p>{{trans('labs.instanceinstruction')}}</p>
                            
                            {{trans('labs.package')}}
                            </br>
                            {!! Form::input('file', 'package')!!}

                        </div>

                        <a class="btn btn-success pull-left btnPrevious">{{trans('interface.previous')}}</a>
                        {!! Form::submit(trans('interface.submit'), ['class'=>'btn btn-success pull-right'])!!}
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}
@stop

@section('script_dash')
<script>
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')}
    });
    $(function () {
        $('#btn-get').click(function () {
            console.log('entrou');
            $.getJSON("{{asset('metadata.json')}}", function (data) {
                console.log('entrou2');
                console.log(data);
            });

        });
    });

    $('.btnNext').click(function(e){
    if($('.nav-tabs > .active').next('li').hasClass('btnNext')){
        $('.nav-tabs > li').first('li').find('a').trigger('click');
    }else{
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
    }
    e.preventDefault();
    });

    $(function ()
    {
        $(document).on('click', '.btn-add', function (e)
        {
            e.preventDefault();

            var controlForm = $('.controls'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

            newEntry.find('input').val('');
            controlForm.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
        }).on('click', '.btn-remove', function (e)
        {
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
        });
    });

</script>
@stop


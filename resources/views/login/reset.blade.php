@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>trans('login.reset')])}}
@stop

@section('head')
<style>
    body{
        background: -webkit-linear-gradient(90deg, #00AA8A 10%, #006653 90%); /* Chrome 10+, Saf5.1+ */
        background:    -moz-linear-gradient(90deg, #00AA8A 10%, #006653 90%); /* FF3.6+ */
        background:     -ms-linear-gradient(90deg, #00AA8A 10%, #006653 90%); /* IE10 */
        background:      -o-linear-gradient(90deg, #00AA8A 10%, #006653 90%); /* Opera 11.10+ */
        background:         linear-gradient(90deg, #00AA8A 10%, #006653 90%); /* W3C */
    }
    .profile-img {
        width: 96px;
        height: 96px;
        margin: 0 auto 10px;
        display: block;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
    }
    #tabs{
        margin-top: -10px;
    }
</style>
@stop

@section ('content')
@if ($errors->has())
    @foreach($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{trans('interface.sorry')}}.</strong>
            {{ $error }}
        </div>
    @endforeach
@endif
<div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">

        <div id="my-tab-content" class="tab-content" >
            <img class="profile-img" src="{{ asset('/img/default.gif') }}"
                 alt="">
            <form class="form-group form-signin" action="{{url('/password/reset')}}" method="post">
                <center><h1 style="color:white">{{trans('login.reset')}}</h1></center>

                <input name="password" type="password" class="form-control" placeholder="{{trans('login.new')}}" required autofocus>
                <input name="repeat" type="password" class="form-control" placeholder="{{trans('users.repeat')}}" required>
                <input type="hidden" name="token" value="{{$token}}">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <button type="submit" class="btn btn-fresh pull-right">{{trans('interface.submit')}}</button>

            </form>
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    $(function () {
        $('footer').addClass('forget_footer');
    });
</script>
@stop
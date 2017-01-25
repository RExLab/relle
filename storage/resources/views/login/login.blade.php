
@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>trans('login.login')])}}
@stop

@section('head')
<style>
    body{
        background: -webkit-linear-gradient(90deg, #00AA8A 10%, #006653 100%); /* Chrome 10+, Saf5.1+ */
        background:    -moz-linear-gradient(90deg, #00AA8A 10%, #006653 100%); /* FF3.6+ */
        background:     -ms-linear-gradient(90deg, #00AA8A 10%, #006653 100%); /* IE10 */
        background:      -o-linear-gradient(90deg, #00AA8A 10%, #006653 100%); /* Opera 11.10+ */
        background:         linear-gradient(90deg, #00AA8A 10%, #006653 100%); /* W3C */
        margin-bottom:0;
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
<div id='error' style="display:none;" class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>{{trans('interface.sorry')}}.</strong>
    {{ trans('message.login') }}
</div>
<center>
    <div class="row">

        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">

            <div id="my-tab-content" class="tab-content" >
                <img class="profile-img" src="{{ asset('/img/default.gif') }}" alt=""> 

                <form class="form-group form-signin" id='form' >

                    <center><h1 style="color:white">{{trans('login.login')}}</h1></center>
                    <input name="username" id='username' type="text" class="form-control" placeholder="{{trans('login.username')}}" required autofocus>
                    <input name="password" id='password' type="password" class="form-control" placeholder="{{trans('login.password')}}" required>
                    <p style="color:white">
                    </p> 
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <button id="submit" class="btn btn-lg btn-fresh btn-block">{{trans('interface.submit')}}</button>


                </form>

                <div id="tabs" data-tabs="tabs" style="text-align: center;">
                    <a href="{{url('/users/signup')}}"  style="color:white">{{trans('login.signup_msg')}} </a>
                    <a href="{{url('/login/forgot')}}" style="color:white; padding-left:50px">{{trans('login.forgot_msg')}}</a>

                </div> 

            </div>  
        </div>      
    </div>
</center>
@stop

@section('script')
<script>
    //default goto
    var goto = 'http://relle.ufsc.br/';
            $(function () {
            @if (isset($error))
                    $("#error").show(1000);
                    @endif
                    @if (isset($sent))
                    $("#error").removeClass('alert-danger');
                    $("#error").removeClass('alert-success');
                    $("#error").append('{{ trans('message.sent') }}');
                    $("#error").show(1000);
                    @endif


                    $('footer').addClass('login_footer');
                    /*
                     * If user is already loged in on moodle, goes back
                     */

                    $('#submit').click(function (event) {
            var formData = {             'username': $('input[name=username]').val(),
                    'password': $('input[name=password]').val(),
                    '_token': $('input[name=_token]').val(),
                    'rememberme': $('input[name=rememberme]').val()
            };
                    var login_relle = false;
                    var login_moodle = false;
                    $.ajax({
                    url: "http://relle.ufsc.br/login",
                            data: formData,
                            type: "POST",
                            success: function (data) {
                            if (data.goto) {
                            goto = data.goto;
                            } else if (data.error) {
                            goto = false;
                                    $("#error").show(1000);
                            }
                            },
                            error: function(){
                            $("#error").show(1000);
                            },
                    });
                    $.ajax({
                    url: "http://relle.ufsc.br/moodle/login/auth.php",
                            data: formData,
                            type: "POST",
                            //moodle returns error 404 if user is not found
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                            goto = false;
                                    $("#error").show(1000);
                            },
                            success: function () {
                            if (document.referrer.search('moodle') >= 0) {
                            goto = document.referrer;
                            }
                            },
                    });
                    event.preventDefault();
            });
            });
            $(document).ajaxStop(function () {
    if (goto)
            window.location.href = goto;
    });
</script>
@stop


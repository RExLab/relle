{{Analytics::trackEvent('Página', 'Login')}}
@extends ('layout.default')

@section('page')
{{trans('interface.name', ['page'=>trans('login.login')])}}
@stop

@section('head')
<style>

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

                    <center><h1>{{trans('login.login')}}</h1></center>
                    <input name="username" id='username' type="text" class="form-control" placeholder="{{trans('login.username')}}" required autofocus>
                    <input name="password" id='password' type="password" class="form-control" placeholder="{{trans('login.password')}}" required>
                    <p style="color:white">
                    </p> 
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <button id="submit" class="btn btn-lg btn-fresh btn-block">{{trans('interface.submit')}}</button>


                </form>

                <div id="tabs" data-tabs="tabs" style="text-align: center;">
                    <a href="{{url('/users/signup')}}">{{trans('login.signup_msg')}} </a>
                    <a href="{{url('/login/forgot')}}" style="padding-left:50px">{{trans('login.forgot_msg')}}</a>

                </div> 

            </div>  
        </div>      
    </div>
</center>
@stop

@section('script')
<script>
    //default goto
   
    $(function () { 
                var goto = '{{url("/")}}';
                var login_url = '{{url("login")}}';
      $('#submit').click(function (event) {
          
          
            var formData = {             
                    'username': $('input[name=username]').val(),
                    'password': $('input[name=password]').val(),
                    '_token': $('input[name=_token]').val()
            };
            $.ajax({
                    method:'post',
                    url: login_url,
                    data: formData,
                    success: function (data) {    
                        console.log(data);
                        if (data.goto) {
                            goto = data.goto;
                            window.location.href=goto;
                            console.log('primeiro');
                        } else if (data.errors) {
                            $("#error").show(1000);
                            console.log(data.errors);
                            console.log('segundo');
                            event.preventDefault();
                        }else{
                            window.location.href=goto;
                            console.log('terceiro');
                            event.preventDefault();
                        }
                    },
                    error: function(){
                        $("#error").show(1000);                       
                    }
            });
            });
        });
</script>
@stop


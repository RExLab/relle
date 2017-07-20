@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('users.bulk')])}}
@stop

@section("title_inside")
{{trans('users.bulk')}}
@stop



@section ('inside')

<style>
    .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus{
        background-color:#00aa8a;
        border:1px solid white;
    }
    .dual-list .list-group {
        margin-top: 8px;
    }

    .list-left li, .list-right li {
        cursor: pointer;
    }

    .list-arrows {
        padding-top: 100px;
    }

    .list-arrows button {
        margin-bottom: 10px;
    }
    .list{
        height: 200px;
        overflow: auto;
    }

    .has-feedback {
        position: relative;
    }
    .has-feedback .form-control {
        padding-right: 42.5px;
    }
    .form-control-feedback {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 2;
        display: block;
        width: 34px;
        height: 34px;
        line-height: 34px;
        text-align: center;
        pointer-events: none;
    }
    .input-lg + .form-control-feedback {
        width: 46px;
        height: 46px;
        line-height: 46px;
    }
    .input-sm + .form-control-feedback {
        width: 30px;
        height: 30px;
        line-height: 30px;
    }
</style>
<br />
<div class="row">
    <div id='msg'></div>

    <div class="dual-list list-left col-md-5">
        <div class="well text-right">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group has-feedback">
                        <input type="text" name="SearchDualList" id='search'  placeholder="{{trans('interface.search')}}" class="form-control" />
                        <i class="glyphicon glyphicon-search form-control-feedback"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="btn-group" style='margin-left:-15px;'>
                        <a class="btn btn-default selector" style='box-shadow:none;' title="select all"><i class="fa fa-square-o"></i></a>
                    </div>
                </div>
            </div>
            <ul class="list-group list" id='left'>
                <?php foreach ($users as $user) { ?>
                    <li class="list-group-item" style="text-align:left;" username='{{$user['username']}}'>{{$user['firstname']}} {{$user['lastname']}}</li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="list-arrows col-md-1 text-center">
        <button class="btn btn-default btn-sm move-left">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </button>

        <button class="btn btn-default btn-sm move-right">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </button>
    </div>
    <div class="col-md-5">
        <div class="dual-list list-right">
            <div class="well">
                <div class="row">
                    <div class="col-md-2">
                        <div class="btn-group">
                            <a class="btn btn-default selector" style='box-shadow:none;' title="select all"><i class="fa fa-square-o"></i></a>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="input-group">
                            <div class="form-group has-feedback">
                                <input type="text" name="SearchDualList" id='search'  placeholder="{{trans('interface.search')}}" class="form-control" />
                                <i class="glyphicon glyphicon-search form-control-feedback"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-group list" id='right'>

                </ul>
            </div>

        </div>
        <div id='list' style='display:none;' class="pull-right">
            <p>{{trans('interface.with_user')}}</p>
            <select class='selectpicker' id='action'>
                <option value="/users/admin">{{trans('interface.make_admin')}}</option>
                <!--<option value="/users/delete/bulk">{{trans('interface.delete')}}</option>-->
                <option value="/users/export/bulk">{{trans('interface.export')}}</option>
            </select>
            <button class="btn btn-default" id='send'>{{trans('interface.select')}}</button>
        </div>

    </div>
</div>
@stop
@section('script_dash')
<script>
    $(function () {

        $('body').on('click', '.list-group .list-group-item', function () {
            $(this).toggleClass('active');
            //$(this).css('background-color', '#00AA84');
            //$(this).css('border', '1px solid white');
        });
        $('.list-arrows button').click(function () {
            var $button = $(this), actives = '';
            if ($button.hasClass('move-left')) {
                actives = $('.list-right ul li.active');
                actives.clone().appendTo('.list-left ul');
                actives.remove();
                if (!($('#right li').length)) {
                    $('#list').hide();
                }
            } else if ($button.hasClass('move-right')) {
                actives = $('.list-left ul li.active');
                actives.clone().appendTo('.list-right ul');
                actives.remove();
                $('#list').show();
            }
        });
        $('.dual-list .selector').click(function () {
            var $checkBox = $(this);
            if (!$checkBox.hasClass('selected')) {
                $checkBox.addClass('selected').closest('.well').find('ul li:not(.active)').addClass('active');
                $checkBox.children('i').removeClass('fa-square-o').addClass('fa-check-square-o');
            } else {
                $checkBox.removeClass('selected').closest('.well').find('ul li.active').removeClass('active');
                $checkBox.children('i').removeClass('fa-check-square-o').addClass('fa-square-o');
            }
        });
        $('[name="SearchDualList"]').keyup(function (e) {
            var code = e.keyCode || e.which;
            if (code == '9')
                return;
            if (code == '27')
                $(this).val(null);
            var $rows = $(this).closest('.dual-list').find('.list-group li');
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
            $rows.show().filter(function () {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });

        $('#send').click(function () {
            var action = $('#action').val();
            var users = $('#right li').map(function () {
                return $(this).attr('username');
            }).get().join();
            //var data = $.parseJSON(users.split(','));
            var data = {users:users};
            console.log(data);
            if(action=='/users/export/bulk'){
                $.redirect(action, data, '_blank');
            }else{
                $.ajax({
                    type: "POST",
                    url: action,
                    data: data,
                    success: function () {
                        $('#msg').html(
                               '<div class="alert alert-success fade in">'+
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                    '<strong>{{trans('message.success')}}. </strong>{{trans('message.request')}}'+
                                '</div>'
                                ).children(':last').fadeIn(1000);
                    },
                    error: function () {
                        $('#msg').html(
                                 '<div class="alert alert-danger fade in">'+
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                    '<strong>{{trans('message.sorry')}}. </strong>{{trans('message.error')}}'+
                                '</div>'
                                ).children(':last').fadeIn(1000);
                    }
                });
            }

        });

    });
</script>
@stop

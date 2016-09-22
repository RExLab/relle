@extends('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('dashboard.title')])}}
@stop

@section('inside')

<div class="row">
    <center>
        <div class="col-md-6">
            <div class="content-box-header">
                <div class="panel-title">{{trans("log.labsAccess")}} </div>
            </div>
            <div class="content-box-large box-with-header">

                <canvas id="labs" style="margin-left:auto;" height="350" width="350"></canvas>
            </div>
        </div>
    </center>
    <center>

        <div class="col-md-6">
            <div class="content-box-header">
                <div class="panel-title"> {{trans("log.mobileAccess")}}</div>
            </div>
            <div class="content-box-large box-with-header">
                <canvas id="mobile" style="margin-left:auto;" height="350" width="350"></canvas>
            </div>
        </div>
    </center>

    <div class="col-md-12">
        <div class="content-box-header" >
            <div class="panel-title"> {{trans("log.map")}}</div>
        </div>
        <div class="content-box-large box-with-header" style="padding:0;">
            <div id="gmap" style="height:470px; width: 100%; "></div>
        </div>
    </div>
    <center>
        <div class="col-md-6">

            <div class="content-box-header">
                <div class="panel-title"> {{trans("log.browserAccess")}} </div>
            </div>
            <div class="content-box-large box-with-header">
                <canvas style="margin-left:auto;" id="browser" height="350" width="350"></canvas>
            </div>
        </div>
    </center>
    <div class="col-md-6">
        <div class="content-box-header">
            <div class="panel-title"> {{trans("log.countryAccess")}}</div>
        </div>
        <div class="content-box-large box-with-header" style="overflow: auto; height:350px ;width: 100%;">
            <table class='table table-condensed table-striped' >
                <thead>
                    <tr>
                        <th>{{trans('log.country')}}</th>
                        <th>{{trans('log.accesses')}}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (country() as $country) { ?>
                        <tr>
                            <td>{{$country['country']}}</td>
                            <td>{{$country['value']}}</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
@stop
@section('script_dash')

<script type="text/javascript" src='{{asset("js/ChartNew.js")}}'></script>
<script type="text/javascript" src='{{asset("js/chartScript.js")}}'></script>
<script src="//maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.7"></script>
<script src="js/maplace.js"></script>

<script type="text/javascript">
                $(function() {

                $.ajax({
                type: "POST",
                        url: "map",
                        success:function(data){
                        data = $.parseJSON(data);
                                new Maplace({
                                locations: data,
                                        controls_on_map: false,
                                        map_options: {
                                                set_center: [9.5718454, 24.1925222],
                                                zoom:2
                                        }
                                }).Load();
                        }
                });
                });
</script>

@stop



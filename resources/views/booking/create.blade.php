@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('book.create')])}}
{{$name='name_'.App::getLocale()}}
@stop

@section ('title_inside')
{{trans('book.create')}}
@stop

@section ('inside')
<!------------------------------Mensagens de Erro--------------------------------->
<div id='error1' style='display:none' class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>{{ trans('book.error1') }}</strong>&nbsp{{ trans('book.durac2') }}
</div>
<div id='error2' style='display:none' class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>{{ trans('book.error2') }}&nbsp</strong> 
</div>
<div id='error3' style='display:none' class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>{{ trans('book.error3') }}</strong>
</div>
<div id='error4' style='display:none' class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>{{trans('book.sorry')}},</strong>&nbsp{{ trans('book.error4') }} 
</div>
<div id='error5' style='display:none' class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>{{trans('book.please')}},</strong>&nbsp{{ trans('book.error5') }}
</div>
<!-------------------------------------------------------------------------------->

<link href="http://relle.ufsc.br/teste/css/datepicker.css" rel="stylesheet">
<script src="http://relle.ufsc.br/teste/js/datepicker.js"></script>

<?php $horaServidor = date('H:i:s') ?>

<style>
@font-face {
    font-family: 'digital8';
    src: url('http://relle.ufsc.br/teste/fonts/digital-7.ttf');
}
    
.datetimepicker.dropdown-menu{
    width: auto;
}
.datetimepicker td:hover{
    background:#EEEEEE;
}
.datetimepicker .has-switch{
    display: table-cell;
    -webkit-mask: none;
}
.datetimepicker{
    display: none;
    border: 1px solid #CCC;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 4px;
}
#linha1 {
    margin-bottom: 0px
}
#horaServ {
    opacity: 0.5;
    filter: alpha(opacity=50);
    color: #2C3E50;
    font-size: 20px;
    font-family: digital8; 
    font-weight: bold;
    position: relative;
    left: 38%;
}
</style>

<!-----------------------Inicio da Estrutura da página---------------------------->
<div class="row">
    <div class="form-group col-lg-4 col-md-6 col-sm-12" id="linha1">
        <label>{{trans('book.exp')}}</label>
        <select class="form-control select select-default" name="type" id="exp_id" onchange="mudarDescricao()">
            @foreach($labs as $lab)
                <option data-duration="{{$lab->duration}}" value="{{$lab->id}}">{{$lab->$name}}</option>
            @endforeach
        </select>
        <small>{{trans('book.small1')}}<span id="small1">8</span>{{trans('book.min')}}</small>
    </div>
    <div class="form-group col-lg-4 col-sm-12" id="linha1">
        <label>{{trans('book.duration')}}</label>
        <select class="form-control select select-default" id="duration2">
            <option  value="nse">{{trans("book.nse")}}</option>
            <option  value="nmin" selected="selected">{{trans("book.nmin")}}</option>
        </select>
    </div>
    <div class="form-group col-lg-2 col-sm-12" id="linha1">
        <input type=number min="1" max="120" class="form-control" id="durationBox" value="10" style="margin:39px 0px; text-align: left">
    </div>
</div>

<div class="row" >
    <div class="form-group col-lg-4 col-sm-12">
        <label>{{trans('book.date')}}</label>
        <input type="text" value="<?php echo date("Y-m-d"); ?>" id="datepickerID" class="form-control">
    </div>
    <div class="form-group col-lg-4 col-sm-12">
        <label>{{trans('book.time')}}</label>
        <input type="time" class="form-control" value="<?php echo date("H:i"); ?>" id="timepickerID">
        <small>{{trans('book.small2')}}</small>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <button onclick="calcDuration();submintOutput()" class="btn btn-primary btn-wide">{{trans("interface.submit")}}</button>
    </div>
</div>
<div id="horaServ">
    <span id='hour'></span>:<span id='min'></span>:<span id='seg'></span>
    <label style="font-size:10px;font-weight: bold; color: #2C3E50; font-family:arial; position:absolute; left: 60px; top:5px">&nbsp (GMT - 03:00 / Brasilia, Brasil) </label>
</div>
<!------------------------------------------------------------------------------->

<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
    });
    
    var lab_id, time, date, duration, durationMin;
    
    $(document).ready(function () {
        $('#datepickerID').datepicker({
            format: "yyyy-mm-dd",
            language: "pt-br"
        });
    });
      
    var e = document.getElementById("duration2");
    var itemSelected = e.options[e.selectedIndex].value;
        
    $(document).ready(function(){
        var previousvalue = itemSelected;
        $('#duration2').on('change',function(){
            if(previousvalue === "nmin" && $(this).val() === "nse") {
                document.getElementById("durationBox").value = "1";
                itemSelected = "nse";
            }
            else if(previousvalue === "nse" && $(this).val() === "nmin"){
                document.getElementById("durationBox").value = "10";
                itemSelected = "nmin";
            }
            previousvalue = $(this).val();
        });
    });
    
    function calcDuration() {
        var user_durac = $("#durationBox").val();
        var exp_durac = $('#exp_id option:selected').data("duration");
        if (itemSelected === "nse") {
            durationMin = user_durac * exp_durac;
        } else {
            durationMin = user_durac;
        }
    };
    
    function submintOutput() {
        date = document.getElementById('datepickerID').value;
        time = document.getElementById('timepickerID').value;
        lab_id = $('#exp_id option:selected').val();
        duration = durationMin;
        
        $.ajax({
        method: "POST",
        url: "",
        data: { date: date, time: time, lab_id: lab_id, duration: duration }
        })
        .done(function(data) {
            if(typeof(data)=="object"){
                if(data.erro){
                    if(data.erro == 1 ){
                        $("#error1").show(1000);
                        return;
                    }                   
                    if(data.erro == 2){
                        $("#error2").show(1000);
                        return;
                    }
                    if(data.erro == 3){
                        $("#error3").show(1000);
                        return;
                    }   
                }
                location.href = "/teste/booking/all";
            } else{
                if(duration == "" || time == "" || date == "")
                    $("#error5").show(1000);
                else
                    $("#error4").show(1000); 
        }
    });
}
    function mudarDescricao(){      
        varDuration = $('#exp_id option:selected').data("duration");
        $('#small1').text(varDuration)                   
    }


    var serverHour = "<?php echo $horaServidor; ?>";
    var serverHourArray = serverHour.split(':');

    $("#hour").html(serverHourArray[0]);
    $("#min").html(serverHourArray[1]);
    $("#seg").html(serverHourArray[2]);

    function startTime() {  
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('clock').innerHTML =
        h + ":" + m + ":" + s;

    }

    function clock1() {
        var totalseg = 1+ parseInt($("#hour").html())*60*60 + parseInt($("#min").html()) * 60 + parseInt($("#seg").html());
        var mins = totalseg / 60;
        var horas = parseInt(mins/60);
        var seg = Math.round(totalseg - parseInt(mins)*60);
        var min = parseInt(mins-parseInt(horas)*60);
        
        zero = "";
        if (horas < 10) {
            zero = "0";
        }
        $("#hour").html(zero + horas);

        var zero = "";
        if (seg < 10) {
            zero = "0";
        }
        $("#seg").html(zero + seg);
        
        zero = "";
        if (min < 10) {
            zero = "0";
        }
        $("#min").html(zero + min);

    }

    $(document).ready(function () {
        setInterval(clock1, 1000);
    });
</script>
@stop


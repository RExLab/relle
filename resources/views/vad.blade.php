@extends('layout.default')

@section('content')

<link href="/css/dash_styles.css" rel="stylesheet" type="text/css"/>
<style>
    #menu{
        margin: 0 0 0 4px;
    }
    @-moz-document url-prefix() {
        #menu{
            margin: -15px 0 0 4px;
        }
    }
    .btn-default{
        box-shadow: none;
        margin: 0;
        background-color: white;
        opacity: 0.65;
        border:0;
        height: 25px;
        width: 25px;
    }
    .round{
        border-radius: 50% 50%;

    }
    .square{
        border-radius: 0;

    }
    .fa{
        margin-left:-4px;
    }
    #tab{
        height: 30px;
        font-size: 10pt;
        min-width: 100px;
    }
    #output{
        width: 100%;
        height: 150px;
        overflow: auto;
        background-color: black;
        color: white;
        padding:10px;
        border:0;
        border-bottom: 10px solid black;
    }



    #verify_bar{
        width: 100%;
        height: 35px;
        background-color: #00979C;
        border-top: solid 1px grey;
        padding:8px;
    }
    #acting{
        font-size: 8pt;
        color:white;
    }
    .btn_normal{
        width: 70px; 
        height: 35px; 
        border: 1px solid grey;
        margin-right: 5px;
        box-shadow: none;
        border:none;
    }
    #after{
        background-color: black;
    }

    .content-box-header{
        background-color: grey;
    }
    .panel-footer{
        background-color: #c4c4c4;
    }

    #serial_list > li{
        list-style: none;
        padding-left: 0;
        margin-left: -30px;
    }

</style>


<div id='DivExp' class="container" style="margin-top: -20px;">
    <h1>Experimento</h1>

    <div class='col-lg-10 col-lg-offset-1' id='ide'>
        <div class="content-box-header" style="background-color: #00979C;">
            <div class="panel-title">
                <ul class="nav nav-tabs">
                    <li class="dropdown">
                        <button class="btn btn-default dropdown-toggle square" type="button" data-toggle="dropdown" style="margin-right:8px;"><i class="fa fa-bars" style="margin-left: -6px;"></i></button>
                        <ul class="dropdown-menu">
                            <li><a href="#" id="editing">file.ino</a></li>
                            <li class="dropdown-submenu"> 
                                <a href="#">Examples</a>
                                <ul class="dropdown-menu">

                                    <li><a href="#" id="servo">LCD + Servo</a></li>
                                    <li><a href="#" id="led">LCD + LED</a></li>
                                    <li><a href="#" id="dht11">LCD + DHT11</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu"> 
                                <a href="#">Libraries</a>
                                <ul class="dropdown-menu">

                                    <li><a href="#" id="servo_h">Servo.h</a></li>
                                    <li><a href="#" id="crystal_h">LiquidCrystal.h</a></li>
                                    <li><a href="#" id="dht_h">dht.h</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="active"><a href="#" id="tab">file.ino</a></li>

                    <li id='menu' >
                        <ul style="margin-left:-38px;">
                            <li style="display:inline;"><a href="#" class="btn btn-default round" id='verify' style='opacity: 0.35;' disabled><i class="fa fa-check" style="margin-left: -6px;"></i></a></li>
                            <li style="display:inline;"><a href="#" class="btn btn-default round" id='upload' style='opacity: 0.35;' disabled><i class="fa fa-arrow-right" style="margin-left: -6px; "></i></a></li>
                            <li style="display:inline;"><a href="#" class="btn btn-default square" id='open' ><i class="fa fa-upload" style="margin-left: -6px;"></i></a></li>
                            <li style="display:inline;"><a href="#" class="btn btn-default square" id='download'><i class="fa fa-download" style="margin-left: -6px;"></i></a></li>
                            <li style="display:inline;"><a href="#" class="btn btn-default square" id='serial' style='opacity: 0.35;' disabled><i class="fa fa-search" style="margin-left: -6px;"></i></a></li>
                            <li style="display:inline;" id='acting'></li>
                        </ul>
                    </li> 
                </ul>
            </div>
        </div>
        <div class="content-box-large box-with-header">
            <div id="editor" style="height:400px; overflow: auto;"></div>
            <div id='after' style="display:none">
                <div id="verify_bar">
                    <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
                        <p class="message"></p>
                    </div>
                    <div class="progress col-lg-4 col-md-4 col-xs-4 col-sm-4" style="padding-left: 0; padding-right: 0;">
                        <div class="progress-bar progress-bar-success" id='prog' role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        </div>
                    </div>
                </div>   
                <div id="output"></div>  
            </div>
        </div>
    </div>

    <div class="col-lg-4"  id="serial_monitor"  style="display:none;">
        <div class="content-box-header">
            <div class="panel-title" style="color:white" id='port'>COM X</div>
            <a href="#" id='close' class="pull-right"><i class="fa fa-times" style="color:white"></i></a>
        </div>
        <div class="content-box-large box-with-header" style="height:400px; padding:0;width:100%; overflow: auto; position: relative;">
            <div id='return_serial' style="padding:25px; ">
                <div class="form-inline form-group">
                    <input type='text' class='form-control' id='serial_input'/>
                    <button class="btn btn-normal" id='serial_send'>Send</button>
                </div>
                <ul id='serial_list'>
                </ul>
            </div>

            
        </div>
        <div class="panel-footer" style="position:absolute; margin-top: -30px; width: 91%;">
                <select id='baudrate' class='selectpicker' style="padding-bottom:5px" >
                    <option value='300'>300 baud</option>
                    <option value='1200'>1200 baud</option>
                    <option value='2400'>2400 baud</option>
                    <option value='4800'>4800 baud</option>
                    <option value='9600' selected>9600 baud</option>
                    <option value='14400'>14400 baud</option>
                    <option value='19200'>19200 baud</option>
                    <option value='28800'>28800 baud</option>
                    <option value='34800'>34800 baud</option>
                    <option value='57600'>57600 baud</option>
                    <option value='115200'>115200 baud</option>
                </select>
                <button class="btn btn-sm btn-normal" id='clear'>Clear</button>
            </div>
    </div>

    <div class="col-lg-6 content-box-large" style="display:none;" id="lab">
        <div id='return'></div>
        <button class="btn btn-normal pull-right" style="position:absolute" id='reset'>Reset<i class="fa fa-refresh" style="margin-left:5px;"></i> </button>
        <img src='http://150.162.232.4:8025/' width="100%"/><br><br><br>
        <img src="http://relle.ufsc.br/diagrama.png"  width="100%"/>
    </div>
</div>
<form method="post" id="form" enctype="multipart/form-data" style="display:none">
    <input type="file" name='file' id="file" accept=".ino"/>
    <input type="submit" id='submit'/>
</form>

<script src="//cdn.jsdelivr.net/ace/1.2.0/min/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="exp_script.js" type="text/javascript" charset="utf-8"></script>
<script src="vad_queue.js" type="text/javascript" charset="utf-8"></script>
@stop
<?php

use App\Labs;

$lab = Labs::find($exp);
$troca = $rpijson['dados'];
?>
<header>
    <img style="position: absolute; left: 0; top: 0;" height="100" width="100" src="img/logos/r.png">
    <h2 style="text-align: center;" >RExLab UFSC</h2><Br>
    <h2 style="text-align: center;">Pratice Report</h2>
    <img style="position: absolute; right: 0; top: 0;" height="100" width="100" src="img/logos/r.png">

    @if (Auth::check())
    <div id="info">
        <p class="infnames">Name: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
        <p class="infnames">Experiment: {{ $lab->name_en }}  </p>
        <p class="infnames">Access Date: <?php echo (date('M - d - Y'));
?> </p>
        <p class="infnames2">Organization: {{Auth::user()->organization }}</p>
        <p class="infnames2">E-mail: {{Auth::user()->email}}</p>
    </div>
    @endif

</header>
<div id = "snapshot">
    <p style = "margin-left: 10%; font-weight: bold">Remote Experiment</p>
    <img src = "http://10.10.10.8:8888/motion/snapshot.jpg" width = "320" height = "240">
</div>

<div id = "picture">
    <p style = "margin-left: 28%; font-weight: bold">Chart</p>
    <img src = "<?php echo $troca; ?> " width = "320" height = "240">    <!-- URL Server Apache -->
    <div align="left" id="m1"><canvas class="legend" style="font-size: 10pt; width:15px; height:15px; background:#FDA98F;"></canvas> M1 Aluminum</div>
    <div align="left" id="m2"><canvas class="legend" style="font-size: 10pt; width:15px; height:15px; background:rgba(151,187,205,1);"/></canvas> M2 Copper</div>
    <div align="left" id="m3"><canvas class="legend" style="font-size: 10pt; width:15px; height:15px; background:rgba(130, 125, 143, 0.9);"/></canvas> M3 Steel</div>
</div>

<p style = "color: red; position: fixed; bottom: 16%;">*Check the curve in chart.</p > 
<?php
include asset('footer_' . App::getLocale() . '.html');?>

<style type="text/css">
    .legend {
        position: relative;
        margin-top: 10px;
        border-radius: 4px;
        display: inline-block;
    }

    #m1{
        color:#FDA98F;
    }

    #m2{
        color: rgba(151,187,205,1);
    }

    #m3{
        color: rgba(130, 125, 143, 0.9);       
    }
</style>
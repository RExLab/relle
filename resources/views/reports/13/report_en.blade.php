<?php

use App\Labs;

$lab = Labs::find($exp);
$troca = $rpijson['dados'];
?>

<header>
    <div >
        <img src='img/report/header_en.png' style="width: 100%; ">
    </div>


</header>
<img src="img/report/line.png" style="height:3000px; width:14px; margin-top: 138px; position: fixed; left:0; ">
<div class="info">  
    <h3 class="title">Laboratory Report</h3>
    @if (Auth::check())
    <div class="infnames">
        <p><b>Name:</b> {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} </p>
        <p><b>Lab:</b> {{ $lab->name_en }}  </p>
        <p><b>Date:</b> <?php echo (date('d/m/Y')); ?> </p>
    </div>
    <div class="infnames2">
        <p><b>Institution:</b> {{ Auth::user()->organization }}</p>
        <p><b>Email:</b> {{ Auth::user()->email }} </p> 
    </div>
    @endif
</div>


<div class="data">
    <div id = "snapshot">
        <p style = "margin-left: 10%; font-weight: bold">Remote Experiment</p>
        <img src = "http://10.10.10.8/snapshot" width = "320" height = "240">
    </div>

    <div id = "picture">
        <p style = "margin-left: 28%; font-weight: bold">Chart</p>
        <img src = "<?php echo $troca; ?> " width = "320" height = "240">    <!-- URL Server Apache -->
        <div align="left" id="m1"><canvas class="legend" style="font-size: 10pt; width:15px; height:15px; background:#FDA98F;"></canvas> M1 Aluminum</div>
        <div align="left" id="m2"><canvas class="legend" style="font-size: 10pt; width:15px; height:15px; background:rgba(151,187,205,1);"/></canvas> M2 Copper</div>
        <div align="left" id="m3"><canvas class="legend" style="font-size: 10pt; width:15px; height:15px; background:rgba(130, 125, 143, 0.9);"/></canvas> M3 Steel</div>
    </div>
</div>
<footer>
    <img src='img/report/footer.png'  style="width: 100%; ">
</footer>
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
<?php

use App\Labs;

$lab = Labs::find($exp);
?>
<header>
    <img style="position: absolute; left: 0; top: 0;" height="100" width="100" src="img/logos/r.png">
    <h2 style="text-align: center;" >RExLab UFSC</h2><Br>
    <h2 style="text-align: center;">Pratice Report</h2>
    <img style="position: absolute; right: 0; top: 0;" height="100" width="100" src="img/logos/r.png">

    @if (Auth::check())
    <div id="info">
        <p class="infnames">Name: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
        <p class="infnames">Experiment: {{ $lab->name_en }} </p>
        <p class="infnames">Access Date: <?php echo (date('M - d - Y')); ?> </p>
        <p class="infnames2">Organization: {{Auth::user()->organization }}</p>
        <p class="infnames2">E-mail: {{Auth::user()->email}}</p>
    </div>
    @endif

</header>
<div id = "snapshot">
    <p style = "margin-left: 10%; font-weight: bold">Remote Experiment</p> <!-- Snapshot for remote lab (External IP) -->
    <img src = "http://rexlab.ufsc.br:8073/motion/snapshot.jpg" width = "320" height = "240">
</div>

<div id = "picture">
    <p style = "margin-left: 28%; font-weight: bold">Illustrative Image</p>
    <img src = "http://relle.ufsc.br/exp_data/1/img/diagrama.png" width = "320" height = "240"> <!-- Illustrative image (Extrenal IP or diagram) -->
</div>

<!-- Begin results -->
<table style="position:relative; width: 100%; top:70%;"> 
    <tr>
        <td>A1:</td>
        <td>A2:</td>
        <td>A3:</td>
        <td>A4:</td>
        <td>A5:</td>
        <td>A6:</td>
        <td>A7:</td>
        <td>V1:</td>
        <td>V2:</td>
    </tr>
    <!-- Results basead in the JSON response.
        ** Example: $rpijson['vector'][position] -->
    <tr>
        <td><?php echo ($rpijson['amperemeter'][0]) / 1000 ?> mA</td>
        <td><?php echo ($rpijson['amperemeter'][1]) / 1000 ?> mA</td>
        <td><?php echo ($rpijson['amperemeter'][2]) / 1000 ?> mA</td>
        <td><?php echo ($rpijson['amperemeter'][3]) / 1000 ?> mA</td>
        <td><?php echo ($rpijson['amperemeter'][4]) / 1000 ?> mA</td>
        <td><?php echo ($rpijson['amperemeter'][5]) / 1000 ?> mA</td>
        <td><?php echo ($rpijson['amperemeter'][6]) / 1000 ?> mA</td>
        <td><?php echo ($rpijson['voltmeter'][0]) / 1000 ?> V</td>
        <td><?php echo ($rpijson['voltmeter'][1]) / 1000 ?> V</td>
    </tr>
</table>
<!-- End results -->

<p style = "color: red; position: fixed; bottom: 14%;">*Check active switches and sensors.</p> <!-- Alert -->  
<?php include asset('footer_' . App::getLocale() . '.html');
?>
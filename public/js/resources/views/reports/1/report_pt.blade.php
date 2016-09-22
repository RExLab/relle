<?php

use App\Labs;

$lab = Labs::find($exp);
?>


<header>
    <div >
        <img src='img/report/header.png' style="width: 100%; ">
    </div>


</header>
<img src="img/report/line.png" style="height:3000px; width:14px; margin-top: 138px; position: fixed; left:0; ">
<div class="info">  
    <h3 class="title">Relatório de Prática Experimental</h3>
    @if (Auth::check())
    <div class="infnames">
        <p>Nome: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} </p>
        <p>Experimento: {{ $lab->name_pt }}  </p>
        <p>Data: <?php echo (date('d/m/Y')); ?> </p>
    </div>
    <div class="infnames2">
        <p>Instituição: {{ Auth::user()->organization }}</p>
        <p>Email: {{ Auth::user()->email }} </p> 
    </div>
    @endif
</div>


<div class="data">
    <div id = "snapshot">
        <img src = "http://10.10.10.58:8888/motion/snapshot.jpg" width = "320" height = "240"><br>
        <i class="legenda">Câmera</i>
    </div>

    <div id = "picture">
        <img src = "{{asset($rpijson['equivalent'])}}" width = "320" height = "240"><br>
        <i class="legenda">Circuito Equivalente</i>
    </div>
    
    <table border="0.5" style="position:relative; width: 90%; top:20%; margin-left: 30px"> 
        <tr>
            <td>A1</td>
            <td>A2</td>
            <td>A3</td>
            <td>A4</td>
            <td>A5</td>
            <td>A6</td>
            <td>A7</td>
            <td>V1</td>
            <td>V2</td>
        </tr>
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
</div>
<footer>
    <img src='img/report/footer.png'  style="width: 100%; ">
</footer>
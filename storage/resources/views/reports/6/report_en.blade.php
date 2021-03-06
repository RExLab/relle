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
      <p class="infnames">User: {{ Auth::user()->username }}
 </p>
      <p class="infnames">Experiment: {{ $lab->name_en }} </p>
      <p class="infnames">Access Date: <?php echo (date('M - d - Y / H:i')." Hs GMT-3") ;
?> </p>
      <p class="infnames2">Organization: {{Auth::user()->organization }}</p>
      <p class="infnames2">E-mail: {{Auth::user()->email}}</p>
  </div>
  @endif
 
</header>
<div id = "snapshot">
    <p style = "margin-left: 10%; font-weight: bold">Remote Experiment</p>
    <img src = "#" width = "320" height = "240">
</div>

<div id = "picture">
    <p style = "margin-left: 28%; font-weight: bold">Ilustrative Image</p>
    <img src = "img/teste.jpg" width = "320" height = "240">
</div>

<table style="position:relative;left:30%; top:70%;"> 
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
    <tr>
        <td><?php echo $rpijson['amperemeter'][0] ?> A</td>
        <td><?php echo $rpijson['amperemeter'][1] ?> A</td>
        <td><?php echo $rpijson['amperemeter'][2] ?> A</td>
        <td><?php echo $rpijson['amperemeter'][3] ?> A</td>
    </tr>
</table>
<p style = "color: red; position: fixed; bottom: 14%;">*Check active switches and sensors.</p > 
<?php include asset('footer_' . App::getLocale() . '.html');
?>
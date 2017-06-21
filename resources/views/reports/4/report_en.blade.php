<header>
  <img style="position: absolute; left: 0; top: 0;" height="100" width="100" src="img/logos/r.png">
  <h2 style="text-align: center;" >RExLab UFSC</h2><Br>
  <h2 style="text-align: center;">Pratice Report</h2>
  <img style="position: absolute; right: 0; top: 0;" height="100" width="100" src="img/logos/r.png">
    
  @if (Auth::check())
  <div id="info">
      <p class="infnames">User: {{ Auth::user()->username }}
 </p>
      <p class="infnames">Experiment: {{ $lab->name_en }}  </p>
      <p class="infnames">Access Date: <?php echo (date('M - d - Y / H:i')." Hs GMT-3") ;
?> </p>
      <p class="infnames2">Organization: {{Auth::user()->organization }}</p>
      <p class="infnames2">E-mail: {{Auth::user()->email}}</p>
  </div>
  @endif
 
</header>
<div id = "snapshot">
    <p style = "margin-left: 10%; font-weight: bold">Remote Experiment</p>
    <img src = "#\" width = "320" height = "240">
</div>

<div id = "picture">
    <p style = "margin-left: 28%; font-weight: bold">Ilustrative Image</p>
    <img src = " " width = "320" height = "240">    <!-- URL Server Apache -->
</div>

<?php include asset('footer_' . App::getLocale() . '.html');

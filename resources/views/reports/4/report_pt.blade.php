<header>
    <img style="position: absolute; left: 0; top: 0;" height="100" width="100" src="img/logos/r.png">
    <h2 style="text-align: center;" >RExLab UFSC</h2><Br>
    <h2 style="text-align: center;">Relatório de Prática Experimental</h2>
    <img style="position: absolute; right: 0; top: 0;" height="100" width="100" src="img/logos/r.png">

    @if (Auth::check())
    <div id="info">
        <p class="infnames">Usuário: {{ Auth::user()->username }}</p>
        <p class="infnames">Experimento: {{ $lab->name_pt }}  </p>
        <p class="infnames">Data do Acesso: <?php echo (date('d/m/Y')); ?> </p>
        <p class="infnames2">Instituição: {{ Auth::user()->organization }}</p>
        <p class="infnames2">E-mail: {{ Auth::user()->email }} </p> 
    </div>
    @endif
</header>
<div id = "snapshot">
    <p style = "margin-left: 10%; font-weight: bold">Experimento Remoto</p>
    <img src = "" width = "320" height = "240">    <!-- URL Server Apache -->

</div>

<div id = "picture">
    <p style = "margin-left: 28%; font-weight: bold">Imagem Ilustrativa</p>
    <img src = " " width = "320" height = "240">    <!-- URL Server Apache -->
  
</div>
<?php include asset('footer_' . App::getLocale() . '.html');
<!-- Página em português do Relatório de Prática Exeperimental.
    Neste arquivo deve conter somente as informações básico que o usuário visualizará ao final de sua prática em informações como:
    - Imagem do Experimento Remoto;
    - Imagem Ilustrativa ao Experimento Remoto;
    - E um espaço abaixo destinado a valores de sensores e atuadores (caso existam) ou alguma informação complementar sobre a prática.

    *Retornos do Experimento Remoto:
    - Qualquer tipo de retorno de dados de sensores pelo experimento remoto deve ser enviado por método POST em Ajax através do arquivo exp_script.js 
    que deve se encontar junto com o pacote de envio de informações.
    - Exemplo de retorno:
    $rpijson["nome_do_array_json"][índice]  OBS: A variável $rpijson deve permanecer inalterada como demonstra o exemplo abaixo.

    *Dúvidas:
    - Quaisquer dúvidas a respeito do preenchimento deste arquivo deve ser encaminhada pelo e-mail: rexlab@gmail.com.
-->
<?php
use App\Labs;
$lab = Labs::find($exp);
?>
<header>
    <img style="position: absolute; left: 0; top: 0;" height="100" width="100" src="img/logos/r.png">
    <h2 style="text-align: center;" >RExLab UFSC</h2><Br>
    <h2 style="text-align: center;">Relatório de Prática Experimental</h2>
    <img style="position: absolute; right: 0; top: 0;" height="100" width="100" src="img/logos/r.png">

    @if (Auth::check())
    <div id="info">
        <p class="infnames">Usuário: {{ Auth::user()->username }}</p>
        <p class="infnames">Experimento: {{ $lab->name_pt }}  </p>
        <p class="infnames">Data do Acesso: <?php echo (date('d/m/Y - H:i') . " Hs"); ?> </p>
        <p class="infnames2">Instituição: {{ Auth::user()->organization }}</p>
        <p class="infnames2">E-mail: {{ Auth::user()->email }} </p> 
    </div>
@endif
</header>
<div id = "snapshot">
    <p style = "margin-left: 10%; font-weight: bold">Experimento Remoto</p>     <!-- Snapshot do Experimento Remoto (considerar URL externa) -->
    <img src = "#" width = "320" height = "240">
</div>

<div id = "picture">
    <p style = "margin-left: 28%; font-weight: bold">Imagem Ilustrativa</p>     <!-- Imagem ilustrativa ao experimento -->
    <img src = "img/teste.jpg" width = "320" height = "240">
</div>

<table style="position:relative;left:30%; top:70%;"> <!--Exemplo de valor retornado pelos sensores -->
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
        <td><?php echo $rpijson['amperemeter'][4] ?> A</td>
        <td><?php echo $rpijson['amperemeter'][5] ?> A</td>
        <td><?php echo $rpijson['amperemeter'][6] ?> A</td>
        <td><?php echo $rpijson['amperemeter'][7] ?> A</td>
        <td><?php echo $rpijson['amperemeter'][8] ?> A</td>
    </tr>
</table>
<p style = "color: red; position: fixed; bottom: 14%;">*Verifique as chaves ativas e os sensores.</p > <!--Exemplo de nota informática ao usuário -->
<?php include asset('footer_' . App::getLocale() . '.html');
?>
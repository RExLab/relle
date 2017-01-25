
<div style='border-top: 5px solid #00AA8A;
     border-bottom: 15px solid #ecf0f1;
     box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
     height: 45px;
     background: #ecf0f1;
     '>
    <a class href="{{ url('/') }}">
        <img src="http://relle.ufsc.br/img/logos/logo.png" height="30px" style='margin-top:10px; margin-left:10px;' />
    </a>
</div>
<center><h2>Formulário de Contato</h2></center>
<div style="margin-right: 10px; margin-left:10px; color: black">
    <?php
    echo "<b>Nome:</b> " . session('data')['name'] . '<br>';
    echo "<b>Email:</b> " . session('data')['email'] . '<br>';
    echo "<b>Assunto:</b> ". session('data')['subject'] . '<br>';
    echo "<b>Mensagem:</b> ". session('data')['message'] . '<br>';
    ?>
</div>

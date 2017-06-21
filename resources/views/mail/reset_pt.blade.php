
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
<div style="margin-right: 10px; margin-left:10px; color: black">
    <?php
    echo '<center><h2> Olá, ' . session('data')['firstname'] . '! </h2></center><br>';
    echo '<p>Estas são as informações para recuperar as suas informações de login: </p>';
    echo "<p><b>Usuário:</b> " . session('data')['username'] . '<br>';
    echo "<b>Link para recuperar senha:</b>  <a href='http://relle.ufsc.br/password/reset/" . session('data')['token'] . "'>Clique Aqui</a></p>";
    ?>
    <p>Atenciosamente,</p>
    <i>Equipe RELLE</i></p>
</div>

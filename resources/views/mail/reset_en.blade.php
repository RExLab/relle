
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
    echo '<center><h2> Hello, ' . session('data')['firstname'] . '! </h2></center><br>';
    echo '<p>This is your login: </p>';
    echo "<p><b>User:</b> " . session('data')['username'] . '<br>';
    echo "<b>Password reset link:</b>  <a href='http://relle.ufsc.br/password/reset/" . session('data')['token'] . "'>Click here</a></p>";
    ?>
    <p>Best Regards,</p>
    <i>RELLE Team</i></p>
</div>

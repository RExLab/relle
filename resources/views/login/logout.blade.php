<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script>
    var key = '';
    $(document).ready(function () {
        $.ajax({
            url: "http://relle.ufsc.br/moodle/login/getKey.php",
            type: "POST",
            data: true,
            //moodle returns error 404 if user is not found
            success: function (data) {
                key = data;
            }
        });

        event.preventDefault();
    });
    $(document).ajaxStop(function () {
        window.location.href = "http://relle.ufsc.br/";
      
    });
</script>


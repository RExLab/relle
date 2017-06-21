/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var str_url = "https://" + window.location.hostname + "/api/";
var refresh, timer;


function LeaveExperiment() {
    clearInterval(refresh);
    clearInterval(timer);
    var dataout = {'pass': $('meta[name=csrf-token]').attr('content'), 'exp_id': exp_id};

    $.ajax({
        url: str_url+"delete",
        data: dataout,
        type: "POST",
        success: function (data) {
            $('#exp').html("<p>Experiência finalizada com "+data+ "</p> <p>Redirecionando para a página inicial ...</p>");// Isto limpa a pagina
            $("#btnLeave").off('click');
             setTimeout(function(){
                 //window.location.href = "http://" + window.location.hostname;
                 
                 var jsonlogout = {
                        time: Math.round(+new Date()/1000),
                        lab_id: exp_id
                };
                
                 location.reload();
             },5000);     
        }
    });

}

function setDataRunning(data) {  
    //data = JSON.parse(data);
    // Alterar a apresentação do número de usuário na fila
}

function RefreshTimeAlive() {

    var dataout = {'pass': $('meta[name=csrf-token]').attr('content'), 'exp_id': exp_id};

    $.ajax({
        url: str_url+"refresh",
        data: dataout,
        type: "POST",
        success: function (data) {
            setDataRunning(data);
        }
    });
}



function TimerMinus() {
    var soma = parseInt($("#min").html()) * 60 + parseInt($("#seg").html());
    soma = (soma - 1) / 60;

    if (soma > 0) {
        $("#min").html(parseInt(soma));
        var seg = Math.round((soma - parseInt(soma)) * 60);
        var zero = "";
        if (seg < 10) {
            zero = "0";
        }
        $("#seg").html(zero + seg);
    } else {
        clearInterval(timer);
    }
}

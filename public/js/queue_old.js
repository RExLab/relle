var refresh, timer;
var str_url = "http://" + window.location.hostname+"/api/";  

function setDataRunning(data) {
    if(data.error == 'defined'){
        console.log("Error");
        return;
    }
    $("#min").html(data.clock.min);
    var seg_old = parseInt($("#seg").html());
    if(Math.abs(seg_old-data.clock.seg)>10){
        $("#seg").html(data.clock.seg);
        console.log(Math.abs(seg_old-data.clock.seg));               
    }

}


function RefreshTimeAlive() {
    var dataout = {'pass': $('meta[name=csrf-token]').attr('content'), 'exp_id': exp_id,  'exec_time': duration};

    $.ajax({
        
        url: str_url+"refresh", 
        data: dataout,
        type: "POST",
        success: function (data) {
             setDataRunning($.parseJSON(data));
        }
    });
}

function setData(data) {
    data = $.parseJSON(data);
    if (data.status > 0) {
        clearInterval(timer);
        clearInterval(refresh);
        loadLab(data);
    } else {
        var intval = parseInt(data.interval);
        intval = (intval >= 1 ) ? intval : 0.5;
        //$("#exp").html("<p> Proxima requisicao em " + intval + " segundos </p>");
        refresh = setInterval(Refresh, intval * 1000);
        if(data.n_wait){
            $("#nwait").html(data.n_wait);
            $("#min").html(data.clock.min);
            var seg_old = parseInt($("#seg").html());
            if(Math.abs(seg_old-data.clock.seg)>5){
                $("#seg").html(data.clock.seg);
                console.log(Math.abs(seg_old-data.clock.seg));               
            }
        }
    }
}


function Refresh() {
    var dataout = { 'pass': $('meta[name=csrf-token]').attr('content'), 'exp_id': exp_id, 'exec_time': duration};
    clearInterval(refresh);
    $.ajax({
        url: str_url+"wait",
        data: dataout,
        type: "POST",
        timeout: 10000, 
        success: function (data) {
            setData(data);
        }
    });
}
function reloadPage(){
         location.reload(true); 
}

function LeaveExperiment() {
    clearInterval(refresh);
    clearInterval(timer);
    $('#exp').html(close_message);// Isto limpa a pagina
    
        var dataout = {'pass': $('meta[name=csrf-token]').attr('content'), exp_id: exp_id};
        $.ajax({
            url: str_url+"delete",
            data: dataout,
            type: "POST",
            timeout: 5000,
            success: function (data) {
                $("#btnLeave").off('click'); 
                reloadPage();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
               reloadPage();
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



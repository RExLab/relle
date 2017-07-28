/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var str_url = "https://" + window.location.hostname + "/api/";

function LeaveExperiment(exp_id) {

    var dataout = { 'pass': $('meta[name=csrf-token]').attr('content'), 'exp_id': exp_id};

    $.ajax({
        url: str_url+"delete",
        data: dataout,
        type: "POST",
        timeout: 2000,
        success: function (data) {
            $( "#exp" ).html("<p>Experiência finalizada com "+data+ "</p>");
             setTimeout(function(){
                 //window.location.href = "https://" + window.location.hostname;
                 location.reload();
             },1000);
             
        }
    });
}



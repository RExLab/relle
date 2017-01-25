
function addShowmeButton(el) {
    $('#return div').prepend(el);
}

function errorLab(uilang) {
    $('#error').html("");
    $('#error').html($('<div/>', {class: 'alert alert-warning alert-dismissible'})
            .append($('<button/>', {id: 'btnLeave', class: 'btn btn-warning btn-sm', html: uilang.leave}))
            .append($('<button/>', {type: 'button', class: 'close', 'aria-label': 'Close', 'data-dismiss': 'alert'})
                    .append($('<span/>', {html: '&times;', 'aria-hidden': 'true'})))
            .append($('<span/>', {html: uilang.message_error})));
}

function showReconnectingAlert(uilang) {
    
    if ($('#reconnectingModal').length === 0) {

        $('body').append($('<div/>', {class: 'modal fade in', id: 'reconnectingModal', style: 'display:none;padding:10px'})
                .append($('<div/>', {class: 'modal-dialog', role: 'document'})
                        .append($('<div/>', {class: 'modal-content'})
                                .append($('<div/>', {class: 'modal-header'})
                                        .append($('<button/>', {class: 'close', 'data-dismiss': 'modal', 'aria-label': 'Close'})
                                                .append($('<span/>', {'aria-hidden': true, html: '&times;'})))
                                        .append($('<h6/>', {class: 'modal-title', html: uilang.reconnectingheader})))
                                .append($('<div/>', {class: 'modal-body'})
                                        .append($('<center/>').append($('<p/>', {class: 'modal-title', html: uilang.reconnectingbody}))))
                                )));

        $('#reconnectingModal button.close').click(function () {
            $('#reconnectingModal').hide();
        });
    }

    $('#reconnectingModal').show();

}

function hideReconnectingAlert(){
    $('#reconnectingModal').hide();
}

function UILoadLab(data, uilang) {
    $("#btnLeave").off();
    $('#pre_experiment').hide();
    $("#return").show();
    $('#error').html("");
    $('head').append('<link rel="stylesheet" href=' + data.css + ' type="text/css" />');
    $('#return').addClass('row well well-sm');
    $('#return').css('margin-top', '-20px');
    $('#return').append($('<div/>', {class: 'col-lg-12'})
            .append($('<span/>', {class: 'timeleft', html: uilang.timeleft + ": "})
                    .append($('<span/>', {id: 'min', html: data.clock.min}))
                    .append($('<span/>', {html: ':'}))
                    .append($('<span/>', {id: 'seg', html: data.clock.seg})))
            .append($('<button/>', {class: 'btn btn-sm btn-default', id: 'btnLeaveExp', name: 'leave', html: uilang.leave, style: 'float:right;'}))
            );
    return  $('#exp');
}

function UILeave(uilang, exp_id) {
    var popup = end = "";
    var rep = repcsv = "";
    popup = $('<div/>', {class: 'alert alert-info', role: 'alert'})
            .append($('<strong/>', {html: uilang.attention}))
            .append($('<span/>', {html: ', ' + uilang.popup}));
    end = $('<p/>', {html: uilang.end});
    if ($('#report').length !== 0) {
        rep = $('<button/>', {class: 'btn', onClick: 'report(' + exp_id + ')', html: uilang.report});
        end = $('<p/>', {html: uilang.end_rep});
    } else if ($('#csv').length !== 0) {
        repcsv = $('<button/>', {class: 'btn', onClick: 'exportcsv()', html: uilang.csvreport});
    } else {
        popup = "";
    }

    var btnredirect = $('<input/>', {class: 'btn', id: 'btnRedirect', type: 'button', value: uilang.leave});
    $('#leave').replaceWith([popup, $('<div/>', {class: 'well'})
                .append($('<center/>')
                        .append([end, btnredirect, rep, repcsv]))]);
    $('#DivExp').remove();
    $('#return').hide();
    return $('#btnRedirect');
}


function UIWaitLab(data, uilang) {
    $('#error').html("");
    $('#return').html("");
    if (data.clock.min < 0 || data.clock.seg < 0) {
        data.clock.min = data.clock.seg = 0;
    } else {

        var e_instances = [];
        if(data.ninstances == 0){
            e_instances = $('<span/>', {html: uilang.labsunavailable});
        }else{
            e_instances.push($('<strong/>', {html: uilang.resources + ": "}));
        }
        for (var index = 0; index < data.ninstances; index++) {
            e_instances.push($('<i/>', {'class': 'fa fa-flask', 'aria-hidden': 'true', style: 'padding-top:10px'}));
        }

        $('#error').append(
                $('<div/>', {class: 'row alert alert-warning alert-dismissible'})
                .append($('<div/>', {class: 'col-lg-3 col-md-3 col-sm-6 col-xs-12'})
                        .append($('<strong/>', {html: uilang.wait}))
                        .append($('<span/>', {html: data.wait, id: 'nwait'}))
                        )
                .append($('<div/>', {class: 'col-lg-3 col-md-3 col-sm-6 col-xs-12'})
                        .append($('<strong/>', {html: uilang.timeleft + ': '}))
                        .append($('<span/>', {html: data.clock.min, id: 'min'}))
                        .append($('<span/>', {html: ':'}))
                        .append($('<span/>', {html: data.clock.seg, id: 'seg'}))
                        )
                .append($('<div/>', {class: 'col-lg-6  col-md-6 col-sm-12 col-xs-12'})
                        .append(e_instances)
                        .append($('<button/>', {class: 'btn btn-warning btn-sm', id: 'btnLeave', text: uilang.leave, style: 'float:right'}))
                        )

                );
    }

    $("#access").hide();
    return $("#btnLeave");
}
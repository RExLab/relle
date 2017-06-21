/*
 * Script for Chart in Dashboard 
 */
function setColor(area, data, config, i, j, animPct, value)
{
    if (value > 35)
        return("rgba(220,0,0," + animPct);
    else
        return("rgba(0,220,0," + animPct);
}


var charJSPersonnalDefaultOptions = {decimalSeparator: ",", thousandSeparator: ".", roundNumber: "none", graphTitleFontSize: 2};
 
function labAccess() {
    var results = [];

    $.ajax({
        type: "POST",
        url: "http://relle.ufsc.br/analytics/labs_access",
        success: function (data) {
            results = $.parseJSON(data);
            var labs = new Chart(document.getElementById("labs").getContext("2d")).Doughnut(results, opt1);
        }
    });
}

function browserAccess() {
    var results = [];

    $.ajax({
        type: "POST",
        url: "http://relle.ufsc.br/analytics/browser_access",
        success: function (data) {
            results = $.parseJSON(data);
            var browser = new Chart(document.getElementById("browser").getContext("2d")).Pie(results, opt4);
        }
    });
}

function mobileAccess() {
    var results = [];

    $.ajax({
        type: "POST",
        url: "http://relle.ufsc.br/analytics/mobile_access",
        success: function (data) {
            results = $.parseJSON(data);
            var mobile = new Chart(document.getElementById("mobile").getContext("2d")).Doughnut(results, opt3);
        }
    });
}

var startWithDataset = 1;
var startWithData = 1;
var opt1 = {
    animationStartWithDataset: startWithDataset,
    animationStartWithData: startWithData,
    animateRotate: true,
    animateScale: false,
    animationByData: false,
    animationSteps: 50,
    canvasBorders: false,
    canvasBordersWidth: 1,
    canvasBordersColor: "gray",
    //graphTitle: "",
    legend: true,
    inGraphDataShow: false,
    animationEasing: "linear",
    annotateDisplay: true,
    spaceBetweenBar: 5,
    graphTitleFontSize: 18

};

var opt3 = {
    animationStartWithDataset: startWithDataset,
    animationStartWithData: startWithData,
    animateRotate: true,
    animateScale: false,
    animationByData: false,
    animationSteps: 50,
    canvasBorders: false,
    //canvasBordersWidth : 1,
    //canvasBordersColor : "gray",
    //graphTitle: "",
    legend: true,
    inGraphDataShow: false,
    animationEasing: "linear",
    annotateDisplay: true,
    spaceBetweenBar: 5,
    graphTitleFontSize: 18

}



var opt4 = {
    animationStartWithDataset: startWithDataset,
    animationStartWithData: startWithData,
    animateRotate: true,
    animateScale: false,
    animationByData: false,
    animationSteps: 50,
    canvasBorders: false,
    canvasBordersWidth: 3,
    canvasBordersColor: "black",
    //graphTitle: "",
    legend: true,
    inGraphDataShow: false,
    animationEasing: "linear",
    annotateDisplay: true,
    spaceBetweenBar: 5,
    graphTitleFontSize: 18


}

window.onload = function () {
    console.log(labAccess());
    console.log(browserAccess());
    console.log(mobileAccess());
}

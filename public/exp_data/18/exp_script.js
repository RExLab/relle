$.getScript('http://relle.ufsc.br/exp_data/18/visir.js', function () {
	visir.Load(init);
});

$.getScript('http://relle.ufsc.br/exp_data/18/zoom.js');
//$.getScript('https://raw.githubusercontent.com/twbs/bootstrap/master/js/transition.js');

$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/exp_data/18/zoom.css" type="text/css"/>');
$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/exp_data/18/instruments/breadboard/breadboard.css" type="text/css"/>');
$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/exp_data/18/instruments/flukemultimeter/flukemultimeter.css" type="text/css"/>');
$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/exp_data/18/instruments/tripledc/tripledc.css" type="text/css"/>');
$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/exp_data/18/instruments/hp_funcgen/hp_funcgen.css" type="text/css"/>');
$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/exp_data/18/instruments/ag_oscilloscope/ag_oscilloscope.css" type="text/css"/>');
$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/exp_data/18/instruments/ni_oscilloscope/ni_oscilloscope.css" type="text/css"/>');
$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/exp_data/18/instrumentframe/instrumentframe.css" type="text/css"/>');

/* --- Leave experiment for no queue ---*/
$( "#btnLeaveExp" ).click(function() {
  location.reload(true);
});

function init() {
	function MakeMeasurement() {
		reg.MakeRequest(transport);
	}

	trace("starting up..");

	var transport = new visir.JSTransport(visir.SetWorking);
	transport.onerror = function (err) { alert("Error: " + err); }

	transport.Connect(visir.Config.Get("mesServer"), "fnord");

	var extservice = new visir.ExtServices({ MakeMeasurement: MakeMeasurement });
	var reg = new visir.InstrumentRegistry(extservice);
	var frame = new visir.InstrumentFrame(reg, transport, $("#instrumentframe"));

	emptyexperiment = '<save version="2"><instruments htmlinstruments="Breadboard|FlukeMultimeter|HPFunctionGenerator|AgilentOscilloscope|TripleDC"></instruments><circuit></circuit></save>';
	
	saved = '<save version="2"><instruments htmlinstruments="Breadboard|FlukeMultimeter|HPFunctionGenerator|AgilentOscilloscope|TripleDC"></instruments><circuit><circuitlist><component>R 220 78 13 0</component><component>R 220 78 26 0</component><component>R 220 78 39 0</component><component>R 10k 143 13 0</component><component>R 10k 143 26 0</component><component>R 10k 143 39 0</component><component>R 150 78 65 0</component><component>OP UA741 234 13 0</component><component>Q bc547c 195 13 0</component></circuitlist></circuit></save>';
	
	reg.LoadExperiment(saved, frame.GetInstrumentContainer());

	$(".measure").click(function () {
		MakeMeasurement();
	});

	$("#showlog").click(function () {
		$("#logwindow").css("display", "block");
	});
	$("#hidelog").click(function () {
		$("#logwindow").css("display", "none");
	});

	$("#load_experiment_1").click(function () {
		reg.LoadExperiment(savedexperiment_1, frame.GetInstrumentContainer());
	});

	$("#load_experiment_2").click(function () {
		reg.LoadExperiment(savedexperiment_2, frame.GetInstrumentContainer());
	});

	/* ---- Saved experiments edited by Lucas Mellos (RExLab - UFSC ) ----*/
	$('#load_cgeral').click(function () {
		reg.LoadExperiment(saved, frame.GetInstrumentContainer());
	});

	var armista = '<save version="2"><instruments htmlinstruments="Breadboard|FlukeMultimeter|HPFunctionGenerator|AgilentOscilloscope|TripleDC"></instruments><circuit><circuitlist><component>W 16711680 637 299 561.6 223.6 455 247</component><component>W 0 325 247 250.88540649414062 330.1805469607127 637 312</component><component>W 16776960 377 247 390 241.8 403 247</component><component>W 16711680 156 260 184.88540649414062 164.18054696071272 247 143</component><component>W 0 156 273 178.1 196.3 247 156</component><component>W 16711680 325 143 338 175.5 325 208</component><component>W 0 455 156 465.4 182 455 208</component><component>R 220 351 221 0</component><component>R 220 351 234 0</component><component>R 220 429 221 0</component><component>R 10k 429 234 0</component><component>R 10k 429 260 0</component><component>R 10k 351 260 0</component><component>R 150 78 65 0</component><component>OP UA741 234 13 0</component><component>Q bc547c 195 13 0</component></circuitlist></circuit></save>';
	$('#load_armista').click(function () {
		reg.LoadExperiment(armista, frame.GetInstrumentContainer());
	});

	var arparalelo = '<save version="2"><instruments htmlinstruments="Breadboard|FlukeMultimeter|HPFunctionGenerator|AgilentOscilloscope|TripleDC"></instruments><circuit><circuitlist><component>W 16711680 637 299 561 223 377 260</component><component>W 0 325 247 250 330 637 312</component><component>W 16711680 156 260 184 164 247 143</component><component>W 0 156 273 178 196 247 156</component><component>W 16711680 325 143 338 175 325 208</component><component>W 0 377 156 379.8854064941406 180.180547431663 377 208</component><component>R 220 351 221 0</component><component>R 220 351 234 0</component><component>R 220 130 13 0</component><component>R 10k 78 39 0</component><component>R 10k 78 13 0</component><component>R 10k 351 247 0</component><component>R 150 78 65 0</component><component>OP UA741 234 13 0</component><component>Q bc547c 195 13 0</component></circuitlist></circuit></save>';
	$('#load_arparalelo').click(function () {
		reg.LoadExperiment(arparalelo, frame.GetInstrumentContainer());
	});

	var arserie = '<save version="2"><instruments htmlinstruments="Breadboard|FlukeMultimeter|HPFunctionGenerator|AgilentOscilloscope|TripleDC"></instruments><circuit><circuitlist><component>W 16711680 637 299 561 223 351 260</component><component>W 0 403 260 450.8854064941406 340.1805468370883 637 312</component><component>W 16711680 156 260 184 164 247 143</component><component>W 0 156 273 178 196 247 156</component><component>W 16711680 299 143 309.8854064941406 174.18054807333272 299 208</component><component>W 0 403 156 409.8854064941406 180.180546366138 403 208</component><component>R 220 325 221 0</component><component>R 220 377 234 0</component><component>R 220 130 13 0</component><component>R 10k 78 39 0</component><component>R 10k 78 13 0</component><component>R 10k 130 26 0</component><component>R 150 78 65 0</component><component>OP UA741 234 13 0</component><component>Q bc547c 195 13 0</component></circuitlist></circuit></save>';
	$('#load_arserie').click(function () {
		reg.LoadExperiment(arserie, frame.GetInstrumentContainer());
	});

	var tnpn = '<save version="2"><instruments htmlinstruments="Breadboard|FlukeMultimeter|HPFunctionGenerator|AgilentOscilloscope|TripleDC"></instruments><circuit><circuitlist><component>W 0 390 351 400.4 377 390 403</component><component>W 0 637 403 611 392.6 585 403</component><component>W 32768 312 351 347.8854064941406 370.18054627194795 377 351</component><component>W 16711680 156 351 201.5 370.5 221 416</component><component>W 16711680 247 416 240.5 380.9 260 351</component><component>W 16776960 351 260 334.8854064941406 309.18054627194795 364 325</component><component>W 16711680 156 208 226.2 189.8 299 234</component><component>W 0 44 -3 44 -3 44 -3</component><component>W 16711680 637 299 507 209.3 351 234</component><component>W 0 637 312 508.3 275.6 390 338</component><component>R 220 78 13 0</component><component>R 220 143 65 0</component><component>R 220 143 52 0</component><component>R 10k 143 13 0</component><component>R 10k 143 26 0</component><component>R 10k 286 338 0</component><component>R 150 325 221 0</component><component>OP UA741 234 13 0</component><component>Q bc547c 377 286 0</component></circuitlist></circuit></save>';
	$('#load_tnpn').click(function () {
		reg.LoadExperiment(tnpn, frame.GetInstrumentContainer());
	});

	var fgen = '<save version="2"><instruments htmlinstruments="Breadboard|FlukeMultimeter|HPFunctionGenerator|AgilentOscilloscope|TripleDC"></instruments><circuit><circuitlist><component>W 16711680 637 234 373.1 196.3 156 351</component></circuitlist></circuit></save>';
	$('#load_fgen').click(function () {
		reg.LoadExperiment(fgen, frame.GetInstrumentContainer());
	});
}




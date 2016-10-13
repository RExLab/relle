$('head').append('<link rel="stylesheet" href="http://relle.ufsc.br/css/shepherd-theme-arrows.css" type="text/css"/>');
$.getScript('http://relle.ufsc.br/exp_data/4/welcome.js', function () {
    var shepherd = setupShepherd();
    $('#return').prepend('<button id="btnIntro" class="btn btn-sm btn-default"> <span class="long">' + lang.showme + '</span><span class="short">' + lang.showmeshort + '</span> <span class="how-icon fui-question-circle"></span> </button>');
    $('#btnIntro').on('click', function (event) {
        event.preventDefault();
        shepherd.start();
    });
});

$(function () {
    $('.dropdown-toggle').dropdown();
    var interval, verifytimeout, uploadtimeout;
    var addr = 'http://arduino1.relle.ufsc.br';
    var socket = null;
    
    function isConnected(socket){
        if (socket == null) {
                $('.message').html(lang.error_connection);
                $('.progress').hide();
                $('#verify_bar').css('background-color', '#E65100');
                $('#verify_bar').css('color', 'white');
        } 
        return (socket != null)
    }
    function verifyBarError(error, msg) {
        $('.progress').hide();
        $('#verify_bar').css('background-color', '#E65100');
        $('#verify_bar').css('color', 'white');
        $('.message').html(error);
        output(msg);
    }

    function verifyBarSuccess(success, msg) {
        if ($('.progress').css('display') === 'none') {
            $('.progress').show();
        }
        $('#verify_bar').css('background-color', '#00979C');
        $('#verify_bar').css('color', 'black');

        $('.message').html(success);
        output(msg);
    }

    function output(msg) {
        if (typeof (msg) == "string") {
            msg = msg.replace(/\n/g, '<br>');
        }
        $('#output').append(msg);
    }

    $.getScript('http://cdn.jsdelivr.net/ace/1.2.0/min/ace.js', function () {

        var code_temp;
        var code_name;

        var start = '/*\n* Pino LDR: A0\n* Pino LM35: A1\n* Pino LED: 2\n* Pino Servo: 5 \n*\n*/\nvoid setup() {\n\n' + lang.setup + '\n\n}\n\nvoid loop(){\n\n' + lang.loop + '\n\n}';
        var editor = ace.edit("editor");

        $('.selectpicker').selectpicker();

        $("#ide .controllers").show();
        $(".loading_ide").hide();

        editor.setTheme("ace/theme/chrome");
        editor.getSession().setMode("ace/mode/c_cpp");
        editor.setValue(start);
        editor.commands.addCommand({
            name: 'Save',
            bindKey: {win: 'Ctrl-S', mac: 'Command-S'},
            exec: function (editor) {
                $('#download').trigger('click');
            },
            readOnly: true // false if this command should not apply in readOnly mode
        });

        editor.commands.addCommand({
            name: 'Open',
            bindKey: {win: 'Ctrl-O', mac: 'Command-O'},
            exec: function (editor) {
                $('#file').trigger('click');
            },
            readOnly: true // false if this command should not apply in readOnly mode
        });


        editor.getSession().on('change', function (e) {
            if ($('#verify').attr('disabled') === 'disabled') {
                $('#verify').css('opacity', '0.65');
                $('#verify').removeAttr("disabled");
                $('#upload').css('opacity', '0.35');
                $('#upload').attr("disabled", "disabled");
            }
        });

        $('#download').hover(function () {
            $('#acting').html(lang.save);
            $('#download').on('mouseleave', function () {
                $('#acting').html('');
            });
        });

        $('#open').hover(function () {
            $('#acting').html(lang.open);
            $('#open').on('mouseleave', function () {
                $('#acting').html('');
            });
        });

        $('#upload').hover(function () {
            $('#acting').html(lang.upload);
            $('#upload').on('mouseleave', function () {
                $('#acting').html('');
            });
        });

        $('#verify').hover(function () {
            $('#acting').html(lang.verify);
            $('#verify').on('mouseleave', function () {
                $('#acting').html('');
            });
        });

        $('#serial').hover(function () {
            $('#acting').html(lang.serial);
            $('#serial').on('mouseleave', function () {
                $('#acting').html('');
            });
        });

        $('#download').click(function (event) {
            var code = editor.getValue();
            var data = {code: code, file: $('#tab').html()};
            console.log(data);
            $.redirect('http://relle.ufsc.br/arduino/download', data);
            event.preventDefault();
        });

        $('#open').click(function (event) {
            event.preventDefault();
            $('#file').click();
        });

        $('#reset').click(function (event) {
            event.preventDefault();
            if (isConnected(socket)){
                socket.emit('reset');
                $("#labcam").attr("src", $("#labcam").attr('src'));
            }
        });

        // Variable to store your files
        var files;

        // Add events
        $('input[type=file]').on('change', prepareOpen);

        // Grab the files and set them to our variable
        function prepareOpen(event)
        {
            console.log('prepareOpen');
            files = event.target.files;
            $('#form').trigger('submit');
        }

        $('#form').on('submit', openFiles);

        // Catch the form submit and upload the files
        function openFiles(event) {
            console.log('openFiles');
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening

            // START A LOADING SPINNER HERE

            // Create a formdata object and add the files
            var data = new FormData();
            $.each(files, function (key, value)
            {
                console.log('files');
                data.append(key, value);
            });

            $.ajax({
                url: 'http://relle.ufsc.br/arduino/upload',
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function (data, textStatus, jqXHR) {
                    if (typeof data.error === 'undefined') {
                        // Success so call function to process the form
                        //submitForm(event, data);
                        data = JSON.stringify(data);
                        var results = $.parseJSON(data);
                        console.log(results);
                        var cod = String(results.code);
                        console.log(typeof cod);
                        var edit = ace.edit("editor");
                        edit.setValue('');
                        edit.setValue(cod);
                        $('#tab').html(results.name);
                        $('#file').html(results.name);
                    } else {
                        // Handle errors here
                        console.log('ERRORS: ' + data.error);
                    }


                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    // Handle errors here
                    console.log('ERRORS: ' + textStatus);
                    // STOP LOADING SPINNER
                }
            });
        }

        $('#verify').click(function (event) {
            event.preventDefault();
            if ($('#after').is(':hidden')) {
                $('#after').show();
            }

            if (isConnected(socket)){
                $('#output').html('');
                $('.message').html(lang.compiling);
                verifyCode();
                progress();
                $('#verify').css('opacity', '0.35');
                $('#verify').attr("disabled", 'disabled');
                $('#upload').css('opacity', '0.65');
                $('#upload').removeAttr("disabled");
                $('#serial').css('opacity', '0.65');
            }
            verifytimeout = setTimeout(function () {
                $('#modal').click();

            }, 20000);

        });

        function verifyCode() {
            var file = editor.getValue();
            var data = {
                file: file,
                pass: $('meta[name=csrf-token]').attr('content'),
                filename: $('#tab').html()
            };
            
            if (isConnected(socket)){
                socket.emit('compile', data);
            }
        }



        function progress() {
            //$('.message').html('');
            $('#prog').css('width', '0%');
            $('#prog').attr('aria-valuenow', 0);

            interval = setInterval(function () {
                var value = $('#prog').attr('aria-valuenow');
                value = parseInt(value) + 10;
                var percentage = value + '%';
                $('#prog').css('width', percentage);
                $('#prog').attr('aria-valuenow', value);
                if (value == 100) {
                    clearInterval(interval);
                }
            }, 1000);

        }

        $('#upload').click(function (event) {
            event.preventDefault();
            $('#output').html('');
            $('.message').html(lang.uploading);

            if ($('#serial_monitor').is(':hidden')) {
                // $('#right').removeClass('col-lg-3');
                // $('#right').addClass('col-lg-6');
            }

            progress();
            if (isConnected(socket)){
                socket.emit('upload', null);
            }
            uploadtimeout = setTimeout(function () {
                $('#modal').click();
            }, 20000);
        });


        $('#serial').click(function (event) {
            event.preventDefault();

            if ($('#serial_monitor').is(':hidden')) {

                $('#right').removeClass('col-lg-4 col-lg-offset-0')
                        .addClass('col-lg-offset-1 col-lg-10');
                $('#right div.col-xs-12').removeClass("col-lg-12").addClass("col-lg-5");

                $('#serial_monitor').show();


            } else {
                $('#right').addClass('col-lg-4 col-lg-offset-0')
                        .removeClass('col-lg-offset-1 col-lg-10');
                $('#right div').removeClass("col-lg-5");
                $('#right div.col-xs-12').removeClass("col-lg-5").addClass("col-lg-12");
                $('#serial_monitor').hide();
            }
        });

        $('#close').click(function (event) {
            event.preventDefault();

            $('#right').addClass('col-lg-4 col-lg-offset-0')
                    .removeClass('col-lg-offset-1 col-lg-10');
            $('#right div').removeClass("col-lg-5");
            $('#right div.col-xs-12').removeClass("col-lg-5").addClass("col-lg-12");
            $('#serial_monitor').hide();
        });

        $('#led').click(function (event) {
            event.preventDefault();
            code_temp = editor.getValue();
            code_name = $('#tab').html();
            $("#editing").bind("click", function () {
                editor.setValue(code_temp);
                $('#tab').html(code_name);
            });
            var txtFile = new XMLHttpRequest();
            var allText;
            txtFile.open("GET", "http://relle.ufsc.br/examples/" + lang.language + "/led.ino", true);
            txtFile.onreadystatechange = function () {
                if (txtFile.readyState === 4) {  // Makes sure the document is ready to parse.
                    if (txtFile.status === 200) {  // Makes sure it's found the file.
                        allText = txtFile.responseText;
                        var edit = ace.edit("editor");
                        $('#tab').html('led.ino');
                        edit.setValue('');
                        edit.setValue(allText);
                    }
                }
            };
            txtFile.send(null);
        });
        $('#ldr').click(function (event) {
            event.preventDefault();
            code_temp = editor.getValue();
            code_name = $('#tab').html();
            $("#editing").bind("click", function () {
                editor.setValue(code_temp);
                $('#tab').html(code_name);
            });
            var txtFile = new XMLHttpRequest();
            var allText;
            txtFile.open("GET", "http://relle.ufsc.br/examples/" + lang.language + "/ldr.ino", true);
            txtFile.onreadystatechange = function () {
                if (txtFile.readyState === 4) {  // Makes sure the document is ready to parse.
                    if (txtFile.status === 200) {  // Makes sure it's found the file.
                        allText = txtFile.responseText;
                        var edit = ace.edit("editor");
                        $('#tab').html('ldr.ino');
                        edit.setValue('');
                        edit.setValue(allText);
                    }
                }
            };
            txtFile.send(null);
        });
        $('#servo').click(function (event) {
            event.preventDefault();
            code_temp = editor.getValue();
            code_name = $('#tab').html();
            $("#editing").bind("click", function () {
                editor.setValue(code_temp);
                $('#tab').html(code_name);
            });
            var txtFile = new XMLHttpRequest();
            var allText;
            txtFile.open("GET", "http://relle.ufsc.br/examples/" + lang.language + "/servo.ino", true);
            txtFile.onreadystatechange = function () {
                if (txtFile.readyState === 4) {  // Makes sure the document is ready to parse.
                    if (txtFile.status === 200) {  // Makes sure it's found the file.
                        allText = txtFile.responseText;
                        var edit = ace.edit("editor");
                        $('#tab').html('servo.ino');
                        edit.setValue('');
                        edit.setValue(allText);
                    }
                }
            };
            txtFile.send(null);
        });
        $('#lm35').click(function (event) {
            event.preventDefault();
            code_temp = editor.getValue();
            code_name = $('#tab').html();
            $("#editing").bind("click", function () {
                editor.setValue(code_temp);
                $('#tab').html(code_name);
            });
            var txtFile = new XMLHttpRequest();
            var allText;
            txtFile.open("GET", "http://relle.ufsc.br/examples/" + lang.language + "/lm35.ino", true);
            txtFile.onreadystatechange = function () {
                if (txtFile.readyState === 4) {  // Makes sure the document is ready to parse.
                    if (txtFile.status === 200) {  // Makes sure it's found the file.
                        allText = txtFile.responseText;
                        var edit = ace.edit("editor");
                        $('#tab').html('lm35.ino');
                        edit.setValue('');
                        edit.setValue(allText);
                    }
                }
            };
            txtFile.send(null);
        });

        $('#rgb_lcd_h').click(function (event) {
            event.preventDefault();
            var edit = ace.edit("editor");
            edit.gotoLine(1);
            edit.insert('#include "rgb_lcd.h"\n');
        });

        $('#servo_h').click(function (event) {
            event.preventDefault();
            var edit = ace.edit("editor");
            edit.gotoLine(1);
            edit.insert("#include <Servo.h>\n");
        });

        $('#wire_h').click(function (event) {
            event.preventDefault();
            var edit = ace.edit("editor");
            edit.gotoLine(1);
            edit.insert("#include <Wire.h>\n");
        });


        $('#baudrate').on('change', function () {
            var value = $('#baudrate').val();
            socket.emit('serial setup', {baudrate: value});
        });

        $('#serial_send').click(function (event) {
            event.preventDefault();
            var value = $('#serial_input').val();
            socket.emit('serial write', {write: value});
            $('#serial_input').val('');
        });

        $('#clear').click(function (event) {
            event.preventDefault();
            $('textarea').html('');
        });

        $('#serial_input').keypress(function (event) {
            if (event.which == 13) {
                event.preventDefault();
                $("#serial_send").click();
                $('#serial_input').val('');
            }
        });

        var firsttoggle = true;
        $('#ide ul.dropdown-menu li a').click(function (event) {
            event.stopPropagation();
            var thisEl = this;
            $("#ide ul.dropdown-menu li a[data-toggle='collapse']").each(function () {
                if (this != thisEl && !firsttoggle) {
                    $($(this).attr('data-target')).collapse('hide');
                } else {
                    $($(thisEl).attr('data-target')).collapse('toggle');
                }

            });
            firsttoggle = false;

        });

    });

    $.getScript(addr + '/socket.io/socket.io.js', function () {
        console.log("Connected to the lab server");

        socket = io.connect(addr);
        socket.emit('new connection', {pass: $('meta[name=csrf-token]').attr('content')});

        $("#right .controllers").show();
        $("#right .loading").hide();

        socket.on('done compiling', function (data) {
            clearTimeout(verifytimeout);
            console.log('done compiling');
            clearInterval(interval);
            $('#prog').css('width', '100%');
            $('#prog').attr('aria-valuenow', '100');
            $('#output').html('');
            if (typeof data.stderr === 'undefined') {
                verifyBarSuccess(lang.done_compiling, data.stdout);
            } else {
                verifyBarError(lang.error_compiling, data.stderr);
                console.log(data.stderr);
            }
        });


        socket.on('done upload', function (data) {
            console.log('done upload');
            clearTimeout(uploadtimeout);
            $('#prog').css('width', '100%');
            $('#prog').attr('aria-valuenow', '100');
            $('#output').html('');
            $('#verify_bar p.message').html('');
            if (typeof data.stderr === 'undefined') {
                verifyBarSuccess(lang.done_upload, data.stdout);
                $('#port').html(data.port);
                $('#serial').removeAttr("disabled");
            } else {
                verifyBarError(lang.error_uploading, data.stderr);
                console.log(data.stderr);
            }
            $("#labcam").attr("src", $("#labcam").attr('src'));

        });

        socket.on('serial monitor', function (data) {
            if (typeof data.stderr === 'undefined') {
                var parsed = String.fromCharCode.apply(null, new Uint8Array(data.stream))
                parsed = parsed.replace(/\n/g, '<br>');
                $('textarea').append(parsed);

            } else {
                verifyBarError(lang.error_serial, data.stderr);
                console.log(data.stderr);
            }

            $("#labcam").attr("src", $("#labcam").attr('src'));

        });

    });

    $.getScript('http://relle.ufsc.br/exp_data/4/zoom.js', function () {
        $('#img-zoomed').zoom({on: 'grab'});
    });


});


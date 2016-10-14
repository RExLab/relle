var setupShepherd = function () {
    
   var  shepherd = new Shepherd.Tour({
        defaults: {
            classes: 'shepherd-element shepherd-open shepherd-theme-arrows',
            showCancelLink: true,
            scrollTo: true
        }
    });  
    // Entrar no tour 
    shepherd.addStep('shep_intro', { 
        text: [lang.intro1],
        attachTo:'.ace_content left',
        classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
        buttons: [
            {
                text: lang.leave,
                classes: 'shepherd-button-secondary',
                 action: function () {
                    shepherd.cancel();
                }
            }, {
                text: lang.next,
                action: function () {
                    shepherd.next();
                },
                classes: 'shepherd-button-example-primary'
            }
        ]
    });
    
    // Tour no meio
    shepherd.addStep('shep_grafico', { 
        text: [lang.intro2],
        attachTo: '#menu left',
        classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
        buttons: [
            {
                text: lang.previous,
                classes: 'shepherd-button-secondary',
                action: function () {
                    shepherd.back();
                }
            }, {
                text: lang.next,
                action: function () {
                    shepherd.next();
                },
                classes: 'shepherd-button-example-primary'
            }
        ]
    });
    
    
    
  
    shepherd.addStep('shep_legenda', { 
        text: [lang.intro3],
        attachTo: 'li.aqui left',
        classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
        buttons: [
            {
                text: lang.previous,
                classes: 'shepherd-button-secondary',
                action: function () {
                    shepherd.back();
                }
            }, {
                text: lang.next,
                action: function () {
                    shepherd.next();
                },
                classes: 'shepherd-button-example-primary'
            }
        ]
    });
    
    
    shepherd.addStep('shep_barras', { 
        text: [lang.intro4],
        attachTo:"#diagram left",
        classes: "shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text",
        buttons: [
            {
                text: lang.previous,
                classes: 'shepherd-button-secondary',
                action: function () {
                    shepherd.back();
                }
            }, {
                text: lang.next,
                action: function () {
                    $('#after').toggle();
                    shepherd.next();
                },
                classes: 'shepherd-button-example-primary'
            }
        ]
    });
    shepherd.addStep('shep_termo', { 
        text: [lang.intro5],
        attachTo: '#after top',
        classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
        buttons: [
            {
                text: lang.previous,
                classes: 'shepherd-button-secondary',
                action: function () {
                    $('#after').toggle();
                    shepherd.back();
                }
            }, {
                text: lang.next,
                action: function () {
                    $('#after').toggle();
                    $('#serial_monitor').toggle();
                    shepherd.next();
                },
                classes: 'shepherd-button-example-primary'
            }
        ]
    });
    shepherd.addStep('shep_curvas', { 
        text: [lang.intro6],
        attachTo: '#serial_monitor right',
        classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
        buttons: [
            {
                text: lang.previous,
                classes: 'shepherd-button-secondary',
                action: function () {
                    $('#serial_monitor').toggle();
                    $('#after').toggle();
                    shepherd.back();
                }
            }, {
                text: lang.next,
                action: function () {
                    $('#serial_monitor').toggle();
                    shepherd.next();
                },
                classes: 'shepherd-button-example-primary'
            }
        ]
    });
    
    
    
    shepherd.addStep('shep_volte', { 
        text: [lang.intro7],
        attachTo: "#labcam right",
        classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
        buttons: [
            {
                text: lang.previous,
                classes: 'shepherd-button-secondary',
                action: function () {
                    $('#serial_monitor').toggle();
                    shepherd.back();
                }  
            }, { 
                text: lang.done,
                action: function () {   
                    shepherd.cancel();
                },
                classes: 'shepherd-button-example-primary'
            }
        ]
    });
    
    shepherd.on('cancel', function () {

    });
    
    shepherd.on('start', function () {
        
    });
    
    return shepherd;

};


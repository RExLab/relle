var setupShepherd = function () {
    
   var  shepherd = new Shepherd.Tour({
        defaults: {
            classes: 'shepherd-element shepherd-open shepherd-theme-arrows',
            showCancelLink: true,
            scrollTo: true
        }
    });  
    // Entrar no tour  s
    shepherd.addStep('shep_intro', { 
        text: [lang.intro1],
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
    shepherd.addStep('shep_cam', { 
        text: [lang.introcamera],
        attachTo: 'img.cam center',
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
    
    shepherd.addStep('shep_switches', { 
        text: [lang.switches],
        attachTo: 'div.casa top',
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
    
    shepherd.addStep('shep_switches', { 
        text: [lang.intro2],
        attachTo: 'div.lamp top',
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
      
    shepherd.addStep('shep_capacitor', { 
        text: [lang.intro3],
        attachTo: 'div.citor top',
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
    
    shepherd.addStep('shep_luzes', { 
        text: [lang.intro4],
        attachTo: 'div.luzes top',
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
    
    shepherd.addStep('shep_tensao', { 
        text: [lang.intro5],
        attachTo: 'div.tensao top',
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
    
    shepherd.addStep('shep_orientacao', { 
        text: [lang.intro6],
        attachTo: 'div.ajuste top',
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
    
     
    shepherd.addStep('shep_texto', { 
        text: [lang.capacit],
        attachTo: 'div.capac top',
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
     
    
    shepherd.addStep('shep_tempo', { 
        text: [lang.intro7],
        attachTo: 'div.tempo top',
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
    
    shepherd.addStep('shep_carregar', { 
        text: [lang.intro8],
        attachTo: 'div.charge top',
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
    
    shepherd.addStep('shep_descarregar', { 
        text: [lang.intro9],
        attachTo: 'div.discharge top',
        classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
        buttons: [
            {
                text: lang.previous,
                classes: 'shepherd-button-secondary',
                action: function () {
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

    /*
     * text: lang.done,
                action: function () {
                    shepherd.cancel();
                },
     */


};


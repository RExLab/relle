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
        attachTo: 'img.cam bottom',
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
    
    
    
  
    shepherd.addStep('shep_description', { 
        text: [lang.description],
        attachTO: 'div.infor top',
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
    // Finaliza Tour
    shepherd.addStep('shep_buttons', { 
        text: [lang.buttons],
        attachTo: 'div.buttons bottom',
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

};


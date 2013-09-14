
    /*****************************************************************/
    /*****************************************************************/

    function submitContactForm()
    {
        blockForm('contact-form','block');
        $.post('contactform/validateDetails',$('#contact-form').serialize(),submitContactFormResponse,'json');
    }

    /*****************************************************************/

    function submitContactFormResponse(response)
    {
        blockForm('contact-form','unblock');
        $('#contact-form-name,#contact-form-mail,#contact-form-message,#contact-form-send').qtip('destroy');

        var tPosition=
        {
            'contact-form-send'		: {'my':'right center','at':'left center'},
            'contact-form-name'		: {'my':'bottom center','at':'top center'},
            'contact-form-mail'		: {'my':'bottom center','at':'top center'},
			'contact-form-message'	: {'my':'top center','at':'bottom center'}
        };

        if(typeof(response.info)!='undefined')
        {	
            if(response.info.length)
            {	
                for(var key in response.info)
                {
                    var id=response.info[key].fieldId;
                    $('#'+response.info[key].fieldId).qtip(
                    {
                            style:      { classes:(response.error==1 ? 'ui-tooltip-error' : 'ui-tooltip-success')},
                            content: 	{ text:response.info[key].message },
                            position: 	{ my:tPosition[id]['my'],at:tPosition[id]['at'] }
                    }).qtip('show');				
                }
            }
        }
    }

    /*****************************************************************/
    /*****************************************************************/
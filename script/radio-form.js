	
    /*****************************************************************/
    /*****************************************************************/
	
	function submitRadioForm()
	{
		blockForm('radio-form','block');
		$.post('radioform/validateDetails',$('#radio-form').serialize(),submitRadioFormResponse,'json');
	}
	
	/*****************************************************************/
	
	function submitRadioFormResponse(response)
	{
        blockForm('radio-form','unblock');
        $('#radio-form-email,#radio-form-send,#radio-form-name,#radio-form-phone,#radio-form-band').qtip('destroy');

        var tPosition=
        {
            'radio-form-name'		: {'my':'bottom center','at':'top center'},
			'radio-form-band'		: {'my':'bottom center','at':'top center'},
			'radio-form-phone'		: {'my':'bottom center','at':'top center'},
            'radio-form-email'		: {'my':'bottom center','at':'top center'},
			'radio-form-send'		: {'my':'bottom left','at':'top center'}
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
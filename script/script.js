
/******************************************************************************/
/******************************************************************************/

function getRandom(min,max)
{
	return((Math.floor(Math.random()*(max-min)))+min);
}

/******************************************************************************/

function blockForm(formId,action)
{
	if(action=='block')
		$('#'+formId).find('.block').block({message:false,overlayCSS:{opacity:'0.3'}});
	else $('#'+formId).find('.block').unblock();
}

/******************************************************************************/

function blink(element)
{
	$(element).animate({opacity:($(element).css('opacity')==1 ? 0.2 : 1)},500,function() { blink($(this)); });
};

/******************************************************************************/

function getResponsiveStep()
{
	var step=0;
	var windowWidth=$(window).width();

	if((windowWidth<=969) && (windowWidth>768)) step=1;
	if((windowWidth<=767) && (windowWidth>480)) step=2;
	if((windowWidth<=479)) step=3;		

	return(step);
}

/******************************************************************************/

function setTwitterDimension()
{
	var step=getResponsiveStep();
	var dimension=[[330,80],[600,80],[300,80],[180,160]];

	$('#latest-tweets ul').trigger('configuration',{items:{width:dimension[step][0],height:dimension[step][1]}});
	$('#latest-tweets ul li,#latest-tweets ul li p').css({width:dimension[step][0],height:dimension[step][1]});

	$('#latest-tweets ul').trigger('updateSizes');				
}

/******************************************************************************/

function setImageListDimension()
{
	var step=getResponsiveStep();
	var dimension=[[253],[260],[246],[287]];

	$('.image-list.image-list-carousel').trigger('configuration',{height:dimension[step][0]});
	$('.image-list.image-list-carousel').trigger('updateSizes');
}

/******************************************************************************/
/******************************************************************************/


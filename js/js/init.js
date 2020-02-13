/** *************Init JS*********************
	
************************************* **/
 
 "use strict"; 

/*****Ready function start*****/
$(document).ready(function(){
  ed();
  $('.la-anim-1').addClass('la-animate');
});
/*****Ready function end*****/

/*****Load function start*****/
$(window).load(function(){
	$(".preloader-it").delay(100).fadeOut("slow");
});
/*****Load function* end*****/



/***** Full height function start *****/
var setHeight = function () {
	var height = $(window).height();
	$('.full-height').css('height', (height));
};
/***** Full height function end *****/


/***** Resize function start *****/
$(window).on("resize", function () {
	setHeight();
	var width = $(window).width();
	if(width <= 1330) {
		$(".copywrite-wrap").insertAfter($(".connect-add"));
	}
	else 
		{
		$(".copywrite-wrap").appendTo($(".right-patch"));
	}
	if(width <= 974) {
		$(".contact-form-wrap").insertBefore($(".contact-add"));
	}
	else 
		{
		$(".contact-form-wrap").insertAfter($(".contact-add"));
	}
}).resize();
/***** Resize function end *****/

/***** My function start *****/
var ed = function (){
	/*Fullpage JS*/
	$('#fullpage').fullpage({
		menu: '#menu',
		scrollBar:true,
		anchors: ['home_sec', 'about_sec', 'portfolio_sec','skills_sec','contact_sec'],
		navigation: true,
		navigationPosition: 'right',
		navigationTooltips: ['home', 'about','portfolio', 'skills','contact'],
		responsiveWidth: 3000
	});
		
}
/***** My function end *****/

/***** Service toggle window start*****/
$(document).on( 'click', ".services-item .toggle-expand,.team-person .toggle-expand", function (e) {
	e.preventDefault();
	e.stopPropagation();
	var $this = $(this).parent();
	if(($this.find('.expand-content').hasClass('expand-visible')) && (!$this.find('.excont').hasClass('opacity-hide')) ) { 
		$this.find('.excont').addClass('opacity-hide');
		$this.find('.toggle-expand .minus').addClass('opacity-hide');
		$this.find('.toggle-expand .plus').removeClass('opacity-hide');
		setTimeout(function() { 
			$this.find('.expand-content').removeClass('expand-visible');
		},400);
	}
	if(!($this.find('.expand-content').hasClass('expand-visible'))) {
		$this.find('.expand-content').addClass('expand-visible');
		$this.find('.toggle-expand .minus').removeClass('opacity-hide');
		$this.find('.toggle-expand .plus').addClass('opacity-hide');
		setTimeout(function() { 
			$this.find('.excont').removeClass('opacity-hide');
		},800);
	}
	return false;
});



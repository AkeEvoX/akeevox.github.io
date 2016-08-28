$(document).ready(function(){
	$("#product-slider").lightSlider({
		autoWidth: true
		,item:4
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
	    ,pager:false
 	});

 	$("#productgallery").unitegallery({
		theme_panel_position: "left"		
	});
});
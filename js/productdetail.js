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
	
	$(".share-popup").click(function(){
    var window_size = "width=585,height=511";
    var url = this.href;
    var domain = url.split("/")[2];
    switch(domain) {
        case "www.facebook.com":
            window_size = "width=585,height=368";
            break;
        case "www.twitter.com":
            window_size = "width=585,height=261";
            break;
        case "plus.google.com":
            window_size = "width=517,height=511";
            break;
    }
    
    window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,' + window_size);
    return false;
});
	
	
});

var control = {};
control.init = function(){
	setuplink();
	//setupsubpage();
}

control.menutab = function(page){
	$('#viewcenter').load(page, { '_' : new Date().getMilliseconds()} ,setuppage);
}

control.pagetab = function(page){
	$('#viewcontent').load(page, { '_' : new Date().getMilliseconds()},validatepage);
};

function setuplink(){

	$('.menutab').click(function(){
		var link = $(this).attr('data-page');
		console.log(link);
		
		if(link!=undefined)
			control.menutab(link);
		else
			alert('page not found');
	});
	
}

function setuppage(){
	
	$('.pagetab').click(function(){
		var link = $(this).attr('data-page');
		
		if(link!=undefined)
			control.pagetab(link);
	});
	
}

function validatepage(responseText,textStatus,req){
	//console.log(req);
	if(req.status=="404"){
			$('#viewcontent').html("<h2>Page Not Found</h2>");//"Page Not Found"
	}
}

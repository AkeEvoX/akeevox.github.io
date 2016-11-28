
var control = {};
control.init = function(){
	setuplink();
	//setuppage();
}

control.menutab = function(page){
	$('#viewcontent').load(page, { '_' : new Date().getMilliseconds()} ,function(result,status,xhr){
		if(validatemenu(result,status,xhr))
			setup_activepage();//set pagetab redirect
	});
	
}

control.pagetab = function(page){
	
	$('#viewpage').load(page, { '_' : new Date().getMilliseconds()},validatepage);
	setuppage();
	
};

function setup_activepage(){
	
	$('.nav-pills > li > a').click( function() {
		
		$('.nav-pills > li.active').removeClass('active');
		$(this).parent().addClass('active');
		
		var link  = $(this).attr('data-page');
		console.log(link);
		control.pagetab(link);
		
	} );
	
	
	
}

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
		//var parent  = $(this).attr('data-parent');
		//var view =$('#'+parent).find('.viewcontent');
		if(link!=undefined)
			control.pagetab(link);
	});
	
}

function validatemenu(result,status,req){
	//console.log(req);
	if(req.status=="404"){
			$('#viewcontent').html("<h2>Page Not Found</h2>");//"Page Not Found"
			return false;
	}
	else
		return true;
}

function validatepage(result,status,req){
	//console.log(req);
	if(req.status=="404"){
		$('#viewpage').html("<h2>Page Not Found</h2>");//"Page Not Found"
		return false;
	}
	else 
		return true;
}

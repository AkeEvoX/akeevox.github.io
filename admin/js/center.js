
var control = {};
control.init = function(){
	setuplink();
	//setuppage();
}

control.menutab = function(page){
	$('#viewcontent').html('');
	$('#viewcontent').load(page, { '_' : new Date().getMilliseconds()} ,function(result,status,xhr){
		if(validatemenu(result,status,xhr))
		{
			
			setup_activepage();//set pagetab redirect
			//$('.nav-pills > li > a').unbind('click');
		}
		//
	});
	
	//
	
	
	//$('#viewcontent').unbind('load');
}

control.pagetab = function(page,object){
	//$('#viewpage').unbind('load');
	$('#parameter').val(object);
	$('#viewpage').html('');
	$(window).unbind('scroll');	
	$('#viewpage').load(page, { '_' : new Date().getMilliseconds()},function(result,status,xhr){
		console.log('select pagetab');
		if(validatepage(result,status,xhr)){
			//setuppage();
		}
			
	});
	
};

function setup_activepage(){
	
	//$('.nav-pills > li > a').unbind('click');
	
	$('.nav-pills > li > a').click( function() {
		
		$('.nav-pills > li.active').removeClass('active');
		$(this).parent().addClass('active');
		
		var link  = $(this).attr('data-page');
		
		console.log(link);
		if(link!=undefined)
			control.pagetab(link);
		else
			console.log('page not found');
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

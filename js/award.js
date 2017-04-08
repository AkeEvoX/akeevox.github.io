function loadList()
{
	var endpoint = 'services/award.php' ;
	var method = "get";
	//load award
	var args = {"_": new Date().getMilliseconds(),"type":"reward","type_reward":"0"};
	utility.service(endpoint,method,args,setaward,apply_slider);	
	//apply_slider
	
	//load standard
	args = {"_": new Date().getMilliseconds(),"type":"reward","type_reward":"1"};
	utility.service(endpoint,method,args,setstandard);
	
	
}

function LoadItem(id)
{
	var endpoint = 'services/award.php' ;
	var method = 'get';
	var args = {"_": new Date().getMilliseconds(),"id":id}
	
	utility.service(endpoint,method,args,setviewdetail);
}

function setview(data){
	try{
	
	var award = data.result.filter(function(item) {return item.type == "0" ; });
	var standard = data.result.filter(function(item) {return item.type == "1" ; });
	
	console.log(standard);

	setaward(award);
	setstandard(standard);
	 
	}
	catch(err)
	{
		console.error("display error : " +err.message);
	}

}

function setaward(data){
	
	console.log(data.result);
	// mobile!
	if (/Mobi/.test(navigator.userAgent)) {
    
		console.log("mobile view");
		set_award_mobile(data.result);
	}
	else{
		console.log("desktop view");
		set_award_desktop(data.result);
	}
	
}

function set_award_mobile(data){
	
	var award = $("#immersive_slider");
	//award.removeClass("");
	award.height("auto");
	var itemview = "";
	$.each(data,function(idx,val){
		itemview += "<div class='col-xs-12 col-sm-6 col-md-3' style='display:block;margin:0 auto;'><a href='javascript:void(0);' onclick=popup("+val.id+"); ><img src='"+val.thumbnail+"' class='img-responsive' /></a></div>";
	});//col-xs-12 
	award.append(itemview);
}

function set_award_desktop(data){
	
	var award = $('#immersive_slider');
	award.html('');
	
	var itemview = "";
	itemview += "<div class='slide' data-blurred='' ><div class='content' ><div class='row' >";
	
	var w = window.innerWidth;
	var item = 13;
	var row = 4;
	
	if(w < 700) { item = 3;	row =1; }
	else if(w < 900) { item = 6;	row =2; }
	else if(w < 1000) { item = 8;	row =2; }
	
	$.each(data,function(idx,val){

		 itemview += "<div class='col-xs-12 col-sm-6 col-md-3' style='display:block;margin:0 auto;'><a  href='javascript:void(0);'  onclick=popup("+val.id+"); style='z-index: 1;' ><img src='"+val.thumbnail+"' class='img-fluid' /></a></div>";
		
		  //page slide
		 if(((idx+1) % item) == 0) //if(((idx+1) % 13) == 0)
		 {
			 itemview += "</div></div><div class='slide' data-blurred='' ><div class='content' ><div class='row'> ";
		 }

	});

	itemview += "</div>";//close tag contact
	
	if(data.length<=item) //12 item :: page
	{
		itemview += "</div>";//close tag page slider
	}

	award.append(itemview);
	award.append("<a href='#'' class='is-prev'>&laquo;</a><a href='#'' class='is-next'>&raquo;</a>");

}

function apply_slider(){
	// mobile!
	if (/Mobi/.test(navigator.userAgent)!=true) {
		
		$('#immersive_slider').immersive_slider({
			animation: "slide",
			container: ".main",
			loop:true,
			cssBlur:false,
			autoStart:0,
			pagination :false
		});
		
	}
	
	$('#immersive_slider .is-prev').click(function(e){
		var time = new Date().getMilliseconds();
		console.log('click previos : ' + time);
	});
}

function setstandard(data) {

	// mobile!
	if (/Mobi/.test(navigator.userAgent)) {
    
		console.log("mobile view");
		set_standard_mobile(data.result);
	}
	else{
		console.log("desktop view");
		set_standard_desktop(data.result);
	}

}

function set_standard_mobile(data){
		var standard = $("#standard_slide");
	//award.removeClass("");
	standard.height("auto");
	var itemview = "";
	$.each(data,function(idx,val){
		itemview += "<div class='col-xs-12 col-sm-6 col-md-3' style='display:block;margin:0 auto;'><a href='javascript:void(0);' onclick=popup("+val.id+"); ><img src='"+val.thumbnail+"' class='img-responsive' /></a></div>";
	});// 
	standard.append(itemview);
}

function set_standard_desktop(data){
	
	var standard = $('#standard_slide');
	standard.html('');
	//console.log(data.result);
	var w = window.innerWidth;
	var item = 13;
	var row = 4;
	
	if(w < 700) { item = 3;	row =1; }
	else if(w < 900) { item = 6;	row =2; }
	else if(w < 1000) { item = 8;	row =2; }
	
	var itemview = "";
	itemview += "<div class='slide' data-blurred='' ><div class='content' ><div class='row' >";
	$.each(data,function(idx,val){

		//item
		 itemview += "<div class='col-xs-12 col-sm-6 col-md-3' style='position:relative;float:left;display:block;margin:0 auto;' ><a href='javascript:void(0);' onclick=popup("+val.id+"); ><img src='"+val.thumbnail+"'   class='img-fluid' /></a></div>";
		
		  //page slide
		 if(((idx+1) % item) === 0)
		 {
			 itemview += "</div></div><div class='slide' data-blurred='' ><div class='content' ><div class='row'> ";
		 }

	});

	itemview += "</div>";//close tag contact

	if(data.length<=item) //12 item :: page
	{
		itemview += "</div>";//close tag page slider
	}

	//console.log(itemview);
	standard.append(itemview);
	standard.append("<a href='#'' class='is-prev'>&laquo;</a><a href='#'' class='is-next'>&raquo;</a>");


	standard.immersive_slider({
		animation: "slide",
		container: ".main",
		loop:true,
		cssBlur:false,
		autoStart:0,
		pagination :false
	    });
}

function popup(id)
{
	var page = "viewaward.html?rdm="+new Date().getHours();
	utility.modalpage("&nbsp;",page,bindmodal(id));
}

function bindmodal(id){

 var url = "services/award.php";
 var arg = {"_": new Date().getMilliseconds(),"id":id};

  utility.service(url,'GET',arg
,function(response){
		console.log(response);
		$('#cover').attr('src',response.result.thumbnail);
		$('#title').html(response.result.title);
		$('#desc').html(response.result.detail);

}
,null)

}


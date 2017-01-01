function loadList()
{
	var endpoint = 'services/award.php' ;
	var method = "get";
	var args = {"_": new Date().getMilliseconds()}
	//CallService(service,data,setview);
	
	
	utility.service(endpoint,method,args,setview,apply_slider);
	
}

function LoadItem(id)
{
	var endpoint = 'services/award.php' ;
	var method = 'get';
	var args = {"_": new Date().getMilliseconds(),"id":id}
	//CallService(service,data,setviewdetail);
	
	utility.service(endpoint,method,args,setviewdetail);
}

function CallService(service,param,callback)
{

	$.ajax({
		url:service,
		type:'GET',
		data:param,
		dataType:'json',
		success : callback ,
		error:function(xhr,status,err){
			console.error(xhr.responseText)
			alert(xhr.responseText);
		}
	});
}




function setview(data){
	try{
	
	var award = data.result.filter(function(item) {return item.type == "0" ; });
	var standard = data.result.filter(function(item) {return item.type == "1" ; });
	
	console.log(standard);

	setaward(award);
	setstandard(standard);
	 //$('.photoGrid').photoGrid({rowHeight:"250"});
	}
	catch(err)
	{
		console.error("display error : " +err.message);
	}

}

function setaward(data){

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

		 //item
		 itemview += "<div class='col-xs-12 col-sm-6 col-md-3' ><a href='javascript:void(0);' onclick=popup("+val.id+"); ><img src='"+val.thumbnail+"' class='img-responsive' /></a></div>";

		//row
		 if(((idx +1) % row) == 0) //if(((idx +1) % 4) == 0)
		 {
			 //itemview += "</div><div class='row' >";
		 }

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

	//console.log(itemview);
	award.append(itemview);
	award.append("<a href='#'' class='is-prev'>&laquo;</a><a href='#'' class='is-next'>&raquo;</a>");

/*
	award.immersive_slider({
		animation: "slide",
		container: ".main",
		loop:true,
		cssBlur:false,
		autoStart:0
	});
*/
}

function apply_slider(){
	$('#immersive_slider').immersive_slider({
		animation: "slide",
		container: ".main",
		loop:true,
		cssBlur:false,
		autoStart:0,
		pagination :false
	});
}

function setstandard(data) {

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
		 itemview += "<div class='col-xs-12 col-sm-6 col-md-3' style='position:relative;float:left;' ><a href='javascript:void(0);' onclick=popup("+val.id+"); ><img src='"+val.thumbnail+"'   class='img-responsive' /></a></div>";

		//row
		 if(((idx +1) % row) === 0)
		 {
			 //itemview += "</div><div class='row' >";
		 }

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
	//var id = $(obj).data('id');
	var page = "viewaward.html?rdm="+new Date().getHours();
	utility.modalpage("&nbsp;",page,bindmodal(id));
}

function bindmodal(id){

 var url = "services/award.php";
 var arg = {"_": new Date().getMilliseconds(),"id":id}

  utility.service(url,'GET',arg
,function(response){

		$('#cover').attr('src',response.result[0].thumbnail);
		$('#title').html(response.result[0].title);
		$('#desc').html(response.result[0].detail);

}
,null)

}

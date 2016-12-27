
function loadorganization()
{

	var endpoint = "services/organization.php";
	var method= "get";
	var args = {"_": new Date().getHours() , "type":"org","align":"left"};

	utility.service(endpoint,method,args,view_profile);

}

function view_profile(resp){
	
	if(resp.result!=undefined){
		
		$('#dataview_left').html("");
		$('#dataview_right').html("");
		
		var bg_right = "well-brown-light";
		var bg_left = "well-brown-bold";
		$.each(resp.result,function(i,val){
			
				if((i % 2) == 0){
					
					if(bg_right=="well-brown-light")
						bg_right="well-brown-bold";
					else
						bg_right="well-brown-light";
					
					profile_right(val,bg_right);
					
				}else{
					
					if(bg_left=="well-brown-bold")
						bg_left="well-brown-light";
					else
						bg_left="well-brown-bold";
					
					profile_left(val,bg_left);
					
				}
			
		});
		
	}
	
}

function profile_left(val,bg)
{
	//console.log(data.result);
	var view = $('#dataview_left');
	//$.each(data.result,function(idx,val){

		var item = "";
		item += "<div class='col-md-12'>";
		item += "<div class='media'>";
		item += "<div class='media-body'>";
		item += "<h4 class='media-heading orange'>Position : </h4>"+val.position+"<br/>";
		item += "<h4 class='media-heading orange'>Education Qualifications  : </h4>"+val.education+"<br/>";
		item += "<h4 class='media-heading orange'>Work Experience : </h4>"+val.work+"<br/>";
		item += "</div>";
		item += "<div class='media-right' >";
		item += "<a href='#'><img src='"+val.image+"' class='media-object'></a>";
		item += "</div>";
		item += "</div><div class='well well-sm "+bg+"'>"+val.name+"</div></div>";
		view.append(item);
	//});

}

function profile_right(val,bg){

	var view = $('#dataview_right');
	//$.each(data.result,function(idx,val){

		var item = "";
		item += "<div class='col-md-12'>";
		item += "<div class='media'>";
		item += "<div class='media-right' style='padding-left:0px;' >";
		item += "<a href='#'><img src='"+val.image+"' class='media-object'></a>";
		item += "</div>";
		item += "<div class='media-body' style='padding-left:10px;'>";
		item += "<h4 class='media-heading orange'>Position : </h4>"+val.position+"<br/>";
		item += "<h4 class='media-heading orange'>Education Qualifications  : </h4>"+val.education+"<br/>";
		item += "<h4 class='media-heading orange'>Work Experience : </h4>"+val.work+"<br/>";
		item += "</div>";
		item += "</div><div class='well well-sm "+bg+"''>"+val.name+"</div></div>";
		view.append(item);
	//});

}

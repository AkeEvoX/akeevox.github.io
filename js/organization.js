
function loadorganization()
{

	var endpoint = "services/organization.php";
	var method= "get";
	var args = {"_": new Date().getHours() , "type":"org","align":"left"};

	utility.service(endpoint,method,args,profile_left);

	args = {"_": new Date().getHours() , "type":"org","align":"right"};
	utility.service(endpoint,method,args,profile_right);
/*
	$.ajax({
		url:"services/organization.php",
		data:{"_": new Date().getHours() , "type":"org"},
		dataType:'json',
		type:"GET",
		success: function(data){

			console.log(data.result);
			gendata(data.result);
		},
		error : function (xhr,status,err)
		{
			console.error(xhr.responseText);
			alert("load organization information error : "+ xhr.responseText);
		}
	});*/

}

function profile_left(data)
{
	//console.log(data.result);
	var view = $('#dataview_left');
	$.each(data.result,function(idx,val){

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
		item += "</div><div class='well well-sm'>"+val.name+"</div></div>";
		view.append(item);
	});

}

function profile_right(data){

	var view = $('#dataview_right');
	$.each(data.result,function(idx,val){

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
		item += "</div><div class='well well-sm'>"+val.name+"</div></div>";
		view.append(item);
	});

}

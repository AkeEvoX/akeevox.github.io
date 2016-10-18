
function loadorganization()
{

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
	});

}

function gendata(data)
{
	var view = $('#dataview');
	$.each(data,function(idx,val){

		var item = "";
		item += "<div class='col-md-6 col-sm-6'>";
		item += "<div class='media'>";
		item += "<div class='media-left col-md-6 col-xs-12 rowspan' >";
		item += "<a href='#'><img src='"+val.image+"' class='media-object'></a>";
		item += "</div>";
		item += "<div class='media-body'>";
		item += "<h4 class='media-heading orange'>Position : </h4>"+val.position+"<br/>";
		item += "<h4 class='media-heading orange'>Education Qualifications  : </h4>"+val.education+"<br/>";
		item += "<h4 class='media-heading orange'>Work Experience : </h4>"+val.work+"<br/>";
		item += "</div></div>";
		item += "<div class='well well-sm'>"+val.name+"</div></div>";
		view.append(item);
	});

}

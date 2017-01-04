
function loaditems(){


var service = 'services/download.php' ;

	$.ajax({
		url:service,
		type:'GET',
		dataType:'json',
		success:function(data){

			$('#list').html("");
			$.each(data.result,function(i,val){
				setview(val);
			});

		},
		error:function(xhr,status,err){
			alert(err.message);
		}
	});

}

function setview(data)
{
	var row = "<label>"+data.name+"</label>" ;
	row += "<div class='row' >";
	var itemview = "";
	$.each(data.item,function(i,val){
	//visible-xs class show object on bootstrap

		itemview += "<div class='col-xs-6 col-sm-6 col-md-4'>" ;
		itemview += "<div class='view second-effect'>";
		itemview += "<img src='"+val.thumbnail+"' onerror=this.src='images/common/unavaliable.jpg'  >"; //#image height:240px;
		itemview += "<div class='thumbnail-desc'><label>"+val.title+"</label></div>";
		itemview += "<div class='mask'><a href='"+val.link+"' class='info' title='click download'></a></div>";//#hover effect
		itemview += "</div>";
		itemview += "</div>" ;
	});

	row += itemview ;
	row += "</div><div class='col-md-12'><a class='btn btn-star pull-right' href='download_list.html?id="+data.id+"'>More</a>" + "</div><hr />";

	//console.log(row);
	$('#list').append(row);
}

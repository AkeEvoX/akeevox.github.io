/*dropdown menu*/
/*
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});

$(function(){
	$('.tree-toggle').parent().children('ul.tree').toggle(200);
});
*/
function showcover()
{
	var endpoint = "services/home.php";
	var method = "GET";
	var args = {'_':new Date().getHours(),'type':'top'};

	utility.service(endpoint,method,args,viewtop,null);
	
	//args = {'_':new Date().getHours(),'type':'buttom'};
	//utility.service(endpoint,method,args,viewbottom,null);

}

function viewtop(data)
{

	if(data.result == undefined || data.result == "null"){
		console.log('viewtop not found.');
		return false;
	}

		var view = $('#viewtop');
		var viewindex = $('#index-carousel');
		var item = "";
		view.html("");
	
		$.each(data.result,function(i,val){
			
			if(item==""){
				item += '<div class="item active"> ';
				viewindex.append('<li data-target="#myCarousel" data-slide-to="'+i+'" class="active"></li>');
			}
			else{
				
				item += '<div class="item"> ';
				viewindex.append('<li data-target="#myCarousel" data-slide-to="'+i+'" ></li>');
			}
				
			
			 item += '<img src="'+val.cover+'" style="width:100%" >';
			 item += '<div class="container">&nbsp;</div>';
			 item += '</div></div>';
		});
		
		
		
		view.html(item);

}

function viewbottom(resp){
	if(resp!=undefined){
		var result = "";
		var view = $('#viewbuttom');
		viewbuttom.html("");
		$.each(resp.result,function(i,val){
			
			var img = "<img src='"+val.cover+"' class='img-responsive' style='width:100%' />";
			
			viewbuttom.append(img);
		});
		
		console.warn(resp.result);
		viewbuttom.attr('src',resp.result.cover);
		
	}
}

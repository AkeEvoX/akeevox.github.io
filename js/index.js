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

function viewtop(resp)
{
	if(resp!=undefined){

		var view = $('#viewtop');
		var viewindex = $('#index-carousel');
		var result = "";
		view.html("");
	
		console.warn(resp.result);
		$.each(resp.result,function(i,val){
			
			if(result==""){
				result += '<div class="item active"> ';
				viewindex.append('<li data-target="#myCarousel" data-slide-to="'+i+'" class="active"></li>');
			}
			else{
				
				result += '<div class="item"> ';
				viewindex.append('<li data-target="#myCarousel" data-slide-to="'+i+'" ></li>');
			}
				
			
			 result += '<img src="'+val.cover+'" style="width:100%" >';
			 result += '<div class="container">&nbsp;</div>';
			 result += '</div></div>';
		});
		
		
		
		view.html(result);



	}
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

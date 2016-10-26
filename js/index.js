/*dropdown menu*/
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});

$(function(){
	$('.tree-toggle').parent().children('ul.tree').toggle(200);
});

function showtopconver()
{
	var endpoint = "services/home.php";
	var method = "GET";
	var args = {'_':new Date().getHours(),'type':'top'};

 utility.service(endpoint,method,args,viewtop,null);

}

function viewtop(resp)
{
	if(resp!=undefined){

		var view = $('#viewtop');
		var result = "";
		view.html("");
		/*
		<div class="item active"> <img src="http://lorempixel.com/1200/500/sports" style="width:100%" alt="First slide">
			<div class="container">
			</div>
		</div>
		*/
		console.warn(resp.result);
		$.each(resp.result,function(i,val){
			 result += '<div class="item"> <img src="'+val.cover+'" style="width:100%" >';
			 result += '<div class="container"></div>';
			 result += '</div>';
		});

		view.html(result);



	}
}

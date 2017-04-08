
var chart = {};

chart.reset = function(){
	$('#preview_th').attr('src','../../images/common/unavaliable.jpg');
	$('#preview_en').attr('src','../../images/common/unavaliable.jpg');
}

chart.edit = function(args){

	var endpoint = "services/chart.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		console.debug(data);
		var response = JSON.parse(data);
		alert(response.result);
		chart.load();
	});
	
}

chart.load = function(){
	var endpoint = "services/chart.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'info'};
	utility.service(endpoint,method,args,set_view);
}

function set_view(data){
	console.log(data);
	
	if(data.result==undefined) return;
	
	$('#preview_th').attr('src',data.result.chart_th);
	$('#preview_en').attr('src',data.result.chart_en);
	
}


var map = {};

map.reset = function(){
	$('#image').attr('src','../../images/common/unavaliable.jpg');
}

map.edit = function(args){

	var endpoint = "services/map.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		console.debug(data);
		var response = JSON.parse(data);
		alert(response.result);
		map.load();
	});
	
}

map.load = function(){
	
	var endpoint = "services/map.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'info'};
	utility.service(endpoint,method,args,set_view);
	
}

function set_view(data){
	console.log(data);
	
	if(data.result==undefined) return;
	
	$('#image').attr('src',data.result.link);
	
}

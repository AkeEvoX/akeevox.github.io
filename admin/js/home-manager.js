
 var home = {};

home.reset = function(){
	
	$('#title_th').val('');
	$('#title_en').val('');
	$('#link_th').val('');
	$('#link_en').val('');
	$('#detail_th').summernote('reset');
	$('#detail_en').summernote('reset');
}

home.edit_landing = function(args){

	var endpoint = "services/home.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		home.load_landing();
	});
	
}

home.edit_banner = function(args){

	var endpoint = "services/home.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		home.load_banner();
	});
	
}

home.load = function(){
	var endpoint = "services/home.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'intro'};
	utility.service(endpoint,method,args,view_info);
}

home.load_landing = function(){
	
	var endpoint = "services/home.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'landing'};
	utility.service(endpoint,method,args,view_intro);
	
}

home.load_banner = function(){
	console.log("call banner info.");
	var endpoint = "services/home.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'banner'};
	utility.service(endpoint,method,args,view_banner);
	
}

function view_intro(data){
	
	//console.log(data);
	
	if(data.result==undefined) return;
	
	home.data = data.result;
	console.log(home.data["intro.cover"].en);
	$('#image').attr('src',"../"+home.data["intro.cover"].en);
	
	console.log("enable="+home.data["intro.enable"].en);
	if(home.data["intro.enable"].en=="1")
		$('#active').prop('checked',true);
	
}

function view_info(data){
	
	console.log(data);
	if(data.result==undefined) return;
	
	home.data = data.result;
	
	$('#intro_th').summernote('code',home.data["index.top_detail"].th );
	$('#series_th').summernote('code',home.data["index.series.detail"].th);
	$('#intro_en').summernote('code',home.data["index.top_detail"].en );
	$('#series_en').summernote('code',home.data["index.series.detail"].en);
	
}

function view_banner(data){
	
	console.log("load view banner info.");
	console.log(data);
	if(data.result==undefined) return;
	
	//home.data = data.result;
	
	$.each(data.result,function(id,val){
		console.debug('id='+val.id);
		var enable = val.active =="1" ? true : false;
		$('#image'+val.id).attr('src',val.cover);
		$('#active'+val.id).prop('checked',enable);
	});
	
	console.log("load view banner info complete.");
}

//update data and image
// /*http://stackoverflow.com/questions/10899384/uploading-both-data-and-files-in-one-form-using-ajax*/
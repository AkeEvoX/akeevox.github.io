
var about = {};

about.reset = function(){
	$('#title_th').val('');
	$('#title_en').val('');
	$('#link_th').val('');
	$('#link_en').val('');
	$('#detail_th').summernote('reset');
	$('#detail_en').summernote('reset');
}

about.edit = function(){
	
	var id = $('#about_id').val(); 
	var title_th = $('#title_th').val();
	var title_en = $('#title_en').val();
	var detail_th = $('#detail_th').summernote('code');
	var detail_en = $('#detail_en').summernote('code');
	var link_th = $('#link_th').val();
	var link_en = $('#link_en').val();
	
	var endpoint = "services/about.php";
	var method = "POST";
	var args =  {'_':new Date().getMilliseconds()
	,'type':'edit'
	,'id':id
	,'title_th':title_th
	,'title_en':title_en
	,'link_th':link_th
	,'link_en':link_en
	,'detail_th':detail_th
	,'detail_en':detail_en};
	
	utility.service(endpoint,method,args,function(data){
		console.debug(data);
		alert(data.result);
	});
	
}

about.load = function(){
	var endpoint = "services/about.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'info'};
	utility.service(endpoint,method,args,set_view);
}

function set_view(data){
	console.log(data);
	
	if(data.result==undefined) return;
		
	$('#about_id').val(data.result.id);
	$('#title_th').val(data.result.title_th);
	$('#title_en').val(data.result.title_en);
	$('#link_th').val(data.result.link_th);
	$('#link_en').val(data.result.link_en);
	$('#detail_th').summernote('code',data.result.detail_th);
	$('#detail_en').summernote('code',data.result.detail_en);
}

//update data and image
/*http://stackoverflow.com/questions/10899384/uploading-both-data-and-files-in-one-form-using-ajax*/
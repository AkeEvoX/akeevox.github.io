
var personal = {};

personal.add = function(args){
	
	
	var endpoint = "services/personal.php";
	var method = "POST";
	//var args =  {'_':new Date().getMilliseconds(),'type':'add','th':$('#form_th').serialize()};
	
	
	//var args =  {'_':new Date().getMilliseconds(),'data':data};
	utility.service(endpoint,method,args,function(data){
		console.debug(data);
	});
	//utility.uploads(endpoint,args,function(data){
		//console.debug(data);
		//alert(data.result);
	//});
	
	/*
	,'th': {'name':$('#name_th').val() , 'position':$('#position_th').val(), 'education':$('#education_th').val() ,'work':$('#work_th').val() }
	,'en': {'name':$('#name_en').val() , 'position':$('#position_en').val(), 'education':$('#education_en').val() ,'work':$('#work_en').val() }
	*/
	
	//console.log(args);
	
	
}

personal.reset = function(){
	$('#title_th').val('');
	$('#title_en').val('');
	$('#detail_th').summernote('reset');
	$('#detail_en').summernote('reset');
}

personal.edit_page = function(){

	personal.data["org.title"].th = $('#title_th').val();
	personal.data["org.title"].en = $('#title_en').val();
	personal.data["org.header"].th = $('#detail_th').summernote('code')
	personal.data["org.header"].en = $('#detail_en').summernote('code')
	console.log(personal.data);
	
	var endpoint = "services/personal.php";
	var method = "POST";
	
	var args =  {'_':new Date().getMilliseconds()
	,'type':'edit_page'
	,'item': personal.data};
	
	utility.service(endpoint,method,args,function(data){
		console.debug(data);
		alert(data.result);
	});
	
}

personal.load = function(){
	
	var endpoint = "services/personal.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'page'};
	utility.service(endpoint,method,args,set_view);
	
}

personal.list = function(){
	var endpoint = "services/personal.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'list'};
	utility.service(endpoint,method,args,set_view_list);
}

personal.upload = function(args){
	
	var endpoint = "services/upload_img_personal.php";
	
	utility.uploads(endpoint,args,function(){
		alert('upload success');
	});
	
}
function set_view(data){
	
	console.log(data);
	
	if(data.result==undefined) return;
	
	//var item = data.result;
	
	personal.data = data.result;
	
	$('#title_th').val(personal.data["org.title"].th);
	$('#title_en').val(personal.data["org.title"].en);
	$('#detail_th').summernote('code',personal.data["org.header"].th);
	$('#detail_en').summernote('code',personal.data["org.header"].en);
}

function set_view_list(data){
	console.debug(data);
	var view = $('#data_list');
	var item = "";
	if(data.result==undefined || data.result=="") {
		console.log("personal-list > list :: data not found.")
		return;
	}
	
	$.each(data.result,function(i,val){
		item+="<tr id='row"+val.id+"'>";
		item+="<td><input type='checkbox' name='mark' data-id='"+val.id+"' /></td>";
		item+="<td>"+val.id+"</td>";
		item+="<td>"+val.name_th+"</td>";
		item+="<td>"+val.name_en+"</td>";
		item+="<td><button class='btn btn-warning btn-sm'>แก้ไข</button></td>";
		item+="</tr>";
	});
	
	view.append(item);
}

//update data and image
/*http://stackoverflow.com/questions/10899384/uploading-both-data-and-files-in-one-form-using-ajax*/
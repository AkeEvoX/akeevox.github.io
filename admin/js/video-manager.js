
var video = {};

video.add = function(args){
	
	var endpoint = "services/video.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('video-manager.html');
	});

}

video.edit = function(args){
	
	var endpoint = "services/video.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('video-manager.html');
	});

}


video.delete = function(){
	
	console.log('call delete');
	var endpoint = "services/video.php";
	var method = "POST";
	var args = "";
	 $('input[name="mark[]"]:checked').each(function(){
		 
		 var id = $(this).attr('data-id');
		 
		 args =  {'_':new Date().getMilliseconds(),'type':'del' , 'id':id};
		 utility.service(endpoint,method,args,function(){
			$('#row'+id).remove();	 
		 });
		 
		 console.log('delete id='+id);
	 });
	 
	 alert('delete success.');
	 //personal.list();
}


video.reset = function(){
	$('#title_th').val('');
	$('#title_en').val('');
	$('#detail_th').summernote('reset');
	$('#detail_en').summernote('reset');
}

video.edit_page = function(){

	video.data["org.title"].th = $('#title_th').val();
	video.data["org.title"].en = $('#title_en').val();
	video.data["org.header"].th = $('#detail_th').summernote('code')
	video.data["org.header"].en = $('#detail_en').summernote('code')
	console.log(video.data);
	
	var endpoint = "services/video.php";
	var method = "POST";
	
	var args =  {'_':new Date().getMilliseconds()
	,'type':'edit_page'
	,'item': video.data};
	
	utility.service(endpoint,method,args,function(data){
		console.debug(data);
		alert(data.result);
	});
	
}

video.loaditem = function(id){
	
	$('#id').val(id);
	var endpoint = "services/video.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item','id':id};
	utility.service(endpoint,method,args,set_view_item);
	
}

video.load = function(){
	
	var endpoint = "services/video.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'page'};
	utility.service(endpoint,method,args,set_view);
	
}

video.loadlist = function(){
	var endpoint = "services/video.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'list' ,'couter':$('#counter').val(),'fetch':'20'  };
	utility.service(endpoint,method,args,set_view_list);
}

function set_view(data){
	
	console.log(data);
	
	if(data.result==undefined) return;
	
	//var item = data.result;
	
	video.data = data.result;
	
	$('#title_th').val(personal.data["org.title"].th);
	$('#title_en').val(personal.data["org.title"].en);
	
}

function set_view_item(data){
	
	console.log(data);
	//if(data.result==undefined) return;
	
	$('#title_th').val(data.result.title_th);
	$('#title_en').val(data.result.title_en);
	$('#link').val(data.result.link);
	
	$('#preview').attr('src',"../"+data.result.thumbnail);
	
	if(data.result["active"]=="1")
		$('#active').prop('checked',true);
	
	
}

function set_view_list(data){
	//console.debug(data);
	var view = $('#data_list');
	var item = "";
	if(data.result==undefined || data.result=="") {
		console.log("video-manager > list :: data not found.")
		return;
	}
	
	var max_item = $('#counter').val();
	
	$.each(data.result,function(i,val){
		var param = '?id='+val.id;
		var active = val.active == "1" ? "<span class='btn btn-success btn-sm'>Enable</span> ": "<span class='btn btn-danger btn-sm'>Disable</span>";
		var date = val.update_date == null ? val.create_date : val.update_date ; 
		item+="<tr id='row"+val.id+"'>";
		item+="<td><input type='checkbox' name='mark[]' data-id='"+val.id+"' /></td>";
		item+="<td>"+val.id+"</td>";
		item+="<td>"+val.title_th+"</td>";
		item+="<td>"+date+"</td>";
		item+="<td>"+ active +"</td>";
		item+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('video-edit.html','"+param+"') >แก้ไข</span></td>";
		item+="</tr>";
		max_item++;
	});
	$('#counter').val(max_item);
	view.append(item);
}

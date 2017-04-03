
var gallery = {};

gallery.add = function(args){
	
	var endpoint = "services/gallery.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('gallery-manager.html');
	});

}

gallery.add_multiple = function(args){
	
	var endpoint = "services/gallery.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		
		var response = JSON.parse(data);
		console.debug(response);
		$('#result').css('display','none');
		alert(response.result);
		control.pagetab('gallery-manager.html');
	});

} 

gallery.add_album = function(args){
	
	var endpoint = "services/gallery.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('gallery-album-manager.html');
	});

}

gallery.edit = function(args){
	
	var endpoint = "services/gallery.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('gallery-manager.html');
	});

}

gallery.edit_album = function(args){
	
	var endpoint = "services/gallery.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('gallery-album-manager.html');
	});

}

gallery.delete = function(){
	
	console.log('call delete');
	var endpoint = "services/gallery.php";
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
	 
	 alert('DELETE SUCCESS.');
	 gallery.loadlist();
}

gallery.delete_album = function(){
	
	console.log('call delete');
	var endpoint = "services/gallery.php";
	var method = "POST";
	var args = "";
	 $('input[name="mark[]"]:checked').each(function(){
		 
		 var id = $(this).attr('data-id');
		 
		 args =  {'_':new Date().getMilliseconds(),'type':'del_album' , 'id':id};
		 utility.service(endpoint,method,args,function(){
			$('#row'+id).remove();	 
		 });
		 
		 console.log('delete id='+id);
	 });
	 
	 alert('DELETE SUCCESS.');
	 //gallery.loadlistalbum();
}

gallery.reset = function(){
	
	$('#title_th').val('');
	$('#title_en').val('');
}

gallery.edit_page = function(){

	gallery.data["org.title"].th = $('#title_th').val();
	gallery.data["org.title"].en = $('#title_en').val();
	gallery.data["org.header"].th = $('#detail_th').summernote('code')
	gallery.data["org.header"].en = $('#detail_en').summernote('code')
	console.log(gallery.data);
	
	var endpoint = "services/gallery.php";
	var method = "POST";
	
	var args =  {'_':new Date().getMilliseconds()
	,'type':'edit_page'
	,'item': gallery.data};
	
	utility.service(endpoint,method,args,function(data){
		console.debug(data);
		alert(data.result);
	});
	
}

gallery.loaditem = function(id){
	
	$('#id').val(id);
	var endpoint = "services/gallery.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item','id':id};
	utility.service(endpoint,method,args,set_view_item);
	
}

gallery.load_item_album = function(id){
	
	$('#id').val(id);
	var endpoint = "services/gallery.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item_album','id':id};
	utility.service(endpoint,method,args,set_view_item_album);
	
}

gallery.load = function(){
	
	var endpoint = "services/gallery.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'page'};
	utility.service(endpoint,method,args,set_view);
	
}

gallery.loadlist = function(){
	var endpoint = "services/gallery.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'list' ,'couter':$('#counter').val(),'fetch':'20'  };
	utility.service(endpoint,method,args,set_view_list);
}

gallery.loadlistalbum = function(){
	var endpoint = "services/gallery.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'list_album' ,'couter':$('#counter').val(),'fetch':'20'  };
	utility.service(endpoint,method,args,set_view_list_album);
}

gallery.album_option = function(){
	
	var endpoint = "services/gallery.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'album_option' };
	utility.service(endpoint,method,args,set_view_album_option);
	
}

function set_view(data){
	
	console.log(data);
	
	if(data.result==undefined) return;
	
	//var item = data.result;
	
	gallery.data = data.result;
	
	$('#title_th').val(personal.data["org.title"].th);
	$('#title_en').val(personal.data["org.title"].en);
	$('#detail_th').summernote('code',personal.data["org.header"].th);
	$('#detail_en').summernote('code',personal.data["org.header"].en);
}

function set_view_item(data){
	
	if(data.result==undefined) return;
	
	
	$('#title_th').val(data.result.title_th);
	$('#title_en').val(data.result.title_en);
	$('#album_type').val(data.result.album_id);
	$('#preview').attr('src',"../"+data.result.thumbnail);
	
	if(data.result["active"]=="1")
		$('#active').prop('checked',true);
	
	
	
}


function set_view_item_album(data){
	
	if(data.result==undefined) return;
	
	
	$('#title_th').val(data.result.title_th);
	$('#title_en').val(data.result.title_en);
	
	$('#preview').attr('src',"../"+data.result.cover);
	
	if(data.result["active"]=="1")
		$('#active').prop('checked',true);
	
	
}

function set_view_list(data){
	//console.debug(data);
	var view = $('#data_list');
	var item = "";
	if(data.result==undefined || data.result=="") {
		console.log("gallery-manager > list :: data not found.")
		return;
	}
	var max_item = $('#counter').val();
	$.each(data.result,function(i,val){
		var param = '?id='+val.id;
		var active = val.active == "1" ? "<span class='btn btn-success btn-sm'>Enable</span> ": "<span class='btn btn-danger btn-sm'>Disable</span>";
		var date = val.update_date == null ? val.create_date : val.update_date;
		
		item+="<tr id='row"+val.id+"'>";
		item+="<td><input type='checkbox' name='mark[]' data-id='"+val.id+"' /></td>";
		item+="<td>"+val.id+"</td>";
		item+="<td><img src='../"+val.thumbnail+"' class='img-responsive' /></td>";
		item+="<td>"+val.album_th+"</td>";
		item+="<td>"+date+"</td>";
		item+="<td>"+ active +"</td>";
		item+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('gallery-edit.html','"+param+"') >แก้ไข</span></td>";
		item+="</tr>";
		max_item++;
	});
	$('#counter').val(max_item);
	view.append(item);
}

function set_view_list_album(data){
	//console.debug(data);
	var view = $('#data_list');
	var item = "";
	if(data.result==undefined || data.result=="") {
		console.log("gallery-manager > list :: data not found.")
		return;
	}
	var max_item = $('#counter').val();
	$.each(data.result,function(i,val){
		var param = '?id='+val.id;
		var active = val.active == "1" ? "<span class='btn btn-success btn-sm'>Enable</span> ": "<span class='btn btn-danger btn-sm'>Disable</span>";
		
		item+="<tr id='row"+val.id+"'>";
		item+="<td><input type='checkbox' name='mark[]' data-id='"+val.id+"' /></td>";
		item+="<td>"+val.id+"</td>";
		item+="<td>"+val.title_th+"</td>";
		item+="<td>"+val.create_date+"</td>";
		item+="<td>"+ active +"</td>";
		item+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('gallery-album-edit.html','"+param+"') >แก้ไข</span></td>";
		item+="</tr>";
		max_item++;
	});
	$('#counter').val(max_item);
	view.append(item);
}

function set_view_album_option(data){
	
	var view = $('#album_type');
	var item = "";
	if(data.result==undefined || data.result=="") {
		console.log("gallery-manager > list :: data not found.")
		return;
	}
	
	$.each(data.result,function(i,val){
		item+="<option value='"+val.id+"'>"+val.title_th+" / "+val.title_en+"</option>";
	});
	
	view.append(item);
}



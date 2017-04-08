
var contact = {};

contact.add = function(args){
	
	var endpoint = "services/contact.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('contact-manager.html');
	});

}

contact.edit = function(args){
	
	var endpoint = "services/contact.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('contact-manager.html');
	});

}

contact.delete = function(){
	
	console.log('call delete');
	var endpoint = "services/contact.php";
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

contact.reset = function(){
	$('#title_th').val('');
	$('#title_en').val('');
	$('#location_th').val('');
	$('#location_en').val('');
}

contact.edit_page = function(){

	contact.data["org.title"].th = $('#title_th').val();
	contact.data["org.title"].en = $('#title_en').val();
	contact.data["org.header"].th = $('#detail_th').summernote('code')
	contact.data["org.header"].en = $('#detail_en').summernote('code')
	console.log(contact.data);
	
	var endpoint = "services/contact.php";
	var method = "POST";
	
	var args =  {'_':new Date().getMilliseconds()
	,'type':'edit_page'
	,'item': contact.data};
	
	utility.service(endpoint,method,args,function(data){
		console.debug(data);
		alert(data.result);
	});
	
}

contact.loadoptions = function(id){
	
	$('#id').val(id);
	var endpoint = "services/contact.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'option'};
	utility.service(endpoint,method,args,set_view_option);
	
}

contact.loaditem = function(id){
	
	$('#id').val(id);
	var endpoint = "services/contact.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item','id':id};
	utility.service(endpoint,method,args,set_view_item);
	
}

contact.load = function(){
	
	var endpoint = "services/contact.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'page'};
	utility.service(endpoint,method,args,set_view);
	
}

contact.loadlist = function(){
	var endpoint = "services/contact.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'list' ,'couter':$('#counter').val(),'fetch':'20' };
	utility.service(endpoint,method,args,set_view_list);
}

function set_view(data){
	
	console.log(data);
	
	if(data.result==undefined) return;
	
	//var item = data.result;
	
	contact.data = data.result;
	
	$('#title_th').val(personal.data["org.title"].th);
	$('#title_en').val(personal.data["org.title"].en);
	$('#detail_th').summernote('code',personal.data["org.header"].th);
	$('#detail_en').summernote('code',personal.data["org.header"].en);
}

function set_view_item(data){
	
	console.log(data);
	
	if(data.result==undefined) return;
	
	$('#contact_type').val(data.result.type);
	$('#title_th').val(data.result.title_th);
	$('#title_en').val(data.result.title_en);
	$('#link').val(data.result.link);
	if(data.result.icon != "" && data.result.icon != undefined)
	{
		$('#preview').attr('style','display:block;');
		$('#preview').attr('src',"../"+data.result.icon);
	}
	if(data.result.type==4){
		$('#file_upload').attr('disabled',false);
		$('#link').attr('disabled',false);	
	}
	
	
	if(data.result["active"]=="1")
		$('#active').prop('checked',true);
	
}

function set_view_list(data){
	
	
	var view = $('#data_list');
	var item = "";
	if(data.result==undefined || data.result=="") {
		console.log("contact-manager > list :: data not found.");
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
		item+="<td>"+val.type+"</td>";
		item+="<td>"+ active +"</td>";
		item+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('contact-edit.html','"+param+"') >แก้ไข</span></td>";
		item+="</tr>";
		max_item++;
	});
	$('#counter').val(max_item);
	view.append(item);
}

function set_view_option(data){
	
	console.log(data);
	var view = $('#contact_type');
	view.html('');
	var item = "";
	if(data.result==undefined || data.result=="") {
		console.log("contact-manager > list option :: data not found.");
		return;
	}
	
	$.each(data.result,function(i,val){
		item += "<option value='"+val.id+"'>"+val.name+"</option>";
	});
	
	view.append(item);
}

//item = "<option value='"+parent[0].id+"'>"+parent[0].title+"</option>";
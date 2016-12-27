
var award = {};

award.add = function(args){
	
	var endpoint = "services/award.php";
	var method = "POST";

	utility.data(endpoint,method,args,function(data){
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('award-manager.html');
	});
	
}

award.edit = function(args){
	
	var endpoint = "services/award.php";
	var method = "POST";
	
	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('award-manager.html');
	});
	
}

award.delete = function(){
	console.log('call delete');
	var endpoint = "services/award.php";
	var method = "POST";
	var args = "";
	 $('input[name="mark[]"]:checked').each(function(){
		 
		 var id = $(this).attr('data-id');
		 args =  {'_':new Date().getMilliseconds(),'type':'del' , 'id':id};
		 utility.service(endpoint,method,args);
		 $('#row'+id).remove();
		 console.log('id='+id);
		 
	 });
	 alert('DELETE SUCCESS.');
	 //award.loadlist();
}

award.loadlist = function(){
	//$('#data_list').html('');
	console.log('call list award.');
	var endpoint = "services/award.php";
	var method = "GET";
	//var args = {'_':new Date().getMilliseconds(),'type':'list'};
	var args = {'_':new Date().getMinutes(),'type':'list','couter':$('#counter').val(),'fetch':'20'};
	utility.service(endpoint,method,args,view_list_award);
	
}

award.loaditem = function(id){
	$('#id').val(id);
	var endpoint = "services/award.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item','id':id};
	utility.service(endpoint,method,args,view_item);
}

function view_item(data){
	
	if(data.result==undefined || data.result=="") {
		console.log("award-manager > item award :: data not found.");
		return;
	}
	
	 $('#title_th').val(data.result.title_th);
	 $('#title_en').val(data.result.title_en);
	 $('#detail_th').summernote('code',data.result.detail_th);
	 $('#detail_en').summernote('code',data.result.detail_en);
	 $('#contury_th').val(data.result.contury_th);
	 $('#contury_en').val(data.result.contury_en);
	
	 $('#thumbnail').attr('src',data.result.thumbnail);
	
	 $('input[name="islocal"][value="'+data.result.islocal+'"]').prop('checked',true);
	
	 if(data.result.active=="1")
		 $('#active').prop('checked',true);
	
}

function view_list_award(data){
	
	var view = $('#data_list');
	var item = "";
	
	if(data.result==undefined || data.result=="") {
		console.log("award-manager > list award :: data not found.")
		return;
	}
	var max_item = $('#counter').val();
	
	$.each(data.result,function(i,val){
		
		var param = '?id='+val.id;
		var active = val.active == "1" ? "<span class='btn btn-success btn-sm'>Enable</span> ": "<span class='btn btn-danger btn-sm'>Disable</span>";
		
		item+="<tr id='row"+val.id+"' >";
		item+="<td><input type='checkbox' name='mark[]' data-id='"+val.id+"' /></td>";
		item+="<td>"+val.id+"</td>";
		item+="<td>"+val.title_th+"</td>";
		item+="<td>"+val.title_en+"</td>";
		item+="<td>"+active+"</td>";
		item+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('award-edit.html','"+param+"') >แก้ไข</span></td>";
		item+="</tr>";

		max_item++;
	});
	
	$('#counter').val(max_item);
	view.append(item);
}

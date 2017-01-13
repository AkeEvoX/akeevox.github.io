
var showroom = {};

showroom.add = function(args){
	
	var endpoint = "services/showroom.php";
	var method = "POST";
	
	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('showroom-manager.html');
	});
	
}

series.add_product = function(args){
	
	var endpoint = "services/showroom.php";
	var method = "POST";
	
	
	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('showroom-products.html',"?id="+$('#id').val());
	});
	
}

showroom.edit = function(args){
	
	var endpoint = "services/showroom.php";
	var method = "POST";
	
	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('showroom-manager.html');
	});
	
}

showroom.delete = function(){
	console.log('delete showroom');
	var endpoint = "services/showroom.php";
	var method = "POST";
	var args = "";
	 $('input[name="mark[]"]:checked').each(function(){
		 
		 var id = $(this).attr('data-id');
		 args =  {'_':new Date().getMilliseconds(),'type':'del' , 'id':id};
		 utility.service(endpoint,method,args);
		 $('#row'+id).remove();
		 console.log('id='+id);
	 });
	 alert('delete success.');
	 //cate.loadlist();
}

series.delete_product = function(){
	console.log('delete product showroom');
	var endpoint = "services/showroom.php";
	var method = "POST";
	var args = "";
	 $('input[name="mark[]"]:checked').each(function(){
		 
		 var id = $(this).attr('data-id');
		 args =  {'_':new Date().getMilliseconds(),'type':'del_pro' , 'id':id};
		 utility.service(endpoint,method,args);
		 $('#row'+id).remove();
		 console.log('id='+id);
	 });
	 alert('delete success.');
}

showroom.loadlist = function(){
	//$('#data_list').html('');
	console.log('call list showroom.');
	var endpoint = "services/showroom.php";
	var method = "GET";
	var args = {'_':new Date().getMinutes(),'type':'list','couter':$('#counter').val(),'fetch':'20'};
	utility.service(endpoint,method,args,view_list_showroom);
	
}

showroom.loaditem = function(id){
	$('#id').val(id);
	var endpoint = "services/showroom.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item','id':id};
	utility.service(endpoint,method,args,set_item_showroom);
}

function view_list_showroom(data){
	
	var view = $('#data_list');
	var item = "";
	console.log(data);
	if(data.result==undefined || data.result=="") {
		console.log("showroom-manager > list showroom :: data not found.");
		return;
	}
	var max_item = $('#counter').val();
	
	$.each(data.result,function(i,val){
		
		var param = '?id='+val.id;
		item+="<tr id='row"+val.id+"'>";
		item+="<td><input type='checkbox' name='mark[]' data-id='"+val.id+"' /></td>";
		item+="<td>"+val.id+"</td>";
		item+="<td>"+val.title_th+"</td>";
		item+="<td>"+val.title_en+"</td>";
		item+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('showroom-edit.html','"+param+"') >แก้ไข</span></td>";
		item+="</tr>";

		max_item++;
	});
	
	$('#counter').val(max_item);
	view.append(item);
}

function set_item_showroom(data){
	console.log(data);
	
	if(data.result==undefined || data.result=="") {
		console.log("showroom-manager > list product :: data not found.")
		return;
	}
	
	$('#title_th').val(data.result.title_th);
	$('#title_en').val(data.result.title_en);
	$('#detail_th').summernote('code',data.result.title_th);
	$('#detail_en').summernote('code',data.result.title_th);
	$('#preview_th').attr('src',"../"+data.result.cover_th);
	$('#preview_en').attr('src',"../"+data.result.cover_en);
	
	
	if(data.result.active=="1")
		$('#active').prop('checked',true);
	
}

function view_showroom_product(data){
	
	var view = $('#data_list');
	var item = "";
	console.log(data);
	
	if(data.result==undefined || data.result=="") {
		console.log("showroom-manager > showroom list product :: data not found.");
		return;
	}
	
	$.each(data.result,function(i,val){
		
		var param = '?id='+val.id;
		item+="<tr id='row"+val.id+"'>";
		item+="<td><input type='checkbox' name='mark[]' data-id='"+val.id+"' /></td>";
		item+="<td>"+val.pro_id+"</td>";
		item+="<td>"+val.product_en+"</td>";
		item+="<td ><img src='../"+val.thumb+"' class='img-responsive' onerror=this.src='../../images/common/unavaliable.jpg'  ></td>";
		item+="</tr>";
	
	});
	view.append(item);
}
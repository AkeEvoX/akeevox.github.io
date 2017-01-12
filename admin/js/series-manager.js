
var series = {};

series.add = function(args){
	
	var endpoint = "services/series.php";
	var method = "POST";
	
	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('series-manager.html');
	});
	
}

series.add_product = function(args){
	
	var endpoint = "services/series.php";
	var method = "POST";
	
	
	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('series-products.html',"?id="+$('#id').val());
	});
	
}

series.edit = function(args){
	
	var endpoint = "services/series.php";
	var method = "POST";
	
	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('series-manager.html');
	});
	
}

series.delete = function(){
	console.log('delete series');
	var endpoint = "services/series.php";
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
	console.log('delete product series');
	var endpoint = "services/series.php";
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

series.loadlist = function(){

	console.log('call list series.');
	var endpoint = "services/series.php";
	var method = "GET";

	var args = {'_':new Date().getMinutes(),'type':'list','couter':$('#counter').val(),'fetch':'20'};
	utility.service(endpoint,method,args,view_list_series);
	
}

series.productlist = function(id){
	$('#id').val(id);
	console.log('call list series.');
	var endpoint = "services/series.php";
	var method = "GET";

	var args = {'_':new Date().getMinutes(),'type':'list_product' ,'id':id};
	utility.service(endpoint,method,args,view_series_product);
}

series.loaditem = function(id){
	$('#id').val(id);
	var endpoint = "services/series.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item','id':id};
	utility.service(endpoint,method,args,set_item_series);
}

function view_list_series(data){
	
	var view = $('#data_list');
	var item = "";
	console.log(data);
	if(data.result==undefined || data.result=="") {
		console.log("series-manager > list product :: data not found.")
		return;
	}
	var max_item = $('#counter').val();
	
	$.each(data.result,function(i,val){
		var active = val.active == "1" ? "<span class='btn btn-success btn-sm'>Enable</span> ": "<span class='btn btn-danger btn-sm'>Disable</span>";
		var param = '?id='+val.id;
		item+="<tr id='row"+val.id+"'>";
		item+="<td><input type='checkbox' name='mark[]' data-id='"+val.id+"' /></td>";
		item+="<td>"+val.id+"</td>";
		item+="<td>"+val.title_th+"</td>";
		item+="<td>"+val.title_en+"</td>";
		item+="<td>"+active+"</td>";
		item+="<td><span class='btn btn-primary btn-sm' onclick=control.pagetab('series-products.html','"+param+"') >สินค้า</span></td>";
		item+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('series-edit.html','"+param+"') >แก้ไข</span></td>";
		item+="</tr>";

		max_item++;
	});
	
	$('#counter').val(max_item);
	view.append(item);
}

function set_item_series(data){
	console.log(data);
	
	if(data.result==undefined || data.result=="") {
		console.log("series-manager > list product :: data not found.")
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
//remove
function view_series_product(data){
	
	var view = $('#data_list');
	var item = "";
	console.log(data);
	
	if(data.result==undefined || data.result=="") {
		console.log("series-manager > series list product :: data not found.");
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

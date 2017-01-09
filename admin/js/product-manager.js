
var product = {};

product.add = function(args){
	
	// var cate_th = $('#cate_th').val();
	// var cate_en = $('#cate_en').val();
	// var parent = $('#cate_id option:selected');
	//alert('hello - ' + cate_th);
	//console.debug("cate add :: "+cate_th+";"+cate_en+";"+parent.val());
	
	var endpoint = "services/product.php";
	var method = "POST";
	// var args =  {'_':new Date().getMilliseconds()
	// ,'type':'add'
	// ,'parent':parent.val()
	// ,'th':cate_th
	// ,'en':cate_en};
	
	utility.data(endpoint,method,args,function(data){
		console.debug(data);
		alert(data.result);
		control.pagetab('category-manager.html');
	});
	
}

product.edit = function(){
	
	var id = utility.querystr("id",$('#parameter').val()); 
	var cate_th = $('#cate_th').val();
	var cate_en = $('#cate_en').val();
	var parent = $('#cate_id option:selected');
	//alert('hello - ' + cate_th);
	//console.debug("cate add :: "+cate_th+";"+cate_en+";"+parent.val());
	
	var endpoint = "services/category.php";
	var method = "POST";
	var args =  {'_':new Date().getMilliseconds()
	,'type':'edit'
	,'id':id
	,'parent':parent.val()
	,'th':cate_th
	,'en':cate_en};
	
	utility.service(endpoint,method,args,function(data){
		console.debug(data);
		alert(data.result);
		control.pagetab('category-manager.html');
	});
	
}

product.delete = function(){
	console.log('call delete');
	var endpoint = "services/category.php";
	var method = "POST";
	var args = "";
	 $('input[name="mark[]"]:checked').each(function(){
		 
		 var id = $(this).attr('data-id');
		 args =  {'_':new Date().getMilliseconds(),'type':'del' , 'id':id};
		 utility.service(endpoint,method,args);
		 //$('#row'+id).remove();
		 console.log('id='+id);
	 });
	 alert('delete success.');
	 cate.loadlist();
}

product.loadlist = function(){
	//$('#data_list').html('');
	console.log('call list product.');
	var endpoint = "services/product.php";
	var method = "GET";
	//var args = {'_':new Date().getMilliseconds(),'type':'list'};
	var args = {'_':new Date().getMinutes(),'type':'list','couter':$('#counter').val(),'fetch':'20'};
	utility.service(endpoint,method,args,view_list_product);
	
}

product.loadoptions= function(select_id){
	console.log('call option='+select_id);
	var endpoint = "services/category.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'option'};
	
	utility.service(endpoint,method,args,function (data){
		viewmenulist(data,select_id);
	});
	
}

product.loaditem = function(id){
	var endpoint = "services/category.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item','id':id};
	utility.service(endpoint,method,args,set_item);
}

function view_list_product(data){
	
	var view = $('#data_list');
	var item = "";
	console.log(data);
	if(data.result==undefined || data.result=="") {
		console.log("product-manager > list product :: data not found.")
		return;
	}
	var max_item = $('#counter').val();
	
	$.each(data.result,function(i,val){
		
		var active = val.active == "1" ? "<span class='btn btn-success btn-sm'>Enable</span> ": "<span class='btn btn-danger btn-sm'>Disable</span>";
		
		var param = '?id='+val.id;
		item+="<tr id='row"+val.id+"'>";
		item+="<td><input type='checkbox' name='mark[]' data-id='"+val.id+"' /></td>";
		item+="<td>"+val.id+"</td>";
		item+="<td>"+val.category+"</td>";
		item+="<td>"+val.title+"</td>";
		item+="<td>"+active+"</td>";
		item+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('product-edit.html','"+param+"') >แก้ไข</span></td>";
		item+="</tr>";

		max_item++;
	});
	
	$('#counter').val(max_item);
	view.append(item);
}

function set_item(data){
	console.log(data);
	$('#cate_th').val(data.result.title_th);
	$('#cate_en').val(data.result.title_en);
	var parentid = data.result.parent;
	cate.loadoptions(parentid);
}
//remove
function set_list_product(id,title,category,thumb){
	
	var result = "";
	var param = '?id='+id;
	result+="<tr id='row"+id+"'>";
	result+="<td><input type='checkbox' name='mark[]' data-id='"+id+"' /></td>";
	result+="<td>"+id+"</td>";
	result+="<td>"+category+"</td>";
	result+="<td>"+title+"</td>";
	result+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('product-edit.html','"+param+"') >แก้ไข</span></td>";
	result+="</tr>";
	
	return result;
}


function viewmenulist(data,select_id){
	
	var catelist = $('#cate_id');
	catelist.html('');
	
	if(data.result==undefined) {
		console.log("category-manager > list menu  :: data not found.")
		return;
	}
	
	var parent = data.result.filter(function(item){ return item.parent=="0" && item.id=="1";  });/*categories*/
	var item = "";
	
	var child = data.result.filter(function(item){ return item.parent==1; });
	item = "<option value='"+parent[0].id+"'>"+parent[0].title+"</option>";
	item += viewchildmenu(child,data,true,"",select_id);
	
	catelist.append(item);	
}


function viewchildmenu(child,data,directory,lastmenu,select_id){
	var item = "";
	$.each(child,function(i,val){
		
		var subchild = data.result.filter(function(item){ return item.parent==val.id; });
		var link = val.link+val.id;
		
		if(subchild.length!=0){
	
			if(directory==true) lastmenu = lastmenu + "&emsp;";
			
			item += "<option value='"+val.id+"' ";
			if(val.id==select_id) item += "selected";
			item += ">"+lastmenu+val.title+"</option>";
			
			
			directory = true;
			item += viewchildmenu(subchild,data,directory,lastmenu,select_id);
			directory=false;
		}else{
			
			var title = val.title;
			
			if(directory==true) {
				title = lastmenu + "&emsp;"+title;	
			}
			else {
				title = lastmenu + title;	
			}
			
			item += "<option value='"+val.id+"' ";
			if(val.id==select_id) item += "selected";
			item += ">"+title+"</option>";
			
		}
		
	});
	
	return item;
}

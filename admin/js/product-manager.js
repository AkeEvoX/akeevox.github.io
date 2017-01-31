
var product = {};

product.add = function(args){
	var endpoint = "services/product.php";
	var method = "POST";

	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('product-manager.html');
	});
	
}

product.add_color =  function(id,color_id){
	var endpoint = "services/product.php";
	var method = "GET";
	var args = {"_":new Date().getMilliseconds(),"type":"add_color" , "id":id ,"color_id":color_id };
	utility.service(endpoint,method,args,function(data){
		// #reload product color;
		product.load_product_color(id);
	});
	
}

product.add_photo =  function(args){
	var endpoint = "services/product.php";
	var method = "GET";
	var proid = args.get('proid');
	console.log('object photo of pro id =' + proid);
	
	utility.data(endpoint,method,args,function(data){
		//#reload product color;
		product.load_product_photo(proid);
	});
	
}

product.edit = function(args){
	
	var endpoint = "services/product.php";
	var method = "POST";
	
	
	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('product-manager.html');
	});
	
}

product.delete = function(){
	console.log('call delete');
	var endpoint = "services/product.php";
	var method = "POST";
	var args = "";
	 $('input[name="mark[]"]:checked').each(function(){
		 
		 var id = $(this).attr('data-id');
		 args =  {'_':new Date().getMilliseconds(),'type':'del' , 'id':id};
		 utility.service(endpoint,method,args);
		 $('#row'+id).remove();
		 console.log('delete id='+id);
	 });
	 alert('delete success.');
	 //product.loadlist();
}

product.del_color =  function(id,color_id){
	
	if(confirm('Confirm Delete ?')){		
		var endpoint = "services/product.php";
		var method = "GET";
		var args = {"_":new Date().getMilliseconds() ,"type":"del_color", "id":id,"color_id":color_id};
		utility.service(endpoint,method,args,function(data){
			//#reload product color;
			product.load_product_color(id);
		});
	}
	
}

product.del_photo =  function(id,photo_id){
	
	if(confirm('Confirm Delete ?')){
		var endpoint = "services/product.php";
		var method = "GET";
		var args = {"_":new Date().getMilliseconds() ,"type":"del_photo", "id":id,"photo_id":photo_id};
		utility.service(endpoint,method,args,function(data){
			//#reload product color;
			product.load_product_photo(id);
		});
	}
	
}

product.loadlist = function(search){
	console.log('call list product.');
	var endpoint = "services/product.php";
	var method = "GET";
	var args = {'_':new Date().getMinutes(),'type':'list','couter':$('#counter').val(),'fetch':'20','search_text':search};
	utility.service(endpoint,method,args,view_list_product);
	
}

product.loadoptions= function(select_id){
	
	console.log('call option='+select_id);
	var endpoint = "services/category.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'option'};
	
	utility.service(endpoint,method,args,function (data){
		opt_viewmenulist(data,select_id);
	});
	
}

product.option = function(cate_id){
	
	var endpoint = "services/product.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'list_products','id':cate_id};
	
	utility.service(endpoint,method,args,view_product_option);
	
}

product.loaditem = function(id){
	
	$('#id').val(id);
	$('#proid').val(id);
	var endpoint = "services/product.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item','id':id};
	utility.service(endpoint,method,args,set_item_product);
	
	//#load product color list;
	this.load_product_color(id);
	//#load product gallery;
	this.load_product_photo(id);
}

product.load_product_color = function(id){
	var endpoint = "services/product.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'product_color' ,'id':id };
	utility.service(endpoint,method,args,view_list_color);
}

product.load_product_photo = function(id){
	var endpoint = "services/product.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'product_photo' ,'id':id };
	utility.service(endpoint,method,args,view_list_photo);
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
		item+="<td>"+val.code+"</td>";
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

function view_list_color(data){
	
	var list = $('#product_color');
	var item = "";
	list.html('');
	console.log("view_list_color");
	console.log(data);
	if(data.result==undefined || data.result=="") {
		console.log("product-manager > list product :: data not found.");
		return;
	}

	$.each(data.result,function(i,val){

		item += "<li class='list-group-item' ><span id='"+val.id+"' style='cursor:pointer;' onclick=product.del_color("+val.proid+","+val.id+"); class='glyphicon glyphicon-remove' ></span> ";
		item += "<img src='../"+val.thumb+"' > ";
		item += val.title_en;
		item += "</li> ";

	});

	list.append(item);

}

function view_list_photo(data){
	
	var list = $('#product_photo');
	var item = "";
	list.html('');
	console.log("view_list_photo");
	console.log(data);
	if(data.result==undefined || data.result=="") {
		console.log("product-manager > list product photo :: data not found.");
		return;
	}

	$.each(data.result,function(i,val){
		item += "<div class='col-xs-6 col-md-4' style='width:30%;height:250px;'>";
		item += "<div class='border-circle remove-item' onclick=product.del_photo("+val.proid+","+val.id+"); ><span class='glyphicon glyphicon-remove' ></span></div>";// rowspan pull-right
		item += "<img src='../"+val.thumb+"' style='max-width:200px;' class='img-thumbnail' >";
		item += "</div>";
	});

	list.append(item);

}



function view_product_option(data){
	
	var view = $('#pro_id');
	view.html('');
	var item = "";
	if(data.result==undefined) {
		console.log("category-manager > list menu  :: data not found.");
		return;
	}
	
	$.each(data.result,function(i,val){
		
		item += "<option value='"+val.id+"'>"+val.title_en+"</option>";
		
	});
	view.append(item);
	
}

function set_item_product(data){
	console.log(data);
	
	if(data.result==undefined || data.result=="") {
		console.log("product-manager > product :: data not found.")
		return;
	}
	
	product.loadoptions(data.result.typeid);
	
	$('#preview_thumb').attr('src',"../"+data.result.thumb);	
	$('#preview_symbol').attr('src',"../"+data.result.symbol_file);
	$('#preview_plan').attr('src',"../"+data.result.plan);
	$('#link_dwg').attr('href',"../"+data.result.dwg_file);
	$('#link_pdf').attr('href',"../"+data.result.pdf_file);
	
	if(data.result.active=="1")
		$('#active').prop('checked',true);
	
	$('#code_th').val(data.result["prod.code"].th);
	$('#name_th').val(data.result["prod.name"].th);
	$('#type_th').val(data.result["prod.type"].th);
	$('#size_th').val(data.result["prod.size"].th);
	$('#shape_th').val(data.result["prod.shape"].th);
	$('#seat_th').val(data.result["prod.seat"].th);
	$('#outlet_th').val(data.result["prod.outlet"].th);
	$('#rough_th').val(data.result["prod.rough"].th);
	$('#systems_th').val(data.result["prod.systems"].th);
	$('#comsumption_th').val(data.result["prod.comsumption"].th);
	$('#faucet_th').val(data.result["prod.faucet"].th);
	$('#overflow_th').val(data.result["prod.overflow"].th);

	$('#code_en').val(data.result["prod.code"].en);
	$('#name_en').val(data.result["prod.name"].en);
	$('#type_en').val(data.result["prod.type"].en);
	$('#size_en').val(data.result["prod.size"].en);
	$('#shape_en').val(data.result["prod.shape"].en);
	$('#seat_en').val(data.result["prod.seat"].en);
	$('#outlet_en').val(data.result["prod.outlet"].en);
	$('#rough_en').val(data.result["prod.rough"].en);
	$('#systems_en').val(data.result["prod.systems"].en);
	$('#comsumption_en').val(data.result["prod.comsumption"].en);
	$('#faucet_en').val(data.result["prod.faucet"].en);
	$('#overflow_en').val(data.result["prod.overflow"].en);

}

function opt_viewmenulist(data,select_id){
	
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
	item += opt_viewchildmenu(child,data,true,"",select_id);
	
	catelist.append(item);	
}

function opt_viewchildmenu(child,data,directory,lastmenu,select_id){
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
			item += opt_viewchildmenu(subchild,data,directory,lastmenu,select_id);
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


function rewritetext(text){
	var result = text;
	
	result = result.replace("'","\'");
	result = result.replace("%","");
	result = result.replace(",","");
	result = result.replace("_","");
	result = result.replace("(","");
	result = result.replace(")","");
	result = result.replace("[","");
	result = result.replace("]","");
	return result;
	
}
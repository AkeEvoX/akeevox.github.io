
var color = {};

color.add = function(args){
	
	try{
		
		var endpoint = "services/color.php";
		var method = "POST";

		console.log("call insert color");
		console.log(args);
	
		utility.data(endpoint,method,args,function(data){
			console.debug(data);
			var response = JSON.parse(data);
			alert(response.result);
			control.pagetab('color-manager.html');
		});
	
	}catch(err){
		
		 var vDebug = ""; 
			for (var prop in err) 
			{  
			   vDebug += "property: "+ prop+ " value: ["+ err[prop]+ "]\n"; 
			} 
			vDebug += "toString(): " + " value: [" + err.toString() + "]"; 
		
		alert('insert error : ' +vDebug );
	}
	
}

color.edit = function(args){
	
	var endpoint = "services/color.php";
	var method = "POST";
	
	utility.data(endpoint,method,args,function(data){
		console.debug(data);
		var response = JSON.parse(data);
		alert(response.result);
		control.pagetab('color-manager.html');
	});
	
}

color.delete = function(){
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

color.loadlist = function(){
	console.log('call list color.');
	var endpoint = "services/color.php";
	var method = "GET";
	var args = {'_':new Date().getMinutes(),'type':'list','couter':$('#counter').val(),'fetch':'20'};
	utility.service(endpoint,method,args,view_list);
	
}

color.loadoptions= function(){
	//console.log('call option='+select_id);
	var endpoint = "services/color.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'option'};
	
	utility.service(endpoint,method,args,function (data){
		view_option_list(data);
	});
	
}

color.loaditem = function(id){
	$('#id').val(id);
	var endpoint = "services/color.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item','id':id};
	utility.service(endpoint,method,args,set_item);
}

function view_list(data){
	
	var view = $('#data_list');
	var item = "";
	console.log(data);
	if(data.result==undefined || data.result=="") {
		console.log("color-manager > list product :: data not found.")
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
		item+="<td><img src='"+val.thumb+"' width='32' height='32' /></td>";
		item+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('color-edit.html','"+param+"') >แก้ไข</span></td>";
		item+="</tr>";

		max_item++;
	});
	
	$('#counter').val(max_item);
	view.append(item);
}

function set_item(data){
	console.log(data);
	$('#title_th').val(data.result.title_th);
	$('#title_en').val(data.result.title_en);
	$('#image').attr('src',data.result.thumb);
	
	 if(data.result.active=="1")
		 $('#active').prop('checked',true);
	
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

function view_option_list(data){
	
	var list = $('#color_list');
	var item = "";
	list.html('');
	
	if(data.result==undefined) {
		console.log("color-manager > list color  :: data not found.")
		return;
	}
	//https://thdoan.github.io/bootstrap-select/examples.html
	
	$.each(data.result,function(i,val){
		//console.log(val.thumb);
		item += "<option data-thumbnail='"+val.thumb+"' value='"+val.id+"'>"+val.title_en+" | "+val.title_th+"</option>";
	});
	
	list.append(item);	
}

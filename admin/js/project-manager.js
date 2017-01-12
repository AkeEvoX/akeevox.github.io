
var project = {};

project.add = function(args){
	
	var endpoint = "services/project.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('project-manager.html');
	});

}

project.edit = function(args){
	
	var endpoint = "services/project.php";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('project-manager.html');
	});

}


project.delete = function(){
	
	console.log('call delete');
	var endpoint = "services/project.php";
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
}


project.reset = function(){
	$('#title_th').val('');
	$('#title_en').val('');
	$('#location_th').val('');
	$('#location_en').val('');
}

project.edit_page = function(){

	project.data["org.title"].th = $('#title_th').val();
	project.data["org.title"].en = $('#title_en').val();
	project.data["org.header"].th = $('#detail_th').summernote('code')
	project.data["org.header"].en = $('#detail_en').summernote('code')
	console.log(project.data);
	
	var endpoint = "services/project.php";
	var method = "POST";
	
	var args =  {'_':new Date().getMilliseconds()
	,'type':'edit_page'
	,'item': project.data};
	
	utility.service(endpoint,method,args,function(data){
		console.debug(data);
		alert(data.result);
	});
	
}

project.loaditem = function(id){
	
	$('#id').val(id);
	var endpoint = "services/project.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item','id':id};
	utility.service(endpoint,method,args,set_view_item);
	
}

project.load = function(){
	
	var endpoint = "services/project.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'page'};
	utility.service(endpoint,method,args,set_view);
	
}

project.loadlist = function(){
	var endpoint = "services/project.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'list','couter':$('#counter').val(),'fetch':'20'};
	utility.service(endpoint,method,args,set_view_list);
}

function set_view(data){
	
	console.log(data);
	
	if(data.result==undefined) return;
	
	//var item = data.result;
	
	project.data = data.result;
	
	$('#title_th').val(personal.data["org.title"].th);
	$('#title_en').val(personal.data["org.title"].en);
	$('#detail_th').summernote('code',personal.data["org.header"].th);
	$('#detail_en').summernote('code',personal.data["org.header"].en);
}

function set_view_item(data){
	
	console.log(data);
	
	if(data.result==undefined) return;
	
	$('#title_th').val(data.result.title_th);
	$('#title_en').val(data.result.title_en);
	$('#location_th').val(data.result.location_th);
	$('#location_en').val(data.result.location_en);
	
	var $radio = $('input[name=islocal][value='+data.result.islocal+']').prop('checked',true);
	
	if(data.result["active"]=="1")
		$('#active').prop('checked',true);
	
	
}

function set_view_list(data){
	//console.debug(data);
	var view = $('#data_list');
	var item = "";
	if(data.result==undefined || data.result=="") {
		console.log("project-manager > list :: data not found.")
		return;
	}
	
	var max_item = $('#counter').val();
	
	$.each(data.result,function(i,val){
		var param = '?id='+val.id;
		var active = val.active == "1" ? "<span class='btn btn-success btn-sm'>Enable</span> ": "<span class='btn btn-danger btn-sm'>Disable</span>";
		var islocal = val.islocal =="0" ? "ภายในประเทศ" : "ภายนอกประเทศ";
		
		
		item+="<tr id='row"+val.id+"'>";
		item+="<td><input type='checkbox' name='mark[]' data-id='"+val.id+"' /></td>";
		item+="<td>"+val.id+"</td>";
		item+="<td>"+val.title_th+"</td>";
		item+="<td>"+islocal+"</td>";
		item+="<td>"+ active +"</td>";
		item+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('project-edit.html','"+param+"') >แก้ไข</span></td>";
		item+="</tr>";
		
		max_item++;
		
	});
	$('#counter').val(max_item);
	//console.debug(item);
	view.append(item);
}


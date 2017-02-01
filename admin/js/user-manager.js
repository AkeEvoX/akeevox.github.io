
var user = {};

user.add = function(args){
	
	var endpoint = "services/user.php";
	var method = "POST";
	
	//validate information
	if(validate(args) != true){
		return false;
	}
	
	utility.data(endpoint,method,args,function(data){
		
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('user-manager.html');
	});
	
}

user.edit = function(args){
	
	var endpoint = "services/user.php";
	var method = "POST";
	
	
	//validate information
	if(validate(args) != true){
		return false;
	}
	
	
	utility.data(endpoint,method,args,function(data){
		var response = JSON.parse(data);
		console.debug(response);
		alert(response.result);
		control.pagetab('user-manager.html');
	});
	
}

user.delete = function(){
	console.log('call delete');
	var endpoint = "services/user.php";
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
	 //user.loadlist();
}

user.loadlist = function(){
	console.log('call list user.');
	var endpoint = "services/user.php";
	var method = "GET";
	var args = {'_':new Date().getMinutes(),'type':'list','couter':$('#counter').val(),'fetch':'20'};
	utility.service(endpoint,method,args,view_list_user);
	
}

user.loaditem = function(id){
	$('#id').val(id);
	var endpoint = "services/user.php";
	var method = "GET";
	var args = {'_':new Date().getMilliseconds(),'type':'item','id':id};
	utility.service(endpoint,method,args,view_item);
}

function validate(args){
	if(args.get("firstname")=="")
	{
		alert("please enter firstname !!");
		return false;
	}
	if(args.get("lastname")=="")
	{
		alert("please enter lastname !!");
		return false;
	}
	if(args.get("user_name")=="")
	{
		alert("please enter username !!");
		return false;
	}
	switch(args.get("type")){
		case "add":
			if(args.get("pass_word")=="")
			{
				alert("please enter password !!");
				return false;
			}
	
			if(args.get("conf_pass_word")=="")
			{
				alert("please enter confirm password !!");
				return false;
			}
			
			if(args.get("pass_word") != args.get("conf_pass_word")){
				alert("password is not match !!!");
				return false;
			}
			
		break;
		case "edit":
		
			if(args.get("pass_word") !="" &&  args.get("conf_pass_word") !=""){
		
				if(args.get("pass_word") != args.get("conf_pass_word")){
					alert("password is not match !!!");
					return false;
				}
		
			}
		
		break;
	}

	return true;
	
}

function view_item(data){
	
	if(data.result==undefined || data.result=="") {
		console.log("award-manager > item award :: data not found.");
		return;
	}
	
	 $('#firstname').val(data.result.firstname);
	 $('#lastname').val(data.result.lastname);
	 $('#user_name').val(data.result.user_name);
	
	 $('input[name="role_type"][value="'+data.result.role_id+'"]').prop('checked',true);
	
	 if(data.result.active=="1")
		 $('#active').prop('checked',true);
	
}

function view_list_user(data){
	
	var view = $('#data_list');
	var item = "";
	
	if(data.result==undefined || data.result=="") {
		console.log("user-manager > list user :: data not found.")
		return;
	}
	var max_item = $('#counter').val();
	
	$.each(data.result,function(i,val){
		
		var param = '?id='+val.id;
		var active = val.active == "1" ? "<span class='btn btn-success btn-sm'>Enable</span> ": "<span class='btn btn-danger btn-sm'>Disable</span>";
		
		item+="<tr id='row"+val.id+"' >";
		item+="<td><input type='checkbox' name='mark[]' data-id='"+val.id+"' /></td>";
		item+="<td>"+val.id+"</td>";
		item+="<td>"+val.fullname+"</td>";
		item+="<td>"+val.role_name+"</td>";
		item+="<td>"+active+"</td>";
		item+="<td><span class='btn btn-warning btn-sm' onclick=control.pagetab('user-edit.html','"+param+"') >แก้ไข</span></td>";
		item+="</tr>";

		max_item++;
	});
	
	$('#counter').val(max_item);
	view.append(item);
}


var authen = {};

authen.login = function(args){
	var endpoint = "services/authentication.php?type=authen";
	var method='post';

	utility.data(endpoint,method,args,function(data){
		console.warn(data);
		var response = JSON.parse(data);
		console.log(response);
		if(response.result=='success'){
			window.location = response.redirect;
		}
		else {
			alert(response.result);
		}

	});
}

authen.access_verify = function(){
	var endpoint = "services/authentication.php?type=verify";
	var method='get';
	utility.service(endpoint,method,null,function(data){
		
		if(data.result.message=="fail"){
			alert("you not have authorization.");
			window.location = data.redirect;
		}
		else{
			$('#page_center').attr("style","display:block;");
			if(data.result.role!="admin"){
				$('#privilage').remove();
			}
			$('#login_name').html("Login : "+data.result.login_name+" ");
			
		}
		
	});
}

authen.logout = function(){
	
	var endpoint = "services/authentication.php?type=logout";
	var method='get';
	utility.service(endpoint,method);
	
}


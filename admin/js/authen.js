
var authen = {};

authen.login = function(args){
	var endpoint = "services/authentication.php?type=authen";
	var method='post';

	utility.data(endpoint,method,args,function(data){
		
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
			//$('#page_center').attr("style","display:none;");
			alert("you not have authorization.");
			window.location = data.redirect;
		}
		else{
			$('#page_center').attr("style","display:block;");
			
			if(data.result.role!="admin"){
				//var page = "<li role='presentation'><a class='menutab'  data-page='admin-tab.html'   href='#admin' data-toggle='tab'>Admin</a></li>";
				$('#privilage').remove();
			}
			
		}
		
	});
}

authen.logout = function(){
	
	var endpoint = "services/authentication.php?type=logout";
	var method='get';
	utility.service(endpoint,method);
	
}

/* function authentication (args){

	var endpoint = "services/authentication.php?type=authen";
	var method='post';

	utility.data(endpoint,method,args,function(data){
		
		var response = JSON.parse(data);
		console.log(response);
		if(response.result=='success'){
			window.location = response.redirect;
		}
		else {
			alert(response.result);
		}

	});
} */

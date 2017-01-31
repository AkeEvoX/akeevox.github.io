function authentication (args){

	var endpoing = "services/authentication.php";
	var method='post';

	utility.data(endpoing,method,args,function(data){
		console.log(data);
		var response = JSON.parse(data);

		if(response.result=='success'){
			alert(response.result);
			//window.location = "center.html";
		}
		else {
			alert(response.result);
		}

	});
}
$(document).ready(function(){
	showintro();
});

function showintro(){

	var endpoint = "services/attributes.php";
	var method ="get";
	var args = {'_':new Date().getHours(),'type':'intro'};
	utility.service(endpoint,method,args,checkintro);
}

function checkintro(resp){

	if(resp.result!=undefined){

		var intro = utility.convertToObject(resp.result);
		console.log(intro['intro.enable']);
		if(intro['intro.enable']=="1"){
			getintro(intro['intro.cover']);
		}
		else{
			window.location.href = 'index.html';
		}


	}


}

function getintro(url){
	$('#cover').attr('src',url);
}

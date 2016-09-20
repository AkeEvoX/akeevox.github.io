$(document).ready(function(){
	loadcontact();
});

function loadcontact(){

	$.ajax({
		url:'http://dev33.ddns.net:8888/startsanitaryware/services/contact.php?_=31312&callback=?',
		type:'GET',
		dataType:'json',
		success:function(data){
			setaddress(data.result.address);
			setphone(data.result.phone);
			setemail(data.result.email);
		},
		error:function(xhr,status,err){
			alert(xhr.responseText);
		}
	});

}

function setaddress(address)
{
	$('#address').html("");
	$.each(address,function(i,val){
		if(val!="")
			$('#address').append( "<li>"+val+"</li>" );
	});
}

function setphone(phone)
{

	$('#phone').html("");
	$.each(phone,function(i,val){
		if(val!='')
			$('#phone').append("<li>"+val+"</li>");
	});
	
}

function setemail(email)
{
	$('#email').html("");
	$.each(email,function(i,val){
		if(val!='')
		$('#email').append("<li>"+val+"</li>");
	});
}

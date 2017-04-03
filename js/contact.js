function loadcontact(){

	$.ajax({
		url:'services/contact.php',
		type:'get',
		dataType:'json',
		success:function(data){
			//console.log(data);
			//fillter data to generate item
			//require utility.js
			var addrs = data.result.filter( item=> item.type=="address" );
			var emails = data.result.filter( item=> item.type=="email" );
			var phones = data.result.filter( item=> item.type=="phone" );
			var map = data.result.filter( item=> item.type=="map" );

			setaddress(addrs);
			setphone(phones);
			setemail(emails);
			setmap(map);
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
		if(val.title!="")
			$('#address').append( "<li>"+val.title+"</li>" );
	});
}

function setphone(phone)
{

	$('#phone').html("");
	$.each(phone,function(i,val){
		if(val.title!=''){
			var phone = val.title;
			phone = utility.replace(phone," ","");
			phone = utility.replace(phone,"(",""); 
			phone =  utility.replace(phone,")","");
			phone =  utility.replace(phone,"-","");
			$('#phone').append("<li><a href='tel:+"+phone+"' style='color:#a58b5d;text-decoration:none;'>"+val.title+"</a></li>");
		}
			
	});

}

function setemail(email)
{
	$('#email').html("");
	$.each(email,function(i,val){
		if(val.title!='')
		$('#email').append("<li><a href='mailto:"+val.title+"' style='text-decoration: none;color:#a58b5d;' >"+val.title+"<a/></li>");
	});
}

function setmap(map)
{
	console.log(map);
	$('#map').attr('src',map[0].title);
}

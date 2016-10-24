$(document).ready(function(){

var name = utility.querystr('name');
find(name);

$('#btnfind').click(function(){
	var name = $('#txtfind').val();
	 find(name);
});

$('#txtfind').keyup(function(e){
		if(e.keyCode == 13)
		{
			var name = $('#txtfind').val();
			 find(name);
		}
});

});

function find(name)
{

 var endpoint = "services/dealer.php";
 var args = {'_':new Date().getMilliseconds(),'name':name};

	utility.service(endpoint,'GET',args,setview,null);

	//$('#listview').html();
}

function setview(resp)
{
	try{
	 if(resp.result!=undefined)
	 {
		 	var result = "";

		  $.each(resp.result,function(i,val){
					result += "<tr>";
					result += "<td class='col-md-4' >"+val.title+"</td>";
					result += "<td class='col-md-2'>"+val.province+"</td>";
					result += "<td class='col-md-2'>"+val.zone+"</td>";
					result += "<td class='col-md-2'>"+val.mobile+"</td>";
					result += "</tr>";
			});
	 }
	 else { result = "";}

	 $('#listview').html(result);
 	}
	catch(err)
	{
		 console.error(err);
	}

}

$(document).ready(function(){

//var name = utility.querystr('name');
//find(name);

$('#btnfind').click(function(){
	$('#fetch').val(0);
	$('#listview').find("tr:gt(0)").remove();
	 find();
});

$('#txtfind').keyup(function(e){
		
	 var code = (e.keyCode || e.which);

	// do nothing if it's an arrow key
	if(code == 37 || code == 38 || code == 39 || code == 40) {
		return;
	}
	$('#fetch').val(0);
	$('#listview').find("tr:gt(0)").remove();
	find();
});

});

function find()
{

	var text = rewritetext($('#txtfind').val());
	var fetch = $('#fetch').val();
	var limit = 15;
	var endpoint = "services/search_product.php";
	var args = {'_':new Date().getMilliseconds()
	,'search':text
	,'fetch':fetch
	,'limit':limit
	};

	utility.service(endpoint,'GET',args,setview,null);

	//$('#listview').html();
}

function rewritetext(text){
	var result = text;
	
	result = result.replace("'","\'");
	result = result.replace("%","");
	result = result.replace(",","");
	result = result.replace("_","");
	result = result.replace("(","");
	result = result.replace(")","");
	result = result.replace("[","");
	result = result.replace("]","");
	return result;
	
}

function setview(resp)
{
	
	try{
		
	
	var result = "";
	 if(resp.result!=undefined)
	 {
		var max_item = $('#fetch').val();
		  $.each(resp.result,function(i,val){
					result += "<tr>";
					result += "<td class='col-md-2' >"+val.code+"</td>";
					result += "<td class='col-md-3'>"+val.name+"</td>";
					result += "<td class='col-md-2'>"+val.type+"</td>";
					result += "<td class='col-md-2'>"+val.category+"</td>";
					result += "<td class='col-md-2'>"+val.size+"</td>";
					result += "</tr>";
					max_item++;
			});
			
			$('#fetch').val(max_item);
	 }
	 else { 
	 
		var rowCount = $('#listview tr').length;
		
		if(rowCount==1){
			result += "<tr>"; 
			result += "<td class='col-md-12 text-center' colspan='5'>"; 
			result += "Data Not Found."; 
			result += "</td>"; 
			result += "</tr>"; 
		}
	}

	 $('#listview').append(result);
 	}
	catch(err)
	{
		 console.error(err);
	}

}

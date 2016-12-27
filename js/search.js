$(document).ready(function(){

//var name = utility.querystr('name');
//find(name);

$('#btnfind').click(function(){
	$('#fetch').val(0);
	$('#listview').find("tr:gt(0)").remove();
	 find();
});

$('#txtfind').keyup(function(e){
		if(e.keyCode == 13)
		{
			//var name = $('#txtfind').val();
			$('#fetch').val(0);
			$('#listview').find("tr:gt(0)").remove();
			 find();
		}
});

});

function find()
{

	var text = $('#txtfind').val();
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
					result += "<td class='col-md-2'>"+val.systems+"</td>";
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

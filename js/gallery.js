function loadList()
{
	var service = 'services/gallery.php' ;
	var args = {"_": new Date().getHours()}
	utility.service(service,'GET',args,setview);
}

function LoadItem(id)
{
	var service = 'services/gallery.php' ;
	var args = {"_": new Date().getHours(),"id":id}
	utility.service(service,'GET',args,setviewdetail);
}


function setview(data)
{
	$('#list').html("");
	$.each(data.result,function(i,val){

		var itemview = "";
		itemview += "<a class='item' href='#' onclick=utility.modalimage(null,'"+val.thumbnail+"'); ><img src='"+val.thumbnail+"' class='img-responsive' /></a>";
		$('#list').append(itemview);
	});

	 $('.photoGrid').photoGrid({rowHeight:"250"});

}

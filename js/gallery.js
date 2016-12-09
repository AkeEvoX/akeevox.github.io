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
		console.log(val.image);
		var itemview = "";
		itemview += "<a class='item' href='javascript:void(0);' onclick=utility.modalimage(null,'"+val.image+"'); ><img src='"+val.thumbnail+"' class='img-responsive' onerror=this.src='images/common/unavaliable.jpg'  /></a>";
		$('#list').append(itemview);
	});

	 $('.photoGrid').photoGrid({rowHeight:"250"});

}

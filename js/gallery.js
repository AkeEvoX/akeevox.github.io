function load_list_gallery(id)
{
	var service = 'services/gallery.php' ;
	var args = {"_": new Date().getHours(),"type":"list","id":id};
	utility.service(service,'GET',args,view_list_gallery);
}

function LoadItem(id)
{
	var service = 'services/gallery.php' ;
	var args = {"_": new Date().getHours(),"type":"item","id":id}
	utility.service(service,'GET',args,setviewdetail);
}

function load_album(){
	var service = 'services/gallery.php' ;
	var args = {"_": new Date().getHours(),"type":"album"};
	utility.service(service,'GET',args,view_album);
}

function view_list_gallery(data)
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

function view_album(data){
	
	var view = $('#list');
	view.html("");
	if(data.result!=undefined || data.result!=null){
		
		var item = "";
		$.each(data.result,function(i,val){
			
			item += "<div class='col-xs-12 col-sm-4 col-md-3 text-center' >";
			item += "<a href='gallery_album.html?id="+val.id+"&title="+val.title+"' alt='"+val.title+"'><img src='"+val.cover+"' class='img-thumbnail' /><a/>";
			item += "<span >"+val.title+"</span>";
			item += "</div>";
			
		});
	}
	view.append(item);
	
}
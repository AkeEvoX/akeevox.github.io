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
			//gallery_album.html?id="+val.id+"&title="+val.title+"
			item += "<div class='col-xs-12 col-sm-6 col-md-3 text-center' >";
			item += "<a href='javascript:void(0);' onclick=showgallery('"+val.id+"') alt='"+val.title+"'><img src='"+val.cover+"' class='img-responsive' /><a/>";
			item += "<span >"+val.title+"</span>";
			item += "</div>";
			
		});
	}
	view.append(item);
	
}

function showgallery(id){
	
	var view = $('#modalcontent');
	view.attr('style','height:450px;width:800px;left:60;');
	view.html('');
	var service = 'services/gallery.php' ;
	var args = {"_": new Date().getHours(),"type":"list","id":id};
	utility.service(service,'GET',args,function(data){
		
		console.log(data)
		if(data.result!=null){
			console.log('load image');
			$.each(data.result,function(i,val){
				var item = "";
				item += "<img src='"+val.image+"' data-image='"+val.image+"' onerror=this.src='images/common/unavaliable.jpg' data-description=''  />";
				view.append(item);
			});
		}
		
	},function(){ //on load complete
			
			view.unitegallery({
				
				theme_panel_position: "bottom"
				,gallery_theme: "grid"
				,slider_scale_mode: "fit"
				,thumb_fixed_size:false
				,thumb_width:100
				,thumb_height:100
				,thumb_loader_type:"light"
				,grid_num_cols:1
				,grid_num_rows:1
				,gridpanel_grid_align: "top"
				,theme_hide_panel_under_width: 800
			});
			//'height:500px;width:800px;left:60;'
			
			
			utility.showmodal();
		
	});

	
	
}


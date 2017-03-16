
$(document).ready(function(){
	
	$('#btn_print').on('click',function(){
			window.open('compares_print.html', 'sharer', 'toolbar=0, status=0, width=576, height=798');
	});
	
});

function loadviewcompare(){

	var endpoint = "services/attributes.php";
	var method='get';
	var args = {'_':new Date().getHours(),'type':'other','option':'prod'};
	utility.service(endpoint,method,args,setviewtemplete,loadproduct);
	
	utility.setpage('compare');
		
}

function setviewtemplete(data){
	
	var compare = $('#compare-slider');
	compare.html('');
	var item = "";

	item += "<li ><a href='javascript:void(0);' >";
	item += "<img src='images/common/compare.png' onerror=this.src='images/common/unavaliable.jpg' class='img-responsive' >";
	item += "<div class='lightslider-title'><label><span class='glyphicon glyphicon-stop'></span><span id='compare.category'></span></label></div>";
	item += "<ul class='lightslider-desc'>";

	$.each(data.result,function(id,val){
		item+="<li><span>"+val.value+"<span></li>";
	});
	item += "</ul>";
	item += "</a></li>";
	

	compare.append(item);
	

}

function loadproduct(){

	var endpoint = "services/compare.php";
	var method='get';
	var args = {'_':new Date().getHours(),'type':'view'};

	utility.service(endpoint,method,args,setviewitems,function(){

	
		$('#compare-slider').show();
		
		//check view mobile or desktop
		
		var maxitem = 4;
		
		//checking view mobile
		if (/Mobi/.test(navigator.userAgent)) { 
			maxitem=2;
		}
		
		$("#compare-slider").lightSlider({
			autoWidth: false
			,item:maxitem
			,adaptiveHeight:false
			,loop:false
			,keyPress:false
			,pager:false
			,slideMargin:5
			,enableTouch:true
			,enableDrag:true
			
		});
		
		
		$('.icon_close').on('click',function(){
			//alert('hello');		
			var id = $(this).attr('data-id');
			console.log("remove id = "+id);
			remove_compare(id);
		});

	});

}

function remove_compare(id){
	var endpoint = 'services/compare.php';
	var method = 'get';
	var args = {'_':new Date().getMilliseconds(),'type':'remove','id':id};
	
	utility.service(endpoint,method,args,function(){
		loadviewcompare();
		//loadproduct();
	});
}

function setviewitems(data){
	console.debug(data);
	
	if(data.result==null) return;

	var compare = $('#compare-slider');
	//compare.html("");
	var item = "";
	//for(var i =0 ; i < 5;i++){
	$.each(data.result,function(id,val){

		item += "<li ><div class='icon_close' data-id='"+val.info.id+"' ><img style='width:24px;height:24px;' src='images/common/close.png' /></div>";
		item += "<a href='#' onclick=redirect('"+val.info.id+"')>";
		item += "<img src='"+val.info.thumb+"' onerror=this.src='images/common/unavaliable.jpg' class='img-responsive' ></a>";
		item += "<div class='lightslider-title'><label><span class='glyphicon glyphicon-stop'></span>"+val.info.cate+"</label></div>";
		item += "<ul class='lightslider-desc'>";
		
		$.each(val.attrs,function(i,val_attr){

			var title = "-"

			if(val_attr.title!="")
				title = val_attr.title;

			item += "<li><span>"+title+"</span></li>";

		});
		item += "</ul>";
		item += "</li>";
	});


	compare.append(item);
	
}

function redirect(id){
	window.location.href='productdetail.html?id='+id;
}


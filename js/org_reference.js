$(document).ready(function(){
	
	loadmenu();
	loadbuttommenu();
	loadreference();
	
});

function setup_slider()
{
	
	$("#inter-slider").lightSlider({
		autoWidth: true
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
	 });

	$("#local-slider").lightSlider({
		autoWidth: true
		,adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
	 });

}

function loadreference()
{
	$.ajax({
		url:"services/organization.php",
		data:{"_": new Date().getHours() , "type":"refer"},
		dataType:'json',
		type:"GET",
		success: function(data){
			try{
				console.log(data.result);
				
				if(data.result != undefined)
				{
					var inter = data.result.filter(function(item){ return item.local=="0"; });

					
					var local = $.grep(data.result,function(value,i){
						return (value.local == "1") ;
					});
					
					console.log(inter);
					displaylocal(local);
					displayinter(inter);
				}
			}catch(err)
			{
				console.error("organization refer :" +err.message);
			}
			
		},
		error : function (xhr,status,err)
		{
			console.error("load organization reference error : " + xhr.responseText);
			alert("load organization reference error : "+ xhr.responseText);
		}
	});
}

function displayinter(data)
{
	var view = $('#inter-slider');
	var item = "";
	$.each(data,function(idx,val){
		
		item+= "<li >";
		item+= "<img src='"+val.thumbnail+"' class='img-fluid' />";
		item+= "<div class='lightslider-desc'><label>"+val.title+"</label></div>";
		item+= "</li>";
		
	});
	
	view.append(item);
	
	view.lightSlider({
		adaptiveHeight:true
	    ,loop:true
	    ,keyPress:true
	    ,autoWidth:true
	 });

}

function displaylocal(data)
{
	var view = $('#local-slider');
	var item = "";
	$.each(data,function(idx,val){
		item+= "<li>";
		item+= "<img src='"+val.thumbnail+"' class='img-responsive' />";
		item+= "<div class='lightslider-desc'><label>"+val.title+"</label></div>";
		item+= "</li>";
	});
	view.append(item);
	
	view.lightSlider({

		adaptiveHeight:true
	    ,loop:true
	    ,keyPress:false
	    ,autoWidth:true
	 });
	
}

function loadinfo()
{
	$.ajax({
		url:"services/attributes.php",
		data:{"_": new Date().getHours() , "type":"chart"},
		dataType:'json',
		type:"GET",
		success: function(data){
			
			console.log(data.result);
			
			$('#media-data img').attr('src',data.result.chart);
		},
		error : function (xhr,status,err)
		{
			console.error("load organization chart error : " + xhr.responseText);
			alert("load organization chart error : "+ xhr.responseText);
		}
	});
	
}



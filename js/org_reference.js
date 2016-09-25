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
		url:"services/organization",
		data:{"_": new Date().getHours() , "type":"refer"},
		dataType:'json',
		type:"GET",
		success: function(data){
			
			//display(data);
			//console.log(inter);
			var inter = data.result.filter(item=>item.local == "0");
			var local = data.result.filter(item=>item.local == "1");
			
			displaylocal(local);
			displayinter(inter);
			
		},
		complete:function(data){
			
			console.log("complete");
		
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
	 });
	
}

function loadinfo()
{
	$.ajax({
		url:"services/attributes",
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



/*dropdown menu*/
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});
/*  force collopse
$(function(){
$('.tree-toggle').parent().children('ul.tree').toggle(200);
})
*/

function getParameterByName(name, url) {
	
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
	
}
//-----------------load globle menu-----------------
function loadmenu(){

	$.ajax({

		url:'services/menu.php?_=' + new Date().getMilliseconds(),
		type:'GET',
		dataType:'json',
		success:function(data){
			getmenubar(data);
		},
		error:function(xhr,status,err){
			alert("generate menu error :"+xhr.responseText);
		}

	});

}

function loadchildmenu(id)
{
	var menu = $('#'+id);
	if(menu.val() ==1) return false;
	
	$.ajax({

		url:'services/menu.php?_=' + new Date().getMilliseconds(),
		type:'GET',
		data: {"id":id} ,
		dataType:'json' ,
		success:function(data){
			menu.val(1);
			getchildmenu(id,data);
		},
		error:function(xhr,status,err){
			menu.val(0);
			alert("generate child menu error :"+xhr.responseText);
		}

	});
	
}

function getmenubar(data)
{
		var menu = $('#menubar');
		menu.html("");
		$.each(data.result,function(id,val){
			
			var item = "";
			if(val.child=="0")
			{
				item = "<li id='"+val.id+"' > <a href='"+val.link+"'>"+val.name+"</a></li>";
			}
			else
			{
				item += "<li id='"+val.id+"' class='dropdown' >";
				item += "<a href='"+val.link+"' onclick=loadchildmenu("+val.id+") class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>"+val.name+"<span class='caret'/></a>";
				item +="</li> ";
			}
			menu.append(item);
		});
		
}

function getchildmenu(id,data)
{
	
	var menu = $('#'+id);

	var item = "";
	item = "<ul class='dropdown-menu'>";
	$.each(data.result,function(idx,val){
			item += "<li><a href='"+val.link+"'>"+val.name+"</a></li>";
	});
	item += "</ul>";
	menu.append(item);
}

function loadbuttommenu()
{
	$.ajax({
		url:"services/attributes.php",
		data:{"type":"menu"} ,
		dataType:'json',
		type:'GET',
		success:function(data){
			genbutton(data);
		},
		error:function(xhr,status,err){
			console.log(xhr.responseText);
			alert("load button menu error : " + xhr.responseText);
		}
		
	});
	
}

function genbutton(data)
{
	$.each(data.result,function(idx,val){ 
			$("div[id='"+val.name+ "'] label").text(val.title);
			$("div[id='"+val.name+ "']").append(val.item);
	});
}

//-----------------load globle menu-----------------


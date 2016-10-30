$(document).ready(function(){

 var url = 'services/lang.php';
 var args = {'_':new Date().getMilliseconds()};
 utility.service(url,'GET',args
 ,function(resp){
	 //console.log(resp);
	 $('span[id="nav.lang"]').text(resp.result.lang);
 }
 ,null)

  $('#find_dealer').click(function(){
    var name = $('#find_text').val();
     window.location.href = "dealer.html?name="+name+"&_=" + new Date().getMilliseconds();
  });

});

/*dropdown menu*/
/*
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});
*/
var utility = function(){};

utility.service = function(url,method,args,success_callback,complete_callback){

	$.ajax({
		url:url,
		data:args,
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		type:method,
		dataType:'json',
		success:success_callback,
		complete:complete_callback,
		error:function(xhr,status,error){

			var result = {'page':url
									,'args':args
								 ,'msg':xhr.responseText};

			console.error(result);
      alert("page="+result.page+"\nargs="+JSON.stringify(result.args)+"\nmsg="+result.msg);
		}
	});

}

utility.log = function(type,message){

	var args = {'_':new Date().getMilliseconds(),'msg':message,'type':type} ;
	this.service("services/logger.php",'POST',args,null,null);
}

utility.loadmenu = function(){
 var endpoint ="services/menu.php";
	var args = {'_':new Date().getHours()};
	this.service(endpoint,'get',args ,getmenubar ,null);
}

utility.loadbuttommenu = function(){


 console.log("load buttom menu");
 var endpoint = "services/attributes.php";
	var args = {'_':new Date().getHours(),'type':'menu'};
  this.service(endpoint,'get',args ,genbutton ,null);
}
/*
,function(response){ //success
	genbutton(response);
}
*/

utility.querystr = function(name,url){

	if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

utility.setpage = function(page){
  var endpoint = "services/attributes.php";
  var args = {'_':new Date().getHours(),'type':page};
  utility.service(endpoint,'GET',args, bindpage,null);
}

utility.modalpage = function(title,url,event){

	if(title!=null)
		$('#modaltitle').html(title);

	var d= new Date();
	$('#modalcontent').load(url,event);
	$('#modaldialog').modal('show');

}

utility.modalimage = function(title,url){

	if(title!=null)
		$('#modaltitle').html(title);

	$('.modal').on('show.bs.modal', centerModal);

	$('#modalcontent').html("<img src='"+url+"' class='img-fluid' /> ");
	$('#modaldialog').modal('show');

	$('.modal:visible').each(centerModal);

}

	function centerModal() {
	    $(this).css('display', 'block');
	    var $dialog = $(this).find(".modal-dialog");

			var imgwidth = $(this).find('.modal-body img').width();
			$dialog.css({width:imgwidth+35});

	    var offset = ($(window).height() - $dialog.height()) / 2;
	    // Center modal vertically in window
	    $dialog.css("margin-top", offset);
	}

/*
$('.modal').on('show.bs.modal', centerModal);

$(window).on("resize", function () {
    $('.modal:visible').each(centerModal);
});
*/
function bindpage(response)
{
	if(response!==undefined)
	{
		$.each(response.result,function(i,val){
			//console.log(val);
			$("span[id='"+val.name+"']").text(val.title);
		});
	}
	else { console.warn('attribute not found.'); }
}

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
/*
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
*/

function loadchildmenu(id){
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

function getmenubar(data){
		var menu = $('#menubar');
		menu.html("");

    var parent = data.result.filter(function(item){return item.parent=="0"});
    var child = data.result.filter(function(item){return item.parent!="0"});

		$.each(parent,function(id,val){

			var item = "";
      var sub = child.filter(function(item){return item.parent==val.id });

      if(sub.length==0)
      {
        item = "<li id='"+val.id+"' > <a href='"+val.link+"'>"+val.name+"</a></li>";
      }
      else {
        item = "<li id='"+val.id+"' class='dropdown' >";
				item += "<a href='"+val.link+"' onclick=loadchildmenu("+val.id+") class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>"+val.name+"</a>";

          item += "<ul class='dropdown-menu'>";
          $.each(sub,function(subid,subval){
              item += "<li><a href='"+subval.link+"'>"+subval.name+"</a></li>";
          });
          item += "</ul>";

				item +="</li> ";

      }

      //console.warn(item);
			menu.append(item);
		});

    //var inter = data.result.filter(function(item){ return item.local=="0"; });

}

function getchildmenu(id,data){

	var menu = $('#'+id);

	var item = "";
	item = "<ul class='dropdown-menu'>";
	$.each(data.result,function(idx,val){
			item += "<li><a href='"+val.link+"'>"+val.name+"</a></li>";
	});
	item += "</ul>";
	menu.append(item);
}
/*
function loadbuttommenu(){
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

}*/

function genbutton(data){
	$.each(data.result,function(idx,val){
			$("div[id='"+val.name+ "'] label").text(val.title);
			$("div[id='"+val.name+ "']").append(val.item);
	});
}



//-----------------load globle menu-----------------

<<<<<<< HEAD
$(document).ready(function(){
	loadmenu();
	loadbuttommenu();
});
=======
var Index = function(){};

Index.initial = function() {
	
//	loadmenu();
	utility.loadmenu();
	utility.loadbuttommenu();
//	loadbuttommenu();
   // return this.color + ' ' + this.type + ' apple';
};


function loadpage()
{
	var item = {'_':new Date().getHours(),'type':'index'};
	utility.service('services/attributes','GET',item
	,function (response){ //sunccess
		
		$('#title').val(response.title);
		$('#title-desc').val(response.title_desc);
		  //$.each(response,function(i,val){
			//	$('#'+val.name).val(val.title);
			//});
	}
	,null)	
	
}

>>>>>>> origin/master


/*dropdown menu*/
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});

$(function(){
	$('.tree-toggle').parent().children('ul.tree').toggle(200);
});


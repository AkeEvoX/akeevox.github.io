$(document).ready(function(){
	loadaward();
});


function loadaward(){

	var award = $('#immersive_slider');
		
	$.ajax({
		url:'services/award.php?rdm=' + new Date().getMilliseconds()
		,type:'post'
		,dataType:'text'
		,success:function(data){

			award.append(data);
			award.append("<a href='#'' class='is-prev'>&laquo;</a><a href='#'' class='is-next'>&raquo;</a>");

		}
		,error:function(xhr,status,err){

			console.log("services error " + err.message);
			alert('service error : ' + err.message);

		}
	});



}
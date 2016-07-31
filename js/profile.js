$(document).ready(function(){


	$("#standard_slide").immersive_slider({
		animation: "slide",
		container: ".main",
		loop:true,
		cssBlur:false,
		autoStart:0
	    });

	loadaward();



});


function loadaward(){

	var award = $('#immersive_slider');
		
	$.ajax({
		url:'services/award?rdm=' + new Date().getMilliseconds()
		,type:'post'
		,dataType:'text'
		,success:function(data){

			//var slide = $("<div/>").html("<div class='slide' data-blurred='' ></div>").contents();
			//var content = $("<div/>").html("<div class='content'></div>").contents();

			award.append(data);
			award.append("<a href='#'' class='is-prev'>&laquo;</a><a href='#'' class='is-next'>&raquo;</a>");

			
			$('#immersive_slider').immersive_slider({
				animation: "slide",
				container: ".main",
				loop:true,
				cssBlur:false,
				autoStart:0
		    });

		}
		,error:function(xhr,status,err){

			console.log("services error " + err.message);
			//alert('service error : ' + err.message);

		}
	});



}
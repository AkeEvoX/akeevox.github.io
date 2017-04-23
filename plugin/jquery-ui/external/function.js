// JavaScript Document
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};

//*********************************************************
function checkEmpty(id,error,message){
	if ($(id).val()==""){
		$(error).html(message);
		$(id).focus();
		return false;
	}
	$(error).html("");
	return true;
}
//*********************************************************
function checkEmail(id,error,message){
	if (isValidEmailAddress($(id).val())==false){
		$(error).html(message);
		$(id).focus();
		return false;
	}
	$(error).html("");
	return true;
}
//*********************************************************
function checkEmpty1(id,message){
	if ($(id).val()==""){
		$(id).focus();
		return message;
	}
	return "";
}
//*********************************************************
function checkEmail1(id,message){
	if (isValidEmailAddress($(id).val())==false){
		$(id).focus();
		return message;
	}
	return "";
}
//*********************************************************
function checkPassword(id1,id2,error,message){
	if ($(id1).val()!=$(id2).val()){
		$(error).html(message);
		$(id2).focus();
		return false;
	}
	$(error).html("");
	return true;
}
//*********************************************************
function checkType(id,error,message){
	var str = $(id).val()
	var arr = str.split(".");
	var lastname = arr[arr.length-1];
	lastname = lastname.toLowerCase();
	
	if (lastname != "jpg" && lastname != "jpeg" && lastname != "gif" && lastname != "png"){
		$(error).html(message);
		$(id).focus();
		return false;
	}
	$(error).html("");
	return true;
}
//*********************************************************
function getCookie(cname)
{
var name = cname + "=";
var ca = document.cookie.split(';');
for(var i=0; i<ca.length; i++)
  {
  var c = ca[i].trim();
  if (c.indexOf(name)==0) return c.substring(name.length,c.length);
  }
return "";
}
//*********************************************************
function jsDateDiff2(strDate1,strDate2){
			from = strDate1.split("-");
			date1 = new Date(from[1]+"/"+from[2]+"/"+from[0]);
			from = strDate2.split("-");
			date2 = new Date(from[1]+"/"+from[2]+"/"+from[0]);

			var one_day = 1000*60*60*24;
			var defDate = (date2.getTime() - date1.getTime()) / one_day

			// check not add in monday
			var i;
			var checkday;
			var weekend = 0;

			for (i=date1.getTime(); i<=date2.getTime(); i=i+one_day){
				checkday = new Date(i);
				if (checkday.getDay()==1)
					weekend++;
			}
						
			return defDate-weekend;
		}
//*********************************************************
function textonly(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  if (key != 8 && key != 46 &&  key != 37 && key != 39){ 
	  key = String.fromCharCode( key );
	  var regex = /[0-9]|\./;
	  if( regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	  }
  }
}
//*********************************************************
function numberonly(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  if (key != 8 && key != 46 &&  key != 37 && key != 39){ 
	  key = String.fromCharCode( key );
	  var regex = /[0-9]|\./;
	  if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	  }
  }
}
//*********************************************************
function addCommas(str){
   var arr,int,dec;
   str += '';

   arr = str.split('.');
   int = arr[0] + '';
   dec = arr.length>1?'.'+arr[1]:'';

   return int.replace(/(\d)(?=(\d{3})+$)/g,"$1,") + dec;
}
//*********************************************************
function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && ((node.type=="text") || (node.type=="password"))) {return false;}
}

//document.onkeypress = stopRKey; 
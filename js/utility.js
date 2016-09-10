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
/*dropdown menu*/
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});
/*  force collopse
$(function(){
$('.tree-toggle').parent().children('ul.tree').toggle(200);
})
*/

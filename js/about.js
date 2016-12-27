
function loadabout()
{
	var endpoint = "services/about.php";
	var method = "GET";
	var args = {"_": new Date().getHours() } ;

	utility.service(endpoint,method,args,setabout);

}

function setabout(resp)
{
	$('#title-data').html(resp.result.title);
	//$('#media-data').html(resp.result.media);
	$('#media-data').attr('src',resp.result.link);
	$('#content-data').html(resp.result.detail);
}

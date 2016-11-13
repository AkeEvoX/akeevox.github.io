
function loadabout()
{
var endpoint = "services/about.php";
var method = "GET";
var args = {"_": new Date().getHours() } ;

utility.service(endpoint,method,args,setabout,null);

}

function setabout(resp)
{
	$('#title-data').html(resp.result.title);
	$('#media-data').html(resp.result.media);
	$('#content-data').html(resp.result.detail);
}

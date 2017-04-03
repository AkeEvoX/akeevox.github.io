<?php
session_start();
include("../lib/common.php");
include("../lib/logger.php");
include("../controller/ContactManager.php");


//get attach list
$contact_list = get_contact_list_message();

$custname = $_POST["custname"];
$email_cust = $_POST["email"];
$phone = $_POST["phone"];
$desc = $_POST["desc"];

$message .= "Customer : " . $custname."<br/>";
$message .= "Phone : " . $phone."<br/>";
$message .= "Email : " . $email_cust ."<br/>";
$message .= "Detail :" .$desc;
$subject = "Feedback Starsanitaryware";

$redirect = "../contact.html";
Sendmail($redirect,$contact_list,$email_cust,$subject,$message,$custname);


function get_contact_list_message(){
	
	$result = "";
	$contact = new ContactManager();
	$data = $contact->get_list_contact_message();
	
	while($row = $data->fetch_object(){
		$result[] = array("email"=>$row->contact_to
		"alias"=>$row->contact->alias);
	}
	
	return $result;
	
}

?>
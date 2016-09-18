<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
include("../controller/ContactManager.php");
include("../lib/logger.php");
header("Content-Type: application/json;  charset=UTF8");

$contact = new ContactManager();

$data = $contact->getContact();
$row = $data->fetch_object();

$address1 = $row->address1;
$address2 = $row->address2;
$phone1 = $row->phone1;
$phone2= $row->phone2;
$phone3= $row->phone3;
$email1 = $row->email1;
$email2 = $row->email2;

$address = array($address1,$address2);
$phone = array($phone1,$phone2,$phone3);
$email= array($email1,$email2);

$result = array("address"=>$address
	,"phone"=>$phone
	,"email"=>$email
);

log_debug("get contact > " . print_r($result,true));

echo json_encode(array("result"=> $result ,"code"=>"0"));


?>
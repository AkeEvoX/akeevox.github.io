<?php
session_start();
include("../lib/common.php");

$custname = $_POST["custname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$desc = $_POST["desc"];

$message .= "Customer : " . $custname."<br/>";
$message .= "Phone : " . $phone."<br/>";
$message .= "Email : " . $email ."<br/>";
$message .= "Detail :" .$desc;
$subject = "Feedback Starsanitaryware";

$redirect = "../contact.html";
Sendmail($redirect,$email,$subject,$message,$custname);

?>
<?php 
require_once('class.phpmailer.php');
date_default_timezone_set('America/Los_Angeles');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*E_PARSE | E_WARNING | E_NOTICE , E_ALL*/

//$lang="en";

if(!isset($_SESSION["lang"]) or empty($_SESSION["lang"])){
	$_SESSION["lang"] = "en";
	$lang = $_SESSION["lang"];
} 


function SendMail($sender,$subject,$message)
{
		$mail = new PHPMailer();

		$mail->IsSMTP();

		$mail->Subject = $subject;
		$mail->MsgHTML($message);//body mail

		$mail->CharSet = "utf-8";
		$mail->Host="mail.baankunnan.com";
		$mail->SMTPAuth = false;
		$mail->IsHTML(true);
		//$mail->Username = "contact@baankunnan.com"; 
		//$mail->Password = "hmcKxJfCj"; 
		$mail->SetFrom("contact@baankunnan.com", "starsanitaryware.com");
		//$mail->AddBcc("Andamantaxis@gmail.com", "notify to admin");
		//$mail->AddReplyTo("mail@andamantaxis.com", "admin");

		$mail->AddAddress($sender); 

		//$mail->Send();
		
		if(!$mail->Send()) {
			//echo "Mailer Error: " . $mail->ErrorInfo;
			if($_SESSION["lang"]!="en")
				echo "<script>alert('ขออภัยระบบขัดข้องค่ะ');</script>";
			else 
				echo "<script>alert('Send mail Error.');</script>";
		} else {
			if($_SESSION["lang"]!="en")
				echo "<script>alert('ข้อมูลของคุณส่งเรียบร้อยแล้วค่ะ');</script>";
			else 
				echo "<script>alert('Send mail completed');</script>";
		}
}

?>

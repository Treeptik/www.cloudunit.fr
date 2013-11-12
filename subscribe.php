<?php
include_once('php-mailjet.class-mailjet-0.1.php');
include_once('class.phpmailer.php');
include_once('class.smtp.php');


$mj = new Mailjet();
$email = $_REQUEST['email'];

# Parameters
$params = array(
	'contact' => $email
	);
# Call
$response = $mj->contactInfos($params);

# Result
$contact = $response->contact;


# création de compte

# Parameters
if($contact->email == $email){
	return header("HTTP/1.0 400 Bad Request");
	exit;
}

$params = array(
	'method' => 'POST',
	'contact' => $email,
	'id' => '472522'
	);
# Call
$response = $mj->listsAddContact($params);

# Result
$contact_id = $response->contact_id;


$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'in.mailjet.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '154644e23e0a831f5d0e87554e5a8e33';                            // SMTP username
$mail->Password = '85f4801030f3296738e232935570fc50';// SMTP password
$mail->Port = 587;                           
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'support@cloudunit.fr';
$mail->FromName = 'CloudUnit Support';
$mail->addAddress($email);  // Add a recipient

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Votre inscription sur CloudUnit';
$mail->Body    = '<table cellpadding="0" cellspacing="0" border="0" style="margin: 0; border-collapse: collapse;" width="100%"><tbody><tr>
<td style="color: #444444; font-family: arial; font-size: 12px; border-color: #dddddd; background-color: #ffffff;  padding: 5px 0;" align="left">
<table style="margin: 0 0 0 10px;border-collapse:collapse;color: #444444; font-family: arial; font-size: 12px; border-color: #dddddd; background-color: #ffffff; "><tbody><tr><td width="580" style="vertical-align: top; padding: 5px 0; "><div style="padding: 6px; text-align: center;"><img alt="CloudUnit" width="242" height="46" style="display: block; margin: 0 auto;border: none;" src="https://r.mailjet.com/qyP_2R2a.png"></div></td></tr></tbody></table>
<table style="margin: 0 0 0 10px;border-collapse:collapse;color: #444444; font-family: arial; font-size: 12px; border-color: #dddddd; background-color: #ffffff; "><tbody><tr><td width="580" style="vertical-align: top; padding: 5px 0; "><table cellpadding="0" cellspacing="0" style="border-collapse:collapse;width:565px;color: #444444; font-family: arial; font-size: 12px; border-color: #dddddd; background-color: #ffffff; " width="565"><tbody><tr><td style="padding:5px 0 5px 5px; line-height:normal;"><hr style="margin: 0;display: block; height: 1px; line-height: 0; width: 100%; border: none; background-color: #505c64; "></td></tr></tbody></table></td></tr></tbody></table>
<table style="margin: 0 0 0 10px;border-collapse:collapse;color: #444444; font-family: arial; font-size: 12px; border-color: #dddddd; background-color: #ffffff; "><tbody><tr><td width="580" style="vertical-align: top; padding: 5px 0; "><table cellpadding="0" cellspacing="0" style="border-collapse:collapse;width:565px;color: #444444; font-family: arial; font-size: 12px; border-color: #dddddd; background-color: #ffffff; " width="565"><tbody><tr><td style="padding:5px 0 5px 5px;line-height:normal;color: #444444; font-family: arial; font-size: 12px; border-color: #dddddd; background-color: #ffffff; "><p style="margin: 0 0 10px;line-height: 1.3em;"><span style="font-size:14px;">Bonjour,<br><br>Cet email confirme votre inscription &agrave; <a href="http://treeptik.fr/cloudunit" style="color: #0033cc;border: none;text-decoration:none;"><span style="color:#1b95cd;">CloudUnit</span></a>.<br><br>Notre application est en cours de développement, nous vous communiquerons vos identifiants lors de sa mise en service.<br><br>Merci de votre confiance.<br><br>Cordialement,<br><br>Le service client,<br>CloudUnit</span></p></td></tr></tbody></table></td></tr></tbody></table>
</td>
			              </tr></tbody></table>';
$mail->AltBody = 'Bonjour,

Cet email confirme votre inscription &agrave; CloudUnit.

Notre application est en cours de développement, nous vous communiquerons vos identifiants lors de sa mise en service.

Merci de votre confiance.

Cordialement,

Le service client,
CloudUnit';

if(!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
	exit;
}

echo 'Message has been sent';
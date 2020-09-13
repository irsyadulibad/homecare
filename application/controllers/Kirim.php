<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'third_party/PHPMailer.php';
require APPPATH.'third_party/SMTP.php';
require APPPATH.'third_party/Exception.php';
class Kirim extends CI_Controller{
	public function index(){
		$message = 	"
          <html>
          <head>
              <title>Verification Code</title>
          </head>
          <body>
              <h2>Thank you for Registering.</h2>
              <p>Your Account:</p>
              <p>Please click the link below to activate your account.</p>
              <h4><a href='register/activate/03/1234'>Activate My Account</a></h4>
          </body>
          </html>
          ";

          $fromEmail = "fakun1034@gmail.com";
          $isiEmail = "$message";
          $mail = new PHPMailer\PHPMailer\PHPMailer();
          $mail->IsHTML(true);    // set email format to HTML
          $mail->IsSMTP();   // we are going to use SMTP
          $mail->SMTPAuth   = true; // enabled SMTP authentication
          $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
          $mail->Host       = "smtp.gmail.com";      // setting GMail as our SMTP server
          $mail->Port       = 465;                   // SMTP port to connect to GMail
          $mail->Username   = $fromEmail;  // alamat email kamu
          $mail->Password   = "tembokrejo123";            // password GMail
          $mail->SetFrom('fakun1034@gmail.com', 'noreply');  //Siapa yg mengirim email
          $mail->Subject    = "Verifikasi";
          $mail->Body       = $isiEmail;
          $toEmail = "ahmadirsyadulibad8@gmail.com"; // siapa yg menerima email ini
          $mail->AddAddress($toEmail);
         
          if(!$mail->Send()) {
              echo "Eror: ".$mail->ErrorInfo;
          }
	}
}
?>
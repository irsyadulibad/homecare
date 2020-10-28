<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'third_party/PHPMailer.php';
require APPPATH.'third_party/SMTP.php';
require APPPATH.'third_party/Exception.php';

class Register_m extends CI_Model {
  public function __construct(){
    parent::__construct();
  }

  public function do_register(){
    $data = [
      'nama_lengkap' => $this->input->post('fullname', true),
      'email' => $this->input->post('email', true),
      'jenis_kelamin' => $this->input->post('gender', true),
      'password' => sha1($this->input->post('password', true)),
      'foto' => 'default.jpg',
      'code' => $this->generate_code(),
      'active' => 0
    ];

    $send = $this->send_mail($data['email'], $data['code']);

    if($send['status']){

      $this->db->insert('pengguna', $data);
      if($this->db->affected_rows() > 0){
        return [
          'type' => 'success',
          'msg' => 'Berhasil mendaftar, Silahkan cek email aktivasi'
        ];
      }else{
        return [
          'type' => 'error',
          'msg' => 'Gagal mendaftar, silahkan coba lagi'
        ];
      }

    }else{
      return [
        'type' => 'error',
        'msg' => 'Gagal mendaftar, silahkan coba lagi'
      ];
    }

  }

  public function do_activate($email, $code){
    $this->db->update('pengguna', [
      'code' => null,
      'active' => 1
    ], [
      'email' => $email,
      'code' => $code
    ]);

    if($this->db->affected_rows() > 0){
      return [
        'type' => 'success',
        'msg' => 'Berhasil aktivasi, Silahkan login'
      ];
    }else{
      return [
        'type' => 'error',
        'msg' => 'Email atau kode aktivasi salah'
      ];
    }

  }

  private function send_mail($email, $code){
    $message =  "
      <html>
        <head>
          <title>Verification Code</title>
        </head>
        <body>
          <h2>Thank you for Registering.</h2>
          <p>Your Account:</p>
          <p>Please click the link below to activate your account.</p>
          <h4><a href='".base_url('register/activate?email='.$email.'&code='.$code)."'>Activate My Account</a></h4>
        </body>
      </html>
    ";

    $fromEmail = "jan22uari@gmail.com";
    $isiEmail = "$message";
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->SMTPDebug = false;
    $mail->IsHTML(true);    // set email format to HTML
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host       = 'smtp.gmail.com';
    $mail->Port       = 587;
    $mail->Username   = $fromEmail;  // alamat email kamu
    $mail->Password   = "homecarenext";            // password GMail
    $mail->SetFrom('jan22uari@gmail.com', 'noreply');
    $mail->Subject    = "Verifikasi";
    $mail->Body       = $isiEmail;
    $toEmail = "$email"; // siapa yg menerima email ini
    $mail->AddAddress($toEmail);
    if(!$mail->Send()){
      return [
        'status' => false,
      ];
    }else{
      return [
        'status' => true
      ];
    }
  }

  private function generate_code(){
    $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   return substr(str_shuffle($set), 0, 12);
  }
}

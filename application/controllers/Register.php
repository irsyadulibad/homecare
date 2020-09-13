<?php
date_default_timezone_set('Etc/UTC');
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'third_party/PHPMailer.php';
require APPPATH.'third_party/SMTP.php';
require APPPATH.'third_party/Exception.php';

class Register extends CI_Controller {

 function __construct(){
  parent::__construct();
  $this->load->model('register_m');
  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->library('session');

 
        //get all users
  $this->data['[pengguna]'] = $this->register_m->getAllUsers();
 }

 public function index(){
    $this->load->view('login/template/head');
    $this->load->view('login/register', $this->data);
    $this->load->view('login/template/foot');
 }

 public function register(){
  $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required|min_length[4]');
  $this->form_validation->set_rules('email', 'Email', 'valid_email|required|is_unique[pengguna.email]');
  $this->form_validation->set_rules('username', 'Username', 'required|is_unique[pengguna.nama_pengguna]');
  $this->form_validation->set_rules('password', 'Password', 'required|min_length[7]|max_length[30]');
  $this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]');

  $this->form_validation->set_message('is_unique', '{field} Ini Sudah Dipakai');

  if ($this->form_validation->run() == FALSE) { 
    $this->load->view('login/template/head');
    $this->load->view('login/register', $this->data);
    $this->load->view('login/template/foot');
  }
  else{


    
   //get user inputs
   $email = $this->input->post('email');
   $password = $this->input->post('password');
   $username = $this->input->post('username');
   $namalengkap = $this->input->post('fullname');

   //generate simple random code
   $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $code = substr(str_shuffle($set), 0, 12);

   //insert user to users table and get id
   $user['email'] = $email;
   $user['password'] = sha1($password);
   $user['nama_lengkap'] = $namalengkap;
   $user['nama_pengguna'] = $username;
   $user['code'] = $code;
   $user['role'] = '3';
   $user['active'] = false;
   $id = $this->register_m->insert($user);

  
   

$message =  "
          <html>
          <head>
              <title>Verification Code</title>
          </head>
          <body>
              <h2>Thank you for Registering.</h2>
              <p>Your Account:</p>
              <p>Please click the link below to activate your account.</p>
              <h4><a href='".base_url()."register/activate/".$id."/".$code."'>Activate My Account</a></h4>
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
          if(!$mail->Send()) {
              echo "Eror: ".$mail->ErrorInfo;
          } else {
            $this->session->set_flashdata('message','Kode aktivasi telah dikirimkan pada email');
      redirect('register');
         }
        }
    }

 public function activate(){
  $id =  $this->uri->segment(3);
  $code = $this->uri->segment(4);

  //fetch user details
  $user = $this->register_m->getUser($id);

  //if code matches
  if($user['code'] == $code){
   //update user active status
   $data['active'] = true;
   $query = $this->register_m->activate($data, $id);

   if($query){
    $this->session->set_flashdata('message', 'User activated successfully');
   }
   else{
    $this->session->set_flashdata('message', 'Something went wrong in activating account');
   }
  }
  else{
   $this->session->set_flashdata('message', 'Cannot activate account. Code didnt match');
  }
  redirect('auth/login');

 }

 
}

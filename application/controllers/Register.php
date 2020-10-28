<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->model('register_m');
  }

  public function index(){
    if(!$this->form_validation->run('user_register')){
      $this->load->view('login/template/head');
      $this->load->view('login/register');
      $this->load->view('login/template/foot');
    }else{
      $res = $this->register_m->do_register();
      $this->session->set_flashdata('swal', $res);

      redirect('auth/login');
    }
  }

  public function activate(){
    $email = $this->input->get('email', true);
    $code = $this->input->get('code', true);

    $res = $this->register_m->do_activate($email, $code);
    $this->session->set_flashdata('swal', $res);

    redirect('auth/login');
  }
}

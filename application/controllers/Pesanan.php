<?php
class Pesanan extends CI_Controller{
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model('pesanan_m');
    $this->load->model('invoice_m');
    $this->load->model('obat_m');
  }

  public function index(){
    $user = $this->fungsi->user_login();

    switch($user['status']){
      case 'user':
        redirect('pesanan/diuser');
        break;
      case 'admin':
        redirect('invoice');
        break;
      case 'medis':
        redirect('pesanan/dimedis');
        break;
      case 'paramedis':
        redirect('pesanan/dimedis');
        break;
    }

  }

  public function diuser(){
    $user = $this->fungsi->user_login();
    // Cek apakah status user telah sesuai
    if($user['status'] != 'user'){
      $this->session->set_flashdata('swal', [
        'type' => 'warning',
        'msg' => 'Maaf, halaman ini hanya untuk pengguna'
      ]);

      redirect('pesanan');
    }

    $data = [
      'invoices' => $this->invoice_m->get_by_userid($user['id_pengguna']),
      'user' => $user
    ];

    $this->template->load('template2', 'pesanan/pesananuser', $data);
  }

  public function batal($id = null){
    if(is_null($id)) redirect('pesanan');
    $invoice = $this->invoice_m->get($id);

    if(is_null($invoice)) redirect('pesanan');
    if($invoice['status'] != 'pending') redirect('pesanan');

    $res = $this->invoice_m->cancel($id);
    $this->session->set_flashdata('swal', $res);

    redirect('pesanan/diuser');
  }
}


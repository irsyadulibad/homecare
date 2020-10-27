<?php
class Pesanan extends CI_Controller{
  function __construct(){
    parent::__construct();
    check_not_login();
    $this->load->model('pesanan_m');
    $this->load->model('invoice_m');
    $this->load->model('obat_m');
    $this->load->model('user_m');
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

  public function dimedis(){
    $user = $this->fungsi->user_login();

    $data = [
      'invoices' => $this->invoice_m->get_by_medis($user['id_medis']),
      'head' => 'Daftar Pesanan'
    ];

    $this->template->load('template2', 'pesanan/pesanandimedis', $data);
  }

  public function selesai($id = null){
    $this->load->model('alamat_m');
    $user = $this->fungsi->user_login();
    if(is_null($id)) redirect('pesanan/dimedis');

    $invoice = $this->invoice_m->get($id);
    if(is_null($invoice) || $invoice['id_medis'] != $user['id_medis']){
      redirect('');
    }

    $this->form_validation->set_rules('id', 'ID', 'required');
    if(!$this->form_validation->run()){
      $data = [
        'head' => 'Selesaikan Pesanan',
        'invoice' => $invoice,
        'pesanans' => $this->pesanan_m->get_by_invoice($id),
        'medis' => $user
      ];

      $this->template->load('template2', 'pesanan/pesananselesai', $data);
    }

  }

  public function batal($id = null){
    $user = $this->fungsi->user_login();
    if(is_null($id)) redirect('pesanan');
    $invoice = $this->invoice_m->get($id);

    if(is_null($invoice)) redirect('pesanan');

    if($user['status'] == 'pengguna'){
      if($invoice['status'] != 'pending') redirect('pesanan');
    }

    $res = $this->invoice_m->cancel($user, $id);
    $prev = $this->input->get('prev', true);
    $this->session->set_flashdata('swal', $res);

    redirect("pesanan/$prev");
  }
}


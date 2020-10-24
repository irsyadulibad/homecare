<?php

class Cart extends CI_Controller{

  function __construct(){
    parent::__construct();
    $this->load->model('cart_m');
    $this->load->model('layanan_m');
    $this->load->model('invoice_m');
    check_not_login();
  }

  function index(){
    $data = [
      'services' => $this->layanan_m->get(),
      'modal' => 'cart',
      'head' => 'Pilih Layanan',
      'rowids' => $this->cart_m->rowids()
    ];

    $this->template->load('template2','cart/v_cart',$data);
  }

  function add(){
    $id = $this->input->post('id');
    $layanan = $this->layanan_m->get($id);

    if(is_null($layanan)){
      echo json_encode([
        'status' => 'error',
        'msg' => 'Layanan tidak ditemukan'
      ]);
    }else{
      $rowid = $this->input->post('rowid', true);

      $res = $this->cart_m->add($layanan);
      echo json_encode($res);
    }
  }

  public function delete(){
    $rowid = $this->input->post('rowid', true);
    $id = $this->input->post('id', true);

    $res = $this->cart_m->delete($rowid, $id);
    echo $res;
  }

  public function show_html(){
    echo $this->cart_m->show();
  }

  function checkout() {
    $user = $this->fungsi->user_login();

    if($user['id_alamat'] == null){
      $this->session->set_flashdata('swal', [
        'type' => 'error',
        'msg' => 'Silahkan mengisi alamat terlebih dahulu'
      ]);
      redirect('profile/editaddr');
    }

    if($this->cart->total_items() < 1){
      $this->session->set_flashdata('swal', [
        'type' => 'error',
        'msg' => 'Silahkan memilih layanan terlebih dahulu'
      ]);
      redirect('cart');
    }

    if(!$this->form_validation->run('checkout')){
      $data = [
        'head' => 'Checkout Pesanan',
        'user' => $user
      ];

      $this->template->load('template2', 'cart/bayar', $data);
    }

  }
}

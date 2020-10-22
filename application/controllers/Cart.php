<?php

class Cart extends CI_Controller{

  function __construct(){
    parent::__construct();
    $this->load->model('cart_m');
    $this->load->model('pesanan_m');
    $this->load->model('layanan_m');
    $this->load->model('user_m');
    $this->load->model('invoice_m');
    $this->load->model('obat_m');
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
    if(is_null($user->alamat)){
      $this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Alamat masih belum diisi']);
      redirect('profile/edit');
    }

    if($this->cart->total_items() < 1){
      $this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Keranjang belanja masih kosong']);
      redirect('cart');
    }
    $this->form_validation->set_rules('tgl_kunjungan', 'Tgl Kunjungan', 'required');
    $this->form_validation->set_rules('jam_kunjungan', 'Jam Kunjungan', 'required');

    if($this->form_validation->run() == false){
      $data['layanan'] = $this->layanan_m->getlay();
      $data['user'] = $user;
      $id = $user->id_pengguna;
      $data['head'] = "Checkout Pesanan";
      $this->template->load('template2','cart/bayar',$data);
    }else{
      $fee = $this->cart_m->coverage_check($user);
      if(!$fee){
        $this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Daerah anda belum tercover']);
        redirect('cart/checkout');
      }
      $res = $this->cart_m->checkout($fee);
      if($res > 0){
        $this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Berhasil membuat pesanan']);
      }else{
        $this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Gagal membuat pesanan']);
      }
      $role = $this->fungsi->user_login()->role;
      if($role == 3){
        redirect('pesanan/diuser');
      }else{
        redirect('invoice');
      }
    }
  }
}

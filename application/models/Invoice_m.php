<?php

class Invoice_m extends CI_model{
  private $table = 'invoice';

  public function total(){
    return count($this->db->get($this->table)->result_array());
  }

  public function get_pending(){
    return $this->db->get($this->table)->result_array();
  }

  public function add_invoice($user){
    $bObat = $this->get_biaya_obat();
    $bLayanan = $this->get_biaya_layanan();

    $data = [
      'id_pengguna' => $user['id_pengguna'],
      'status' => 'pending',
      'biaya_lain' => 0,
      'biaya_obat' => $bObat,
      'total' => $bObat + $bLayanan
    ];

    $this->db->insert($this->table, $data);
    $id = $this->db->insert_id();

    $this->add_pesanan($id);

    return [
      'type' => 'success',
      'msg' => 'Berhasil menambahkan pesanan'
    ];
  }

  private function get_biaya_obat(){
    $this->load->model('obat_m');
    $obats = $this->session->userdata('obat');
    $price = 0;

    foreach($obats as $id => $total){
      $obat = $this->obat_m->getObat($id);
      $price += intval($obat['harga']) * $total;
    }

    return $price;
  }

  private function get_biaya_layanan(){
    $carts = $this->cart->contents();
    $price = 0;

    foreach($carts as $cart){
      $price += $cart['subtotal'];
    }

    return $price;
  }

  private function add_pesanan($id_invoice){
    $this->load->model('pesanan_m');
    $carts = $this->cart->contents();
    $data = [];

    foreach($carts as $cart){
      $name = $this->cart_m->reverse_name($cart['name']);
      $data[] = [
        'id_invoice' => $id_invoice,
        'id_layanan' => $cart['id'],
        'nama_layanan' => $name,
        'jumlah' => $cart['qty'],
        'harga' => $cart['price']
      ];
    }

    return $this->pesanan_m->insert($data);
  }
}

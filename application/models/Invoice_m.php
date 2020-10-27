<?php

class Invoice_m extends CI_model{
  private $table = 'invoice';

  public function total(){
    return count($this->db->get($this->table)->result_array());
  }

  public function get($id = null){
    if(!is_null($id)){
      return $this->db->get_where($this->table, [
        'id_invoice' => $id
      ])->row_array();
    }else{
      return $this->db->get($this->table)->result_array();
    }
  }

  public function get_by_userid($id){
    return $this->db->get_where($this->table, [
      'id_pengguna' => $id
    ])->result_array();
  }

  public function get_by_medis($id){
    return $this->db->get_where($this->table, [
      'id_medis' => $id
    ])->result_array();
  }

  public function get_pending(){
    return $this->db->get_where($this->table, [
      'status' => 'pending'
    ])->result_array();
  }

  public function cancel($user, $id){
    if($user['status'] == 'user'){
      $this->restock_obat($id);
      $this->db->delete($this->table, [
        'id_invoice' => $id
      ]);
    }else{
      $data = [
        'id_medis' => null,
        'id_biayajalan' => null,
        'status' => 'pending'
      ];

      $this->db->update($this->table, $data, [
        'id_invoice' => $id
      ]);
    }

    if($this->db->affected_rows() > 0){
      return [
        'type' => 'success',
        'msg' => 'Berhasil membatalkan pesanan'
      ];
    }else{
      return [
        'type' => 'error',
        'msg' => 'Gagal membatalkan pesanan'
      ];
    }

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

    $this->ambilstok_obat();
    $this->add_pesanan($id);
    $this->unset_session();

    return [
      'type' => 'success',
      'msg' => 'Berhasil menambahkan pesanan'
    ];
  }

  public function accept_invoice($medis, $invoice){
    $user = $this->user_m->get($invoice['id_pengguna']);
    $bJalan = $this->alamat_m->get_biaya_jalan($medis['id_alamat'], $user['id_alamat']);

    $data = [
      'id_medis' => $medis['id_medis'],
      'id_biayajalan' => $bJalan['id_biayajalan'],
      'status' => 'accepted'
    ];

    $this->db->update('invoice', $data, [
      'id_invoice' => $invoice['id_invoice']
    ]);

    if($this->db->affected_rows() > 0){
      return [
        'type' => 'success',
        'msg' => 'Berhasil menerima pesanan',
        'rdr' => 'pesanan/dimedis'
      ];
    }else{
      return [
        'type' => 'error',
        'msg' => 'Gagal menerima pesanan',
        'rdr' => 'homecare'
      ];
    }

  }

  public function check_accept_status($user, $pesanans){
    $layanan = $this->layanan_m->get($pesanans[0]['id_layanan']);
    
    if($user['status'] != $layanan['status']){
      return false;
    }

    return true;
  }

  // Khusus untuk manage pesanan lainnya
  public function add_biaya_lain($invoice, $biaya){
    $this->db->update($this->table, [
      'biaya_lain' => $invoice['biaya_lain'] + $biaya,
      'total' => $invoice['total'] + $biaya
    ], [
      'id_invoice' => $invoice['id_invoice']
    ]);

    return $this->db->affected_rows();
  }

  public function del_biaya_lain($invoice, $biaya){
    $this->db->update($this->table, [
      'biaya_lain' => $invoice['biaya_lain'] - $biaya,
      'total' => $invoice['total'] - $biaya
    ], [
      'id_invoice' => $invoice['id_invoice']
    ]);

    return $this->db->affected_rows();
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

  private function ambilstok_obat(){
    $carts = $this->cart->contents();

    foreach($carts as $cart){
      $id = $cart['id'];
      $obats = $this->obat_m->get_default_relation($id);
      
      foreach($obats as $obat){
        $this->obat_m->ambilStok($obat['id_obat'], $cart['qty']);
      }

    }

  }

  private function restock_obat($id){
    $pesanans = $this->pesanan_m->get_by_invoice($id);
    foreach($pesanans as $pesanan){

      $id = $pesanan['id_layanan'];
      $obats = $this->obat_m->get_default_relation($id);
      
      foreach($obats as $obat){
        $this->obat_m->reStok($obat['id_obat'], $pesanan['jumlah']);
      }

    }

  }

  private function unset_session(){
    $this->cart->destroy();
    $this->session->unset_userdata('obat');

    return true;
  }
}

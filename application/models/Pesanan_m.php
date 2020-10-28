<?php
class Pesanan_m extends CI_Model{
  private $table = 'pesanan';

  public function insert($data){
    $this->db->insert_batch($this->table, $data);

    if($this->db->affected_rows() > 0 ){
      return ['status' => true];
    }else{
      return ['status' => false];
    }

  }

  public function get_by_invoice($id_invoice){
    return $this->db->get_where($this->table, [
      'id_invoice' => $id_invoice
    ])->result_array();
  }

  public function add_lainnya($invoice){
    $harga = $this->input->post('price', true);
    $jumlah = $this->input->post('qty', true);
    $id = $invoice['id_invoice'];

    $data = [
      'id_invoice' => $id,
      'nama' => $this->input->post('name', true),
      'harga_satuan' => $harga,
      'jumlah' => $jumlah,
      'total' => $harga * $jumlah
    ];

    $this->db->insert('pesanan_lainnya', $data);

    if($this->db->affected_rows() > 0){
      $this->invoice_m->add_biaya_lain($invoice, $data['total']);

      return [
        'type' => 'success',
        'msg' => 'Berhasil menambahkan pesanan lainnya'
      ];
    }else{
      return [
        'type' => 'error',
        'msg' => 'Gagal menambahkan pesanan lainnya'
      ];
    }

  }

  public function del_lainnya($pesanan){
    $invoice = $this->invoice_m->get($pesanan['id_invoice']);

    $this->db->delete('pesanan_lainnya', [
      'id' => $pesanan['id']
    ]);

    if($this->db->affected_rows() > 0){
      $this->invoice_m->del_biaya_lain($invoice, $pesanan['total']);

      return [
        'type' => 'success',
        'msg' => 'Berhasil menghapus pesanan lainnya'
      ];
    }else{
      return [
        'type' => 'error',
        'msg' => 'Gagal menghapus pesanan lainnya'
      ];
    }

  }

  public function del_lainnya_by_invoice($id){
    $pesanans = $this->get_lainnya($id);

    foreach($pesanans as $pesanan){
      $this->del_lainnya($pesanan);
    }

    return true;
  }

  public function get_lainnya($id){
    return $this->db->get_where('pesanan_lainnya', [
      'id_invoice' => $id
    ])->result_array();
  }

  public function get_lainnya_byid($id){
    return $this->db->get_where('pesanan_lainnya', [
      'id' => $id
    ])->row_array();
  }

  public function get_layanan($id){
    return $this->db->get_where('pesanan', ['id_invoice' => $id])->result_array();
  }
}

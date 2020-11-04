<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan_m extends CI_Model {
  private $table = 'layanan';

  public function get($id = false){
    if(!$id){
      return $this->db->get($this->table)->result_array();
    }else{
      $this->db->where('id_layanan', $id);
      return $this->db->get($this->table)->row_array();
    }
  }

  public function get_by_status($status){
    return $this->db->get_where($this->table, [
      'status' => $status
    ])->result_array();
  }

  public function addlay(){
    $data = [
      'jenis_layanan' => $this->input->post('jenis_layanan', true),
      'keterangan' => $this->input->post('keterangan', true),
      'harga' => $this->input->post('harga', true),
      'status' => $this->input->post('status', true)
    ];

    $this->db->insert($this->table, $data);
    return $this->db->affected_rows();
  }

  public function dellay($id){
    $this->db->delete($this->table, ['id_layanan' => $id]);
    return $this->db->affected_rows();
  }

  public function edit($id){
    $data = [
      'jenis_layanan' => $this->input->post('jenis_layanan', true),
      'keterangan' => $this->input->post('keterangan', true),
      'harga' => $this->input->post('harga', true),
      'status' => $this->input->post('status', true)
    ];

    $this->db->update($this->table, $data, ['id_layanan' => $id]);
    return $this->db->affected_rows();
  }
}

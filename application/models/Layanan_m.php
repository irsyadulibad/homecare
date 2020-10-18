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

  public function addlay($post){
    $params ['jenis_layanan'] = $post['jenis_layanan'];
    $params ['keterangan'] = $post['keterangan'];
    $params ['harga'] = $post['harga'];
    $this->db->insert('layanan',$params);
  }
  public function dellay($id){
    $this->db->where('id_layanan',$id);
    $this->db->delete('layanan');
  }
  public function edit($post, $id){
    $params ['jenis_layanan'] = $post['jenis_layanan'];
    $params ['keterangan'] = $post['keterangan'];
    $params ['harga'] = $post['harga'];
    $this->db->where('id_layanan', $id);
    $this->db->update('layanan',$params);
  }
  function get_data($table){
    $query= $this->db->get($table);
    return $query;
  }
  function get_datapel($table,$role){
    $this->db->where('role',$role);
    $query= $this->db->get($table);
    return $query;
  }
  function getrating(){
    $sql = "SELECT avg(rating) avgdata FROM ulasan";
    $query= $this->db->query($sql);
    return $query->row_array();
  }
  public function getlayx($idla){
    $this->db->from('layanan');
    $this->db->where('id_layanan', $id);
    $query = $this->db->get();
    return $query;

  }
}

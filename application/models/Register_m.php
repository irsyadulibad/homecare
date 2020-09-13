<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_m extends CI_Model {

 function __construct(){
  parent::__construct();
  $this->load->database();
 }

 public function getAllUsers(){
  $query = $this->db->get('pengguna');
  return $query->result(); 
 }

 public function insert($user){
  $this->db->insert('pengguna', $user);
  return $this->db->insert_id(); 
 }

 public function getUser($id){
  $query = $this->db->get_where('pengguna',array('id_pengguna'=>$id));
  return $query->row_array();
 }

 public function activate($data, $id){
  $this->db->where('pengguna.id_pengguna', $id);
  return $this->db->update('pengguna', $data);
 }

}
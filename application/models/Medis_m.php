<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medis_m extends CI_Model{
	private $table = 'medis';

	public function __construct(){
		parent::__construct();
	}

	public function login($email, $pass){
		$data = [
			'email' => $email,
			'password' => sha1($pass)
		];

		return $this->db->get_where($this->table, $data)->row_array();
	}

	public function get($id = null){
		$data = [
			'id_medis' => $id
		];

		if(is_null($id)){
      return $this->db->get($this->table)->result_array();
    }else{
      return $this->db->get_where($this->table, $data)->row_array();
    }	
	}

	public function total(){
		$data = [
			'status' => 'medis',
			'status' => 'paramedis'
		];

		return count($this->db->get_where($this->table, $data)->result_array());
	}

	public function edit($id, $pass = false){
    $data = [
      'nama_lengkap' => $this->input->post('fullname', true),
      'no_hp' => $this->input->post('nohp', true),
      'jenis_kelamin' => $this->input->post('jenkel', true),
      'status' => $this->input->post('level', true),
      'email' => $this->input->post('email', true),
    ];

    if($pass) $data['password'] = sha1($this->input->post('password', true));

    $this->db->update($this->table, $data, ['id_medis' => $id]);
    return $this->db->affected_rows();
  }

	public function delete($id){
		$this->db->delete($this->table, ['id_medis' => $id]);

    return $this->db->affected_rows();
	}
}

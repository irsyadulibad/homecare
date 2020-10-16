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

		return $this->db->get_where($this->table, $data)->row_array();
	}

	public function total(){
		$data = [
			'status' => 'medis',
			'status' => 'paramedis'
		];

		return count($this->db->get_where($this->table, $data)->result_array());
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ongkir_m extends CI_Model{
	private $table = 'biayajalan';

	public function get($id = false){
		if(!$id){
			return $this->db->get($this->table)->result_array();
		}else{
			$this->db->where('id_biayajalan', $id);
			return $this->db->get($this->table)->row_array();
		}
	}

	public function tambah(){
		$data = [
			'jarak_awal' => $this->input->post('jarak_awal', true),
			'jarak_akhir' => $this->input->post('jarak_akhir', true),
			'biaya' => $this->input->post('biaya', true),
			'keterangan' => $this->input->post('keterangan', true)
		];

		$this->db->insert($this->table, $data);
		return $this->db->affected_rows();
	}

	public function edit($id){
		$data = [
			'jarak_awal' => $this->input->post('jarak_awal', true),
			'jarak_akhir' => $this->input->post('jarak_akhir', true),
			'biaya' => $this->input->post('biaya', true),
			'keterangan' => $this->input->post('keterangan', true)
		];

		$this->db->update($this->table, $data, ['id_biayajalan' => $id]);
		return $this->db->affected_rows();
	}

	public function delete($id){
		$this->db->delete($this->table, ['id_biayajalan' => $id]);
		return $this->db->affected_rows();
	}
}

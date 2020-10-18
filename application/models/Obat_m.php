<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat_m extends CI_Model {
	private $table = 'obat';

	public function getObat($id = false){
		$this->db->order_by('nama', 'ASC');

		if(!$id){
			return $this->db->get($this->table)->result_array();
		}else{
			$this->db->where('id_obat', $id);
			return $this->db->get($this->table)->row_array();
		}
	}

	public function add(){
		$name = $this->input->post('name', true);
		$price = $this->input->post('price', true);
		$stock = $this->input->post('stock', true);
		$data = [
			'nama' => $name,
			'harga' => $price,
			'stok' => $stock
		];

		$this->db->insert('obat', $data);
		return $this->db->affected_rows();
	}

	public function edit($id){
		$data = [
			'nama' => $this->input->post('name', true), 
			'harga' => $this->input->post('price', true)
		];

		$this->db->update('obat', $data, ['id_obat' => $id]);
		return $this->db->affected_rows();
	}

	public function delete($id){
		$this->db->delete($this->table, ['id_obat' => $id]);

		return $this->db->affected_rows();
	}

	public function uStock($id){
		$data = [
			'stok' => $this->input->post('stock', true)
		];
		
		$this->db->update($this->table, $data, ['id_obat' => $id]);
		return $this->db->affected_rows();
	}

	public function cek_stok(){
		$id = $this->input->post('id', true);
		$sess = $this->session->userdata('obat');
		$stocks = [];
		$obats = $this->db->get_where('lay_ob', ['id_layanan' => $id])->result_array();
		foreach($obats as $obat){
			$id_obat = intval($obat['id_obat']);
			$stock = $this->db->get_where('obat', ['id_obat' => $obat['id_obat']])->row_array()['stok'];
			$stocks[] = isset($sess[$id_obat]) ? $stock - $sess[$id_obat] : $stock;
		}
		foreach ($stocks as $stock) {
			if($stock < 1) return 0;
		}

		if(empty($stocks)) return 0;
		return 1;
	}

	public function ambilStok($id, $qty){
		$obat = $this->db->get_where('obat', ['id_obat' => $id])->row_array();
		$stok = intval($obat['stok']) - intval($qty);
		$this->db->update('obat', ['stok' => $stok], ['id_obat' => $id]);
	}

	public function reStok($id, $qty){
		$obat = $this->db->get_where('obat', ['id_obat' => $id])->row_array();
		$stok = intval($obat['stok']) + intval($qty);
		$this->db->update('obat', ['stok' => $stok], ['id_obat' => $id]);
	}

	public function set_default($id, $obat){
		$exist = $this->db->get_where('obat_layanan', [
			'id_layanan' => $id,
			'id_obat' => $obat
		])->row_array();

		if(!empty($exist)) return [
			'status' => 'error',
			'msg' => 'Obat sudah default'
		];

		$data = [
			'id_layanan' => $id,
			'id_obat' => $obat
		];

		$this->db->insert('obat_layanan', $data);

		if($this->db->affected_rows() > 0){
			$items = $this->get_default_relation($id);
			return [
				'status' => 'success',
				'msg' => 'Berhasil menambah data',
				'items' => $items
			];
		}else{
			return [
				'status' => 'error',
				'msg' => 'Gagal menyimpan data'
			];
		}
	}

	public function delete_default($id){
		$this->db->delete('obat_layanan', ['id_obat_layanan' => $id]);

		return $this->db->affected_rows();
	}

	public function get_default_relation($id_layanan = null){
		$this->db->select('obat.id_obat, id_layanan, layob.id_obat_layanan, layob.id_obat, obat.nama');
		$this->db->from('obat_layanan as layob');
		$this->db->join('obat', 'layob.id_obat = obat.id_obat');

		if(!is_null($id_layanan)) $this->db->where('id_layanan', $id_layanan);
		return $this->db->get()->result_array();
	}
}

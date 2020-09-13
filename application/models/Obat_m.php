<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat_m extends CI_Model {
	public function getObat($id=null){
		$this->db->select('*');
		$this->db->from('obat');
		if(!is_null($id)) $this->db->where('id_obat', $id);
		$this->db->order_by('nama', 'ASC');
		$result = $this->db->get();
		return (is_null($id)) ? $result->result_array() : $result->row_array();
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
		$name = $this->input->post('name', true);
		$price = $this->input->post('price', true);

		$data = ['nama' => $name, 'harga' => $price];
		$this->db->update('obat', $data, ['id_obat' => $id]);
		return $this->db->affected_rows();
	}

	public function uStock($id){
		$stock = $this->input->post('stock', true);
		$this->db->update('obat', ['stok' => $stock], ['id_obat' => $id]);
		return $this->db->affected_rows();
	}

	public function getLayanan(){
		return $this->db->get('layanan')->result_array();
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
		$exist = $this->db->get_where('lay_ob', ['id_layanan' => $id, 'id_obat' => $obat])->row_array();
		if(!empty($exist)) return ['status' => 'error', 'msg' => 'Obat sudah default'];
		$data = [
			'id_layanan' => $id,
			'id_obat' => $obat
		];
		$this->db->insert('lay_ob', $data);
		if($this->db->affected_rows() > 0){
			$items = $this->get_default_relation($id);
			return ['status' => 'success', 'msg' => 'Berhasil menambah data', 'items' => $items];
		}else{
			return ['status' => 'error', 'msg' => 'Gagal menyimpan data'];
		}
	}

	public function get_default_relation($id_layanan=null){
		$this->db->select('id, id_layanan, lay_ob.id_obat, obat.nama');
		$this->db->from('lay_ob');
		$this->db->join('obat', 'lay_ob.id_obat = obat.id_obat');
		if(!is_null($id_layanan)) $this->db->where('id_layanan', $id_layanan);
		return $this->db->get()->result_array();
	}
}
